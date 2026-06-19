<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    protected $fillable = [
        'event_id',
        'full_name',
        'email',
        'phone',
        'registration_date',
        'attendance_status',
        'notes',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}