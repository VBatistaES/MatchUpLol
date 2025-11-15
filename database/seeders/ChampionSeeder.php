<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChampionSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('champions')->insert([
            ['name' => 'Viego'],
            ['name' => 'Warwick'],
            ['name' => 'Ahri'],
            ['name' => 'Yasuo'],
            ['name' => 'Jinx'],
            ['name' => 'Leona'],
            ['name' => 'Lee Sin'],
        ]);
    }
}
