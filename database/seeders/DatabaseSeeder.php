<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Créer l'administrateur
        User::factory()->admin()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('secret'),
        ]);

        // Créer 3 professeurs
        User::factory()->count(3)->teacher()->create([
            'password' => Hash::make('teacher123')
        ]);

        // Créer 5 étudiants
        User::factory()->count(5)->student()->create([
            'password' => Hash::make('student123')
        ]);

        // Créer 10 invités
        User::factory()->count(10)->guest()->create([
            'password' => Hash::make('guest123')
        ]);
    }
}
