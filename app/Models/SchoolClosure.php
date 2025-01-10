<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolClosure extends Model
{
    protected $fillable = [
        'title',
        'start_date',
        'end_date',
        'type', // holiday, vacation, special_event
        'description'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date'
    ];
} 