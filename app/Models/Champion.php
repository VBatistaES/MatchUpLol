<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Champion extends Model
{
    use HasFactory;

    protected $fillable = ['name']; // Campos permitidos para inserção em massa

    // Um campeão pode ter vários matchups onde ele é o "meu campeão"
    public function matchups()
    {
        return $this->hasMany(Matchup::class, 'champion_id');
    }

    // Um campeão pode aparecer em vários matchups como "inimigo"
    public function enemyMatchups()
    {
        return $this->hasMany(Matchup::class, 'enemy_champion_id');
    }
}
