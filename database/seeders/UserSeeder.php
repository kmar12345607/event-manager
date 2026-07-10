<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Compte administrateur par défaut
        User::updateOrCreate(
            ['email' => 'admin@eventmanager.tn'],
            [
                'name'              => 'Administrateur',
                'password'          => Hash::make('password'),
                'role'              => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // Compte participant de démonstration
        User::updateOrCreate(
            ['email' => 'participant@eventmanager.tn'],
            [
                'name'              => 'Participant Démo',
                'password'          => Hash::make('password'),
                'role'              => 'participant',
                'email_verified_at' => now(),
            ]
        );
    }
}
