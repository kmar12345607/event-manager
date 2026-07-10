<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ParticipantSeeder extends Seeder
{
    public function run(): void
    {
        // Idem : on repart d'une table vide pour rester cohérent avec les
        // identifiants d'événements (1 à 8) réinsérés par EventSeeder.
        DB::table('participants')->truncate();

        DB::table('participants')->insert([
            // Conférence Tech 2026 (event_id 1)
            ['event_id' => 1, 'full_name' => 'Kmar Srarfi', 'email' => 'kmar@esprit.tn', 'phone' => '20000001', 'registration_date' => '2026-06-11', 'attendance_status' => 'registered', 'notes' => null, 'created_at' => now(), 'updated_at' => now()],
            ['event_id' => 1, 'full_name' => 'Ahmed Ben Ali', 'email' => 'ahmed@email.com', 'phone' => '20000002', 'registration_date' => '2026-06-11', 'attendance_status' => 'present', 'notes' => 'VIP', 'created_at' => now(), 'updated_at' => now()],
            ['event_id' => 1, 'full_name' => 'Mariem Gharbi', 'email' => 'mariem.gharbi@email.com', 'phone' => '22111222', 'registration_date' => '2026-06-12', 'attendance_status' => 'registered', 'notes' => null, 'created_at' => now(), 'updated_at' => now()],

            // Workshop Laravel (event_id 2)
            ['event_id' => 2, 'full_name' => 'Sana Trabelsi', 'email' => 'sana@email.com', 'phone' => '20000003', 'registration_date' => '2026-06-11', 'attendance_status' => 'absent', 'notes' => null, 'created_at' => now(), 'updated_at' => now()],
            ['event_id' => 2, 'full_name' => 'Yassine Karray', 'email' => 'yassine.karray@email.com', 'phone' => '25333444', 'registration_date' => '2026-06-13', 'attendance_status' => 'registered', 'notes' => null, 'created_at' => now(), 'updated_at' => now()],

            // Hackathon ESPRIT (event_id 3, terminé)
            ['event_id' => 3, 'full_name' => 'Firas Jendoubi', 'email' => 'firas.jendoubi@esprit.tn', 'phone' => '27555666', 'registration_date' => '2026-06-01', 'attendance_status' => 'present', 'notes' => 'Équipe gagnante', 'created_at' => now(), 'updated_at' => now()],
            ['event_id' => 3, 'full_name' => 'Nour Chaabane', 'email' => 'nour.chaabane@esprit.tn', 'phone' => '29777888', 'registration_date' => '2026-06-01', 'attendance_status' => 'present', 'notes' => null, 'created_at' => now(), 'updated_at' => now()],
            ['event_id' => 3, 'full_name' => 'Oussama Rekik', 'email' => 'oussama.rekik@esprit.tn', 'phone' => '21999000', 'registration_date' => '2026-06-02', 'attendance_status' => 'absent', 'notes' => null, 'created_at' => now(), 'updated_at' => now()],

            // Meetup DevOps Tunisie (event_id 4)
            ['event_id' => 4, 'full_name' => 'Hela Mbarki', 'email' => 'mbarkihela1@gmail.com', 'phone' => '23444555', 'registration_date' => '2026-06-20', 'attendance_status' => 'registered', 'notes' => null, 'created_at' => now(), 'updated_at' => now()],

            // Journée Portes Ouvertes ESPRIT (event_id 5, terminé)
            ['event_id' => 5, 'full_name' => 'Emna Baccouche', 'email' => 'emna.baccouche@email.com', 'phone' => '24666777', 'registration_date' => '2026-05-20', 'attendance_status' => 'present', 'notes' => null, 'created_at' => now(), 'updated_at' => now()],
            ['event_id' => 5, 'full_name' => 'Walid Ammar', 'email' => 'walid.ammar@email.com', 'phone' => '26888999', 'registration_date' => '2026-05-21', 'attendance_status' => 'present', 'notes' => null, 'created_at' => now(), 'updated_at' => now()],
            ['event_id' => 5, 'full_name' => 'Rania Ferjani', 'email' => 'rania.ferjani@email.com', 'phone' => '28000111', 'registration_date' => '2026-05-22', 'attendance_status' => 'absent', 'notes' => null, 'created_at' => now(), 'updated_at' => now()],

            // Formation UI/UX Design (event_id 6, en cours)
            ['event_id' => 6, 'full_name' => 'Ines Sahli', 'email' => 'ines.sahli@email.com', 'phone' => '29222333', 'registration_date' => '2026-06-25', 'attendance_status' => 'present', 'notes' => null, 'created_at' => now(), 'updated_at' => now()],
            ['event_id' => 6, 'full_name' => 'Karim Zouari', 'email' => 'karim.zouari@email.com', 'phone' => '25444555', 'registration_date' => '2026-06-26', 'attendance_status' => 'registered', 'notes' => null, 'created_at' => now(), 'updated_at' => now()],

            // Soirée Networking Startups (event_id 7)
            ['event_id' => 7, 'full_name' => 'Amira Dhaoui', 'email' => 'amira.dhaoui@email.com', 'phone' => '27666777', 'registration_date' => '2026-06-28', 'attendance_status' => 'registered', 'notes' => 'Porteuse de projet', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
