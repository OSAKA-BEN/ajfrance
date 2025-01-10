<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherAbsence extends Model
{
    protected $fillable = [
        'teacher_id',
        'start_date',
        'end_date',
        'type',
        'reason'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime'
    ];

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id')
                    ->where('role', 'teacher');
    }
} 