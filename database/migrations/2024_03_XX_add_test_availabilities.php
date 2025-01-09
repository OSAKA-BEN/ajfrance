<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\Availability;

return new class extends Migration
{
    public function up(): void
    {
        // Récupérer tous les professeurs
        $teachers = User::where('role', 'teacher')->get();

        foreach ($teachers as $teacher) {
            // Créer des disponibilités du lundi au vendredi, de 9h à 17h
            for ($day = 1; $day <= 5; $day++) {
                Availability::create([
                    'user_id' => $teacher->id,
                    'day_of_week' => $day,
                    'start_time' => '09:00:00',
                    'end_time' => '17:00:00',
                ]);
            }
        }
    }

    public function down(): void
    {
        // Supprimer toutes les disponibilités
        Availability::truncate();
    }
}; 