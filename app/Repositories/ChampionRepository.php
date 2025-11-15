<?php
namespace App\Repositories;

use App\Models\Champion;

class ChampionRepository
{
    public function all()
    {
        return Champion::orderBy('name')->get();
    }

    public function findByName(string $name): ?Champion
    {
        return Champion::where('name', $name)->first();
    }
}
