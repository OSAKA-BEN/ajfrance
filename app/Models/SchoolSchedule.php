<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class SchoolSchedule extends Model
{
    protected $fillable = [
        'day_of_week',
        'opening_time',
        'closing_time',
        'is_open'
    ];

    protected $casts = [
        'is_open' => 'boolean',
        'opening_time' => 'string',
        'closing_time' => 'string'
    ];

    // Accesseurs pour formater l'heure
    public function getFormattedOpeningTimeAttribute()
    {
        return $this->opening_time ? Carbon::parse($this->opening_time)->format('H:i') : '';
    }

    public function getFormattedClosingTimeAttribute()
    {
        return $this->closing_time ? Carbon::parse($this->closing_time)->format('H:i') : '';
    }
} 