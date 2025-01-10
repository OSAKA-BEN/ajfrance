<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Availability;
use App\Models\TeacherAbsence;
use Livewire\Component;
use Carbon\Carbon;

class TeacherAvailabilityManagement extends Component
{
    public $teachers;
    public $teacherAvailabilities = [];
    public $newAvailability = [];
    public $newAbsence = [];
    
    protected $rules = [
        'newAvailability.*.day_of_week' => 'required|integer|between:1,7',
        'newAvailability.*.opening_time' => 'required|date_format:H:i',
        'newAvailability.*.closing_time' => 'required|date_format:H:i|after:newAvailability.*.opening_time',
        
        'newAbsence.*.start_date' => 'required|date|after_or_equal:today',
        'newAbsence.*.end_date' => 'required|date|after_or_equal:newAbsence.*.start_date',
        'newAbsence.*.type' => 'required|in:vacation,sick_leave,other',
        'newAbsence.*.reason' => 'nullable|string'
    ];

    public function mount()
    {
        $this->teachers = User::where('role', 'teacher')
            ->with(['teacherAvailabilities', 'teacherAbsences'])
            ->get();
            
        // Initialiser les formulaires pour chaque professeur
        foreach ($this->teachers as $teacher) {
            $this->newAvailability[$teacher->id] = [
                'day_of_week' => '',
                'opening_time' => '',
                'closing_time' => ''
            ];
            
            $this->newAbsence[$teacher->id] = [
                'start_date' => '',
                'end_date' => '',
                'type' => '',
                'reason' => ''
            ];
        }
    }

    public function saveAvailability($teacherId)
    {
        $this->validate([
            "newAvailability.$teacherId.day_of_week" => 'required|integer|between:1,7',
            "newAvailability.$teacherId.opening_time" => 'required|date_format:H:i',
            "newAvailability.$teacherId.closing_time" => 'required|date_format:H:i|after:newAvailability.' . $teacherId . '.opening_time',
        ]);

        // Convertir les heures en format time sans date
        $startTime = Carbon::parse($this->newAvailability[$teacherId]['opening_time'])->format('H:i:s');
        $endTime = Carbon::parse($this->newAvailability[$teacherId]['closing_time'])->format('H:i:s');

        Availability::updateOrCreate(
            [
                'user_id' => $teacherId,
                'day_of_week' => $this->newAvailability[$teacherId]['day_of_week']
            ],
            [
                'start_time' => $startTime,
                'end_time' => $endTime
            ]
        );

        // Réinitialiser uniquement les valeurs du formulaire pour ce professeur
        $this->newAvailability[$teacherId] = [
            'day_of_week' => '',
            'opening_time' => '',
            'closing_time' => ''
        ];

        $this->teachers = User::where('role', 'teacher')
            ->with(['teacherAvailabilities', 'teacherAbsences'])
            ->get();
            
        session()->flash("message.$teacherId", 'Availability updated successfully.');
    }

    public function saveAbsence($teacherId)
    {
        $this->validate([
            "newAbsence.$teacherId.start_date" => 'required|date|after_or_equal:today',
            "newAbsence.$teacherId.end_date" => 'required|date|after_or_equal:newAbsence.' . $teacherId . '.start_date',
            "newAbsence.$teacherId.type" => 'required|in:vacation,sick_leave,other',
        ]);

        TeacherAbsence::create([
            'teacher_id' => $teacherId,
            'start_date' => $this->newAbsence[$teacherId]['start_date'],
            'end_date' => $this->newAbsence[$teacherId]['end_date'],
            'type' => $this->newAbsence[$teacherId]['type'],
            'reason' => $this->newAbsence[$teacherId]['reason']
        ]);

        // Réinitialiser uniquement les valeurs du formulaire pour ce professeur
        $this->newAbsence[$teacherId] = [
            'start_date' => '',
            'end_date' => '',
            'type' => '',
            'reason' => ''
        ];

        $this->teachers = User::where('role', 'teacher')
            ->with(['teacherAvailabilities', 'teacherAbsences'])
            ->get();
            
        session()->flash("message.$teacherId", 'Absence added successfully.');
    }

    public function deleteAvailability($availabilityId)
    {
        Availability::find($availabilityId)->delete();
        
        $this->teachers = User::where('role', 'teacher')
            ->with(['teacherAvailabilities', 'teacherAbsences'])
            ->get();
    }

    public function deleteAbsence($absenceId)
    {
        TeacherAbsence::find($absenceId)->delete();
        
        $this->teachers = User::where('role', 'teacher')
            ->with(['teacherAvailabilities', 'teacherAbsences'])
            ->get();
    }

    public function render()
    {
        return view('livewire.teacher-availability-management');
    }
} 