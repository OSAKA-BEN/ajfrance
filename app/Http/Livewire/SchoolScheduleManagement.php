<?php

namespace App\Http\Livewire;

use App\Models\SchoolSchedule;
use App\Models\SchoolClosure;
use App\Models\User;
use Livewire\Component;
use Carbon\Carbon;

class SchoolScheduleManagement extends Component
{
    // Pour les horaires réguliers
    public $schedules = [];
    public $newSchedule = [
        'day_of_week' => '',
        'opening_time' => '',
        'closing_time' => '',
        'is_open' => true
    ];

    // Pour les fermetures exceptionnelles
    public $closures = [];
    public $newClosure = [
        'title' => '',
        'start_date' => '',
        'end_date' => '',
        'type' => '',
        'description' => ''
    ];

    // Propriétés pour les notifications
    public $showScheduleSuccessNotification = false;
    public $showScheduleErrorNotification = false;
    public $scheduleErrorMessage = '';
    public $scheduleSuccessMessage = '';

    public $showClosureSuccessNotification = false;
    public $showClosureErrorNotification = false;
    public $closureErrorMessage = '';
    public $closureSuccessMessage = '';

    protected $rules = [
        'newSchedule.day_of_week' => 'required|integer|between:1,7',
        'newSchedule.opening_time' => 'required|date_format:H:i',
        'newSchedule.closing_time' => 'required|date_format:H:i|after:newSchedule.opening_time',
        'newSchedule.is_open' => 'boolean',

        'newClosure.title' => 'required|string|max:255',
        'newClosure.start_date' => 'required|date|after_or_equal:today',
        'newClosure.end_date' => 'required|date|after_or_equal:newClosure.start_date',
        'newClosure.type' => 'required|in:holiday,vacation,special_event',
        'newClosure.description' => 'nullable|string'
    ];

    public function mount()
    {
        $this->loadSchedules();
        $this->loadClosures();
        $this->teachers = User::where('role', 'teacher')->get();
    }

    private function loadSchedules()
    {
        $this->schedules = SchoolSchedule::orderBy('day_of_week')->get();
    }

    private function loadClosures()
    {
        $this->closures = SchoolClosure::orderBy('start_date')->get();
    }

    public function saveSchedule()
    {
        $this->validate([
            'newSchedule.day_of_week' => 'required|integer|between:1,7',
            'newSchedule.opening_time' => 'required|date_format:H:i',
            'newSchedule.closing_time' => 'required|date_format:H:i|after:newSchedule.opening_time',
            'newSchedule.is_open' => 'boolean',
        ]);

        // Convertir les heures en format time sans date
        $openingTime = Carbon::parse($this->newSchedule['opening_time'])->format('H:i:s');
        $closingTime = Carbon::parse($this->newSchedule['closing_time'])->format('H:i:s');

        SchoolSchedule::updateOrCreate(
            [
                'day_of_week' => $this->newSchedule['day_of_week']
            ],
            [
                'opening_time' => $openingTime,
                'closing_time' => $closingTime,
                'is_open' => true
            ]
        );

        $this->reset('newSchedule');
        $this->loadSchedules();

        // Notifications pour les horaires
        $this->showScheduleSuccessNotification = true;
        $this->scheduleSuccessMessage = 'Schedule updated successfully.';
        $this->showScheduleErrorNotification = false;
    }

    public function saveClosure()
    {
        $this->validate([
            'newClosure.title' => 'required|string|max:255',
            'newClosure.start_date' => 'required|date|after_or_equal:today',
            'newClosure.end_date' => 'required|date|after_or_equal:newClosure.start_date',
            'newClosure.type' => 'required|in:holiday,vacation,special_event',
            'newClosure.description' => 'nullable|string'
        ]);

        SchoolClosure::create($this->newClosure);

        $this->loadClosures();
        $this->reset('newClosure');

        // Notifications pour les fermetures
        $this->showClosureSuccessNotification = true;
        $this->closureSuccessMessage = 'School closure added successfully.';
        $this->showClosureErrorNotification = false;
    }

    public function deleteClosure($id)
    {
        SchoolClosure::find($id)->delete();
        $this->loadClosures();

        // Notifications pour les fermetures
        $this->showClosureSuccessNotification = true;
        $this->closureSuccessMessage = 'School closure deleted successfully.';
        $this->showClosureErrorNotification = false;
    }

    public function toggleDay($dayId)
    {
        $schedule = SchoolSchedule::find($dayId);
        $schedule->is_open = !$schedule->is_open;
        $schedule->save();
        $this->loadSchedules();
    }

    public function render()
    {
        return view('livewire.school-schedule-management');
    }
}
