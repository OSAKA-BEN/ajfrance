<?php

namespace App\Http\Livewire;

use App\Models\Lesson;
use Livewire\Component;
use Livewire\WithPagination;

class LessonsList extends Component
{
    use WithPagination;

    public function render()
    {
        $user = auth()->user();
        $lessons = [];

        if ($user->isAdmin()) {
            $lessons = Lesson::with(['teacher', 'student'])
                ->orderBy('start_datetime', 'desc')
                ->paginate(10);
        } elseif ($user->isTeacher()) {
            $lessons = Lesson::where('teacher_id', $user->id)
                ->with('student')
                ->orderBy('start_datetime', 'desc')
                ->paginate(10);
        } else {
            $lessons = Lesson::where('student_id', $user->id)
                ->with('teacher')
                ->orderBy('start_datetime', 'desc')
                ->paginate(10);
        }

        // Convertir les dates en format souhaité
        foreach ($lessons as $lesson) {
            $lesson->formatted_start_datetime = \Carbon\Carbon::parse($lesson->start_datetime)->format('d/m/y');
            $lesson->formatted_start_time = \Carbon\Carbon::parse($lesson->start_datetime)->format('H:i');
            $lesson->formatted_end_time = \Carbon\Carbon::parse($lesson->end_datetime)->format('H:i');
        }

        return view('livewire.lessons-list', [
            'lessons' => $lessons
        ]);
    }

    public function cancelLesson($lessonId)
    {
        $lesson = Lesson::findOrFail($lessonId);
        $user = auth()->user();

        // Vérifier si l'utilisateur a le droit d'annuler
        if ($user->isAdmin() || 
            $lesson->teacher_id === $user->id || 
            $lesson->student_id === $user->id) {
            
            // Convertir start_datetime en objet Carbon pour vérifier si c'est dans le futur
            $startDateTime = \Carbon\Carbon::parse($lesson->start_datetime);

            if ($startDateTime->isFuture() && $lesson->status === 'reserved') {
                $lesson->update([
                    'status' => 'cancelled'
                ]);
            }
        }
    }
}
