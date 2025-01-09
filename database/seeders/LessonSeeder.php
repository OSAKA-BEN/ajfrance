<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Lesson;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class LessonSeeder extends Seeder
{
    public function run()
    {
        $teachers = User::where('role', 'teacher')->get();
        $students = User::whereIn('role', ['student', 'guest'])->get();
        
        if ($teachers->isEmpty() || $students->isEmpty()) {
            $this->command->info('Professeurs ou étudiants manquants. Création impossible des leçons.');
            return;
        }

        // Créer 20 leçons
        for ($i = 0; $i < 20; $i++) {
            $date = Carbon::now()->addDays(rand(-5, 30))->setHour(rand(8, 18))->setMinute(0);
            
            // Si la date est passée et non annulée, marquer comme completed
            $status = $date->isPast() ? 'completed' : 
                     (rand(0, 10) > 8 ? 'cancelled' : 'reserved');

            $lesson = Lesson::create([
                'teacher_id' => $teachers->random()->id,
                'student_id' => $students->random()->id,
                'status' => $status,
                'date' => $date,
            ]);
        }

        $this->command->info('20 leçons ont été créées avec succès.');
    }
} 