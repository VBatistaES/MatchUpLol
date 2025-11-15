<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LaneSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('lanes')->insert([
            ['name' => 'Top'],
            ['name' => 'Jungle'],
            ['name' => 'Mid'],
            ['name' => 'ADC'],
            ['name' => 'Support'],
        ]);
    }
}
