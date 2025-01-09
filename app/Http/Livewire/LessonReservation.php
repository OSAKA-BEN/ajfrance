<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Lesson;
use Livewire\Component;
use Carbon\Carbon;

class LessonReservation extends Component
{
    public $teachers;
    public $selectedDates = [];
    public $selectedTimes = [];
    public $selectedTypes = [];
    public $showSuccessNotification = [];
    public $showErrorNotification = [];
    public $errorMessage = [];

    protected $rules = [
        'selectedDates.*' => 'required|date|after_or_equal:today',
        'selectedTimes.*' => 'required|integer|between:9,17',
        'selectedTypes.*' => 'required|in:skype,private',
    ];

    public function mount()
    {
        $this->teachers = User::where('role', 'teacher')
            ->with(['availabilities', 'teachingLessons'])
            ->get();
    }

    public function makeReservation($teacherId)
    {
        $this->validate([
            "selectedDates.$teacherId" => 'required|date|after_or_equal:today',
            "selectedTimes.$teacherId" => 'required|integer|between:9,17',
            "selectedTypes.$teacherId" => 'required|in:skype,private',
        ]);

        // Vérifier si l'étudiant a assez de crédits
        $student = auth()->user();
        if ($student->credits < 1) {
            $this->showErrorNotification[$teacherId] = true;
            $this->errorMessage[$teacherId] = 'You don\'t have enough credits to book a lesson';
            return;
        }

        // Créer le DateTime pour la réservation
        $startDateTime = Carbon::parse($this->selectedDates[$teacherId])
            ->setHour((int)$this->selectedTimes[$teacherId])
            ->setMinute(0)
            ->setSecond(0);
        
        $endDateTime = $startDateTime->copy()->addHour();

        // Vérifier si le créneau est disponible
        $conflictingLesson = Lesson::where('teacher_id', $teacherId)
            ->where('status', '!=', 'cancelled')
            ->where(function($query) use ($startDateTime, $endDateTime) {
                $query->whereBetween('start_datetime', [$startDateTime, $endDateTime])
                    ->orWhereBetween('end_datetime', [$startDateTime, $endDateTime]);
            })
            ->exists();

        if ($conflictingLesson) {
            $this->showErrorNotification[$teacherId] = true;
            $this->errorMessage[$teacherId] = 'This time slot is not available';
            return;
        }

        // Vérifier la disponibilité du professeur
        $dayOfWeek = $startDateTime->dayOfWeek;
        $teacherAvailable = User::find($teacherId)
            ->availabilities()
            ->where('day_of_week', $dayOfWeek)
            ->where('start_time', '<=', $startDateTime->format('H:i:s'))
            ->where('end_time', '>=', $endDateTime->format('H:i:s'))
            ->exists();

        if (!$teacherAvailable) {
            $this->showErrorNotification[$teacherId] = true;
            $this->errorMessage[$teacherId] = 'The teacher is not available at this time';
            return;
        }

        try {
            // Créer la leçon
            Lesson::create([
                'teacher_id' => $teacherId,
                'student_id' => auth()->id(),
                'start_datetime' => $startDateTime,
                'end_datetime' => $endDateTime,
                'lesson_type' => $this->selectedTypes[$teacherId],
                'status' => 'reserved'
            ]);

            // Déduire un crédit
            $student->decrement('credits');

            $this->showSuccessNotification[$teacherId] = true;
            $this->showErrorNotification[$teacherId] = false;
            
            // Réinitialiser les champs individuellement
            unset($this->selectedDates[$teacherId]);
            unset($this->selectedTimes[$teacherId]);
            unset($this->selectedTypes[$teacherId]);

        } catch (\Exception $e) {
            $this->showErrorNotification[$teacherId] = true;
            $this->errorMessage[$teacherId] = 'An error occurred while booking the lesson';
        }
    }

    public function render()
    {
        return view('livewire.lesson-reservation');
    }
} 