<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ParticipantSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('participants')->insert([
            [
                'event_id' => 1,
                'full_name' => 'Kmar Srarfi',
                'email' => 'kmar@esprit.tn',
                'phone' => '20000001',
                'registration_date' => '2026-06-11',
                'attendance_status' => 'registered',
                'notes' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'event_id' => 1,
                'full_name' => 'Ahmed Ben Ali',
                'email' => 'ahmed@email.com',
                'phone' => '20000002',
                'registration_date' => '2026-06-11',
                'attendance_status' => 'present',
                'notes' => 'VIP',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'event_id' => 2,
                'full_name' => 'Sana Trabelsi',
                'email' => 'sana@email.com',
                'phone' => '20000003',
                'registration_date' => '2026-06-11',
                'attendance_status' => 'absent',
                'notes' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}