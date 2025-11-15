<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class AIService
{
    public function ask(string $prompt): array
    {
        // Exemplo simples: chama a API com Http facade
        $resp = Http::withToken(config('services.openai.key'))
            ->post(config('services.openai.url') . '/chat/completions', [
                'model' => 'gpt-4o-mini',
                'messages' => [
                    ['role' => 'user', 'content' => $prompt],
                ],
            ]);

        if (! $resp->successful()) {
            throw new \Exception('Erro na API: ' . $resp->body());
        }

        return $resp->json();
    }
}
