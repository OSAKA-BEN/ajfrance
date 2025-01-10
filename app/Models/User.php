<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'about',
        'address',
        'city',
        'state',
        'zipcode',
        'country',
        'profile_image',
        'role',
        'credits'
    ];

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isTeacher()
    {
        return $this->role === 'teacher';
    }

    public function isStudent()
    {
        return $this->role === 'student';
    }

    public function isGuest()
    {
        return $this->role === 'guest';
    }

    public function hasRole($role)
    {
        return $this->role === $role;
    }

    public function canHaveCredits()
    {
        return in_array($this->role, ['student', 'guest']);
    }

    public function teachingLessons()
    {
        return $this->hasMany(Lesson::class, 'teacher_id');
    }

    public function bookedLessons()
    {
        return $this->hasMany(Lesson::class, 'student_id');
    }

    public function availabilities()
    {
        return $this->hasMany(Availability::class, 'user_id');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'teacher_id');
    }

    public function studentReservations()
    {
        return $this->hasMany(Reservation::class, 'student_id');
    }

    public function absences()
    {
        return $this->hasMany(TeacherAbsence::class, 'teacher_id');
    }

    public function teacherAvailabilities()
    {
        return $this->hasMany(Availability::class, 'user_id')
                    ->when(!$this->isTeacher(), function($query) {
                        return $query->whereNull('id');
                    });
    }

    public function teacherAbsences()
    {
        return $this->hasMany(TeacherAbsence::class, 'teacher_id')
                    ->when(!$this->isTeacher(), function($query) {
                        return $query->whereNull('id');
                    });
    }
}
