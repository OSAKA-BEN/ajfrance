<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lesson extends Model
{
    protected $fillable = [
        'teacher_id',
        'student_id',
        'start_datetime',
        'end_datetime',
        'lesson_type',
        'status'
    ];

    protected $casts = [
        'start_datetime' => 'datetime',
        'end_datetime' => 'datetime'
    ];

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function getFormattedStartDatetimeAttribute()
    {
        return \Carbon\Carbon::parse($this->start_datetime)->format('d/m/Y à H:i');
    }
} 