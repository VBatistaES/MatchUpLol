<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matchup extends Model
{
    use HasFactory;

    protected $fillable = ['champion_id', 'enemy_champion_id', 'lane_id', 'strategy'];

    // Matchup pertence a um campeão
    public function champion()
    {
        return $this->belongsTo(Champion::class, 'champion_id');
    }

    // Matchup também pertence a um inimigo
    public function enemyChampion()
    {
        return $this->belongsTo(Champion::class, 'enemy_champion_id');
    }

    // Matchup pertence a uma rota
    public function lane()
    {
        return $this->belongsTo(Lane::class);
    }
}
