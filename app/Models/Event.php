<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'name',
        'event_date',
        'location',
        'description',
        'max_participants',
        'status',
    ];

    public function participants()
    {
        return $this->hasMany(Participant::class);
    }

    public function isFull()
    {
        return $this->participants()->count() >= $this->max_participants;
    }
}