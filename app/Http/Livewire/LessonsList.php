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
                ->orderBy('date', 'desc')
                ->simplePaginate(10);
        } elseif ($user->isTeacher()) {
            $lessons = Lesson::where('teacher_id', $user->id)
                ->with('student')
                ->orderBy('date', 'desc')
                ->simplePaginate(10);
        } else {
            $lessons = Lesson::where('student_id', $user->id)
                ->with('teacher')
                ->orderBy('date', 'desc')
                ->simplePaginate(10);
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
            
            if ($lesson->date->isFuture() && $lesson->status === 'reserved') {
                $lesson->update([
                    'status' => 'cancelled'
                ]);

            }
        }
    }
}
