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

    protected $casts = [
        'event_date' => 'datetime',
    ];

    public function participants()
    {
        return $this->hasMany(Participant::class);
    }

    public function isFull(): bool
    {
        return $this->participants()->count() >= $this->max_participants;
    }

    public function isPast(): bool
    {
        return $this->event_date->isPast();
    }

    public function spotsLeft(): int
    {
        return max(0, $this->max_participants - $this->participants()->count());
    }

    public function occupancyRate(): float
    {
        if ($this->max_participants <= 0) {
            return 0;
        }

        return round(($this->participants()->count() / $this->max_participants) * 100, 1);
    }

    /** Événements ouverts aux inscriptions publiques */
    public function scopeOpenForRegistration($query)
    {
        return $query->whereIn('status', ['upcoming', 'ongoing']);
    }

    /** Événements dont la date est dépassée mais dont le statut n'a pas été mis à jour */
    public function scopeNeedingStatusUpdate($query)
    {
        return $query->whereIn('status', ['upcoming', 'ongoing'])
                     ->where('event_date', '<', now());
    }
}
