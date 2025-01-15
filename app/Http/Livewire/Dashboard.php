<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Lesson;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    public $totalLessons;
    public $recentLessons;
    public $studentStats;
    public $guestStats;
    public $completedLessonsCount;
    public $lessonHistory;
    public $user;

    public function mount()
    {
        $this->user = Auth::user();
        $this->loadData();
    }

    public function loadData()
    {
        if ($this->user->isAdmin()) {
            $this->totalLessons = Lesson::count();
            $this->recentLessons = Lesson::with(['teacher', 'student'])
                ->orderBy('start_datetime', 'desc')
                ->take(10)
                ->get();
            
            $studentStats = User::where('role', 'student')
                ->selectRaw('COUNT(*) as count, SUM(credits) as total_credits')
                ->first();
            $this->studentStats = [
                'count' => $studentStats->count ?? 0,
                'total_credits' => $studentStats->total_credits ?? 0
            ];
            
            $guestStats = User::where('role', 'guest')
                ->selectRaw('COUNT(*) as count, SUM(credits) as total_credits')
                ->first();
            $this->guestStats = [
                'count' => $guestStats->count ?? 0,
                'total_credits' => $guestStats->total_credits ?? 0
            ];
        } elseif ($this->user->isTeacher()) {
            $this->completedLessonsCount = $this->user->teachingLessons()
                ->where('status', 'completed')
                ->count();
            $this->lessonHistory = $this->user->teachingLessons()
                ->with('student')
                ->orderBy('start_datetime', 'desc')
                ->take(5)
                ->get();
        } else {
            $this->completedLessonsCount = $this->user->bookedLessons()
                ->where('status', 'completed')
                ->count();
            $this->lessonHistory = $this->user->bookedLessons()
                ->with('teacher')
                ->orderBy('start_datetime', 'desc')
                ->take(5)
                ->get();
        }
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}
