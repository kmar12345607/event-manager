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
                'event_date' => '2026-07-10 09:00:00',
                'location' => 'Tunis, ESPRIT',
                'description' => 'Conférence annuelle sur les nouvelles technologies : IA, cloud et cybersécurité.',
                'max_participants' => 100,
                'status' => 'upcoming',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Workshop Laravel',
                'event_date' => '2026-07-15 14:00:00',
                'location' => 'Tunis, Centre de formation',
                'description' => 'Atelier pratique sur Laravel 11 : Eloquent, Blade et bonnes pratiques.',
                'max_participants' => 30,
                'status' => 'upcoming',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Hackathon ESPRIT',
                'event_date' => '2026-06-20 08:00:00',
                'location' => 'ESPRIT, Salle informatique',
                'description' => 'Compétition de développement 24h en équipe sur des projets innovants.',
                'max_participants' => 50,
                'status' => 'completed',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Meetup DevOps Tunisie',
                'event_date' => '2026-07-22 18:00:00',
                'location' => 'Sousse, Technopole',
                'description' => "Rencontre autour de Docker, Kubernetes et l'intégration continue.",
                'max_participants' => 60,
                'status' => 'upcoming',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Journée Portes Ouvertes ESPRIT',
                'event_date' => '2026-06-05 09:00:00',
                'location' => 'ESPRIT, Campus principal',
                'description' => 'Présentation des filières et rencontre avec les étudiants et enseignants.',
                'max_participants' => 300,
                'status' => 'completed',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Formation UI/UX Design',
                'event_date' => '2026-07-05 10:00:00',
                'location' => 'Tunis, Coworking Hub',
                'description' => "Introduction à Figma et aux principes de design d'interface.",
                'max_participants' => 25,
                'status' => 'ongoing',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Soirée Networking Startups',
                'event_date' => '2026-08-01 19:00:00',
                'location' => 'Tunis, La Marsa',
                'description' => 'Rencontre entre porteurs de projets, investisseurs et mentors.',
                'max_participants' => 80,
                'status' => 'upcoming',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Coupe Interne de Football ESPRIT',
                'event_date' => '2026-06-15 16:00:00',
                'location' => 'ESPRIT, Terrain de sport',
                'description' => 'Tournoi sportif inter-classes annulé pour cause de météo.',
                'max_participants' => 120,
                'status' => 'cancelled',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
