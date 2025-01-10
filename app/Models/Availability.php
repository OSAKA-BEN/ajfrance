<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Availability extends Model
{
    protected $fillable = [
        'user_id',
        'day_of_week',
        'start_time',
        'end_time'
    ];

    protected $casts = [
        'start_time' => 'string',
        'end_time' => 'string'
    ];

    public function teacher()
    {
        return $this->belongsTo(User::class, 'user_id')
                    ->where('role', 'teacher');
    }

    public function getFormattedStartTimeAttribute()
    {
        return $this->start_time ? Carbon::parse($this->start_time)->format('H:i') : '';
    }

    public function getFormattedEndTimeAttribute()
    {
        return $this->end_time ? Carbon::parse($this->end_time)->format('H:i') : '';
    }
} 