<?php

namespace App\Mail;

use App\Models\Participant;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TicketCheckedIn extends Mailable
{
    use Queueable, SerializesModels;

    public Participant $participant;

    public function __construct(Participant $participant)
    {
        $this->participant = $participant;
    }

    public function build()
    {
        return $this->subject('Entrée validée — ' . $this->participant->event->name)
                    ->view('emails.ticket-checked-in');
    }
}