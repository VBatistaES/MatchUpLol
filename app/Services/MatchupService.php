<?php
namespace App\Services;

use App\Repositories\ChampionRepository;
use App\Models\Matchup;
use Illuminate\Support\Facades\Cache;

class MatchupService
{
    protected $ai;
    protected $champRepo;

    public function __construct(AIService $ai, ChampionRepository $champRepo)
    {
        $this->ai = $ai;
        $this->champRepo = $champRepo;
    }

    public function analyze(string $champion, string $opponent, string $lane): Matchup
    {
        $key = "matchup:{$champion}:{$opponent}:{$lane}";
        $result = Cache::get($key);

        if ($result) {
            // reconstruir model ou retorno já salvo
            return Matchup::create([
                'champion_name' => $champion,
                'opponent_name' => $opponent,
                'lane' => $lane,
                'response' => $result,
            ]);
        }

        $prompt = "Você é um especialista..."; // vamos melhorar depois
        $aiResponse = $this->ai->ask($prompt);

        // salvar no banco (exemplo simples)
        $matchup = Matchup::create([
            'champion_name' => $champion,
            'opponent_name' => $opponent,
            'lane' => $lane,
            'response' => $aiResponse,
        ]);

        Cache::put($key, $aiResponse, now()->addHours(6));

        return $matchup;
    }
}
