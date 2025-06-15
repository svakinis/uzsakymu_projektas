<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Įrašome kelis miestus į cities lentelę
        DB::table('cities')->insert([
            ['name' => 'Vilnius'],
            ['name' => 'Kaunas'],
            ['name' => 'Klaipėda'],
            ['name' => 'Šiauliai'],
            ['name' => 'Panevėžys'],
        ]);
    }
}