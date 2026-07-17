<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Participant extends Model
{
    protected $fillable = [
        'event_id',
        'ticket_code',
        'full_name',
        'email',
        'phone',
        'registration_date',
        'attendance_status',
        'checked_in_at',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'registration_date' => 'date',
            'checked_in_at'     => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        // Génère un code billet unique à la création 
        static::creating(function (Participant $participant) {
            if (empty($participant->ticket_code)) {
                $participant->ticket_code = static::generateTicketCode();
            }
        });
    }

    public static function generateTicketCode(): string
    {
        do {
            $code = strtoupper(Str::random(4) . '-' . Str::random(6));
        } while (static::where('ticket_code', $code)->exists());

        return $code;
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    // Le billet a-t-il déjà été validé à l'entrée ?
    public function isCheckedIn(): bool
    {
        return ! is_null($this->checked_in_at);
    }
}