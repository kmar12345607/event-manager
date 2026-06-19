<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('events')->insert([
            [
                'name' => 'Conférence Tech 2026',
                'date' => '2026-07-10',
                'location' => 'Tunis, ESPRIT',
                'description' => 'Conférence annuelle sur les nouvelles technologies.',
                'max_participants' => 100,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Workshop Laravel',
                'date' => '2026-07-15',
                'location' => 'Tunis, Centre de formation',
                'description' => 'Atelier pratique sur Laravel 11.',
                'max_participants' => 30,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Hackathon ESPRIT',
                'date' => '2026-06-20',
                'location' => 'ESPRIT, Salle informatique',
                'description' => 'Compétition de développement 24h.',
                'max_participants' => 50,
                'status' => 'done',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}