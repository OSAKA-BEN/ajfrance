<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Lesson;
use App\Models\SchoolSchedule;
use App\Models\SchoolClosure;
use App\Models\TeacherAbsence;
use App\Models\Availability;
use App\Models\Reservation;
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

        if (!$this->checkStudentCredits()) {
            return $this->setError($teacherId, 'You don\'t have enough credits to book a lesson');
        }

        $startDateTime = $this->createDateTime($teacherId);
        $endDateTime = $startDateTime->copy()->addHour();

        // Vérifier les disponibilités de l'école
        $schoolAvailability = $this->checkSchoolAvailability($startDateTime, $endDateTime);
        if (!$schoolAvailability['available']) {
            return $this->setError($teacherId, $schoolAvailability['message']);
        }

        // Récupérer l'objet User du professeur
        $teacher = User::findOrFail($teacherId);

        // Vérifier les disponibilités du professeur
        $teacherAvailability = $this->checkTeacherAvailability($teacher, $startDateTime, $endDateTime);
        if (!$teacherAvailability['available']) {
            return $this->setError($teacherId, $teacherAvailability['message']);
        }

        try {
            $this->createLesson($teacherId, $startDateTime, $endDateTime);
            $this->handleSuccessfulReservation($teacherId);
        } catch (\Exception $e) {
            $this->setError($teacherId, 'An error occurred while booking the lesson');
        }
    }

    private function checkStudentCredits(): bool
    {
        return auth()->user()->credits >= 1;
    }

    private function createDateTime($teacherId): Carbon
    {
        $selectedDate = $this->selectedDates[$teacherId];
        $selectedHour = (int)$this->selectedTimes[$teacherId];
        
        // Créer la date avec l'heure spécifique
        return Carbon::parse($selectedDate)->setHour($selectedHour)->setMinute(0)->setSecond(0);
    }

    private function checkSchoolAvailability(Carbon $startDateTime, Carbon $endDateTime): array
    {
        // Vérifier les horaires d'ouverture
        $schoolSchedule = SchoolSchedule::where('day_of_week', $startDateTime->dayOfWeek)
            ->where('is_open', true)
            ->where('opening_time', '<=', $startDateTime->format('H:i:s'))
            ->where('closing_time', '>=', $endDateTime->format('H:i:s'))
            ->first();

        if (!$schoolSchedule) {
            return ['available' => false, 'message' => 'The school is closed at this time'];
        }

        // Vérifier les fermetures exceptionnelles
        $schoolClosure = SchoolClosure::where(function($query) use ($startDateTime) {
            $query->where('start_date', '<=', $startDateTime->format('Y-m-d'))
                ->where('end_date', '>=', $startDateTime->format('Y-m-d'));
        })->first();

        if ($schoolClosure) {
            return ['available' => false, 'message' => "The school is closed for {$schoolClosure->title}"];
        }

        return ['available' => true, 'message' => ''];
    }

    private function checkTeacherAvailability(User $teacher, Carbon $startDateTime, Carbon $endDateTime): array
    {
        // 1. Vérifier les absences
        $teacherAbsence = TeacherAbsence::where('teacher_id', $teacher->id)
            ->where(function($query) use ($startDateTime) {
                $query->whereDate('start_date', '<=', $startDateTime)
                      ->whereDate('end_date', '>=', $startDateTime);
            })
            ->first();

        if ($teacherAbsence) {
            return [
                'available' => false,
                'message' => "Teacher is not available (". ucfirst($teacherAbsence->type) .")"
            ];
        }

        // 2. Vérifier les disponibilités hebdomadaires
        $dayOfWeek = $startDateTime->dayOfWeek;
        $dayOfWeek = $dayOfWeek === 0 ? 7 : $dayOfWeek;  // Convertir dimanche de 0 à 7
        $lessonTime = $startDateTime->format('H:i:s');

        $availability = Availability::where('user_id', $teacher->id)
            ->where('day_of_week', $dayOfWeek)
            ->where('start_time', '<=', $lessonTime)
            ->where('end_time', '>=', $lessonTime)
            ->first();

        if (!$availability) {
            return [
                'available' => false,
                'message' => 'Teacher is not available at this time'
            ];
        }

        // 3. Vérifier les leçons existantes
        $existingLesson = Lesson::where('teacher_id', $teacher->id)
            ->where('status', '!=', 'cancelled')
            ->where(function($query) use ($startDateTime, $endDateTime) {
                $query->whereBetween('start_datetime', [$startDateTime, $endDateTime])
                    ->orWhereBetween('end_datetime', [$startDateTime, $endDateTime])
                    ->orWhere(function($q) use ($startDateTime, $endDateTime) {
                        $q->where('start_datetime', '<=', $startDateTime)
                            ->where('end_datetime', '>=', $endDateTime);
                    });
            })
            ->first();

        if ($existingLesson) {
            return [
                'available' => false,
                'message' => 'Teacher already has a lesson at this time'
            ];
        }

        return [
            'available' => true,
            'message' => 'Teacher is available'
        ];
    }

    private function createLesson($teacherId, Carbon $startDateTime, Carbon $endDateTime): void
    {
        Lesson::create([
            'teacher_id' => $teacherId,
            'student_id' => auth()->id(),
            'start_datetime' => $startDateTime,
            'end_datetime' => $endDateTime,
            'lesson_type' => $this->selectedTypes[$teacherId],
            'status' => 'reserved'
        ]);

        auth()->user()->decrement('credits');
    }

    private function handleSuccessfulReservation($teacherId): void
    {
        $this->showSuccessNotification[$teacherId] = true;
        $this->showErrorNotification[$teacherId] = false;
        
        unset($this->selectedDates[$teacherId]);
        unset($this->selectedTimes[$teacherId]);
        unset($this->selectedTypes[$teacherId]);
    }

    private function setError($teacherId, $message): void
    {
        $this->showErrorNotification[$teacherId] = true;
        $this->errorMessage[$teacherId] = $message;
    }

    public function render()
    {
        return view('livewire.lesson-reservation');
    }
} 