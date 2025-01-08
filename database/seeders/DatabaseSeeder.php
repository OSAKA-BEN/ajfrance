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
        User::create([
            'name' => 'Admin',
            'email' => 'admin@softui.com',
            'password' => Hash::make('secret'),
            'role' => 'admin',
            'credits' => 0,
            'address' => '123 Admin Street',
            'city' => 'Admin City',
            'state' => 'AS',
            'zipcode' => '00000',
            'country' => 'France'
        ]);

        // Créer le professeur
        User::create([
            'name' => 'Teacher',
            'email' => 'teacher@test.com',
            'password' => Hash::make('123*'),
            'role' => 'teacher',
            'address' => '123 Teacher Street',
            'city' => 'Teacher City',
            'state' => 'TS',
            'zipcode' => '12345',
            'country' => 'France'
        ]);

        // Créer 10 étudiants
        for ($i = 1; $i <= 10; $i++) {
            User::create([
                'name' => "Student $i",
                'email' => "student$i@test.com",
                'password' => Hash::make('123*'),
                'role' => 'student',
                'address' => "$i Student Avenue",
                'city' => 'Student City',
                'state' => 'SS',
                'zipcode' => "1000$i",
                'credits' => 2,
                'country' => 'France'
            ]);
        }

        // Créer 10 invités
        for ($i = 1; $i <= 10; $i++) {
            User::create([
                'name' => "Guest $i",
                'email' => "guest$i@test.com",
                'password' => Hash::make('123*'),
                'role' => 'guest',
                'address' => "$i Guest Boulevard",
                'city' => 'Guest City',
                'state' => 'GS',
                'zipcode' => "2000$i",
                'credits' => 2,
                'country' => 'France'
            ]);
        }
    }
}
