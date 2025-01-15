<?php

namespace App\Http\Livewire;

use App\Models\Lesson;
use App\Models\SchoolClosure;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Calendar extends Component
{
    public $events = [];
    public $user;

    public function mount()
    {
        $this->user = Auth::user();
        $this->loadEvents();
    }

    public function loadEvents()
    {
        // Chargement des fermetures d'école (visible par tous)
        $closures = SchoolClosure::all()->map(function ($closure) {
            return [
                'title' => $closure->title,
                'start' => $closure->start_date,
                'end' => $closure->end_date,
                'className' => 'bg-secondary' // Gris pour les fermetures
            ];
        });

        // Chargement des leçons selon le rôle
        if ($this->user->isAdmin()) {
            $lessons = Lesson::with(['teacher', 'student'])->get();
        } elseif ($this->user->isTeacher()) {
            $lessons = $this->user->teachingLessons()->with('student')->get();
        } else {
            $lessons = $this->user->bookedLessons()->with('teacher')->get();
        }

        $lessonEvents = $lessons->map(function ($lesson) {
            $title = $this->user->isAdmin() 
                ? "{$lesson->teacher->name} | {$lesson->student->name}"
                : ($this->user->isTeacher() 
                    ? "{$lesson->student->name}"
                    : "{$lesson->teacher->name}");

            $className = match($lesson->status) {
                'reserved' => 'bg-info',     // Bleu
                'completed' => 'bg-success', // Vert
                'cancelled' => 'bg-danger',  // Rouge
                default => 'bg-info'
            };

            return [
                'title' => $title,
                'start' => $lesson->start_datetime,
                'end' => $lesson->end_datetime,
                'className' => $className
            ];
        });

        $this->events = array_merge($closures->toArray(), $lessonEvents->toArray());
    }

    public function render()
    {
        return view('livewire.calendar');
    }
}
