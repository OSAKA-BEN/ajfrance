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

    
    protected function messages()
    {
        return [
            'newSchedule.day_of_week.required' => 'Day is required',
            'newSchedule.day_of_week.integer' => 'Day must be an integer.',
            'newSchedule.day_of_week.between' => 'Day must be between 1 and 7.',
            'newSchedule.opening_time.required' => 'Opening time is required',
            'newSchedule.opening_time.date_format' => 'Opening time must be in the format H:i.',
            'newSchedule.closing_time.required' => 'Closing time is required',
            'newSchedule.closing_time.date_format' => 'Closing time must be in the format H:i.',
            'newSchedule.closing_time.after' => 'Closing time must be after opening time.',
            'newSchedule.is_open.boolean' => 'Opening status must be true or false.',

            'newClosure.title.required' => 'Title is required',
            'newClosure.title.string' => 'Title must be a string.',
            'newClosure.title.max' => 'Title must not exceed 255 characters.',
            'newClosure.start_date.required' => 'Start date is required',
            'newClosure.start_date.date' => 'Start date must be a valid date',
            'newClosure.start_date.after_or_equal' => 'Start date must be today or a future date',
            'newClosure.end_date.required' => 'End date is required',
            'newClosure.end_date.date' => 'End date must be a valid date',
            'newClosure.end_date.after_or_equal' => 'End date must be after or equal to start date',
            'newClosure.type.required' => 'Closure type is required',
            'newClosure.type.in' => 'Closure type must be one of the following: holiday, vacation, special_event.',
            'newClosure.description.string' => 'Description must be a string.',
        ];
    }

    public function mount()
    {
        $this->loadSchedules();
        $this->loadClosures();
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
