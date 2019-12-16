<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventModel extends Model
{
    protected $table = "calendar_events";
    protected $fillable = [
        'event',
        'startRecur',
        'endRecur',
        'daysOfWeek',
        'allDay',
        'backgroundColor'
        
    ];
}
