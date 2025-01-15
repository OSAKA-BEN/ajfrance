<?php

namespace App\Console\Commands;

use App\Models\Lesson;
use Illuminate\Console\Command;
use Carbon\Carbon;

class UpdateLessonStatus extends Command
{
    protected $signature = 'lessons:update-status';
    protected $description = 'Update lesson status to completed when end datetime has passed';

    public function handle()
    {
        // Explicitement définir la timezone pour cette opération
        $now = Carbon::now('Asia/Tokyo');
        
        // Pour débugger, affichons d'abord les leçons concernées
        $lessons = Lesson::where('status', 'reserved')
            ->where('end_datetime', '<', $now)
            ->get();
            
        $this->info("Current time (Tokyo): " . $now->format('Y-m-d H:i:s'));
        $this->info("Found lessons: " . $lessons->count());
        
        foreach ($lessons as $lesson) {
            $this->info("Lesson ID: {$lesson->id}, End time: {$lesson->end_datetime} (UTC)");
        }
        
        // Met à jour les leçons
        $updated = Lesson::where('status', 'reserved')
            ->where('end_datetime', '<', $now)
            ->update(['status' => 'completed']);
            
        $this->info("$updated lessons marked as completed.");
    }
} 