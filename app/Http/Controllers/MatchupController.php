<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MatchupController extends Controller
{
    public function analyze(Request $request)
    {
        $request->validate([
            'champion' => 'required|string',
            'enemy' => 'required|string',
            'lane' => 'required|string',
        ]);

        // Allow this request to run long enough for the external API call
        // to complete (35s). Adjust as needed for production use.
        if (function_exists('set_time_limit')) {
            @set_time_limit(120);
        }

        $champion = $request->input('champion');
        $enemy = $request->input('enemy');
        $lane = $request->input('lane');

        $prompt = "Explique de forma curta e direta como jogar a matchup entre {$champion} contra {$enemy} na rota {$lane}.
                    A resposta deve ter APENAS três seções: Early Game, Mid Game e Late Game.
                    Cada seção deve conter no máximo 3 linhas.
                    Foque SOMENTE em: comportamento, posicionamento, movimentação, controle de wave e decisões estratégicas.
                    NÃO inclua builds, runas, itens, ordem de habilidades, combos, estatísticas ou descrição geral dos campeões.
                    Não escreva nada antes ou depois das três seções.
                    Formato obrigatório:

                    Early Game:
                    - ...

                    Mid Game:
                    - ...

                    Late Game:
                    - ...";
        $apiKey = env('GEMINI_API_KEY');
        if (empty($apiKey)) {
            return response()->json([
                'error' => 'Chave de API não configurada. Defina GEMINI_API_KEY no .env.'
            ], 500);
        }

        try {
            $modelId = 'gemini-2.5-flash';

            // Prepare Guzzle / Http options. If a local CA bundle exists at
            // storage/cacert.pem we use it (recommended for Windows/dev).
            $options = [
                'timeout' => 35,
            ];

            $caPath = storage_path('cacert.pem');
            if (file_exists($caPath)) {
                $options['verify'] = $caPath;
            }

            $response = Http::withOptions($options)->withHeaders([
                'Content-Type' => 'application/json',
                'x-goog-api-key' => $apiKey,
            ])->post('https://generativelanguage.googleapis.com/v1beta/models/' . $modelId . ':generateContent', [
                'contents' => [
                    ['parts' => [['text' => $prompt]]]
                ],
            ]);

            if ($response->failed()) {
                return response()->json([
                    'error' => 'Erro na API Gemini',
                    'details' => $response->body(),
                ], 500);
            }

            $data = $response->json();
            $analysis = $data['candidates'][0]['content']['parts'][0]['text']
                ?? ($data['candidates'][0]['output'] ?? json_encode($data));

            return response()->json([
                'champion' => $champion,
                'enemy' => $enemy,
                'lane' => $lane,
                'analysis' => $analysis,
            ]);
        } catch (\Exception $e) {
            $msg = $e->getMessage();
            if (stripos($msg, 'timed out') !== false || stripos($msg, 'cURL error 28') !== false) {
                return response()->json([
                    'error' => 'A requisição à API externa expirou (timeout). Tente novamente mais tarde.'
                ], 504);
            }

            return response()->json([
                'error' => 'Erro ao consultar a IA: ' . $e->getMessage(),
            ], 500);
        }
    }
}