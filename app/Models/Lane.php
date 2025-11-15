<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lane extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    // Uma lane pode ter vários matchups
    public function matchups()
    {
        return $this->hasMany(Matchup::class);
    }
}
