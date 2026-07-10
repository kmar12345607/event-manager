<?php

namespace App\Http\Controllers;

use App\Mail\TicketCheckedIn;
use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CheckinController extends Controller
{
    // Affiche la page "Scanner" (caméra + saisie manuelle)
    public function index()
    {
        return view('admin.scanner');
    }

    // Vérifie un code de billet (appelé en AJAX par le scanner ou la saisie manuelle)
    public function verify(Request $request)
    {
        $request->validate([
            'ticket_code' => 'required|string|max:50',
        ]);

        // Le scan caméra peut renvoyer le code avec des espaces/majuscules variables
        $code = strtoupper(trim($request->ticket_code));

        $participant = Participant::with('event')->where('ticket_code', $code)->first();

        if (! $participant) {
            return response()->json([
                'status'  => 'invalid',
                'message' => 'Billet invalide — ce code n\'existe pas.',
            ], 404);
        }

        if (! $participant->event) {
            return response()->json([
                'status'  => 'invalid',
                'message' => 'Billet invalide — l\'événement associé n\'existe plus.',
            ], 404);
        }

        if ($participant->checked_in_at) {
            return response()->json([
                'status'  => 'already_used',
                'message' => 'Ce billet a déjà été utilisé à ' . $participant->checked_in_at->format('H:i') . '.',
                'participant' => [
                    'name'  => $participant->full_name,
                    'event' => $participant->event->name,
                    'time'  => $participant->checked_in_at->format('H:i'),
                ],
            ], 409);
        }

        if ($participant->attendance_status === 'absent') {
            return response()->json([
                'status'  => 'invalid',
                'message' => 'Ce participant a été marqué absent — accès refusé.',
            ], 403);
        }

        $participant->update([
            'attendance_status' => 'present',
            'checked_in_at'     => now(),
        ]);

        // Email de confirmation au participant
        try {
            Mail::to($participant->email)->send(new TicketCheckedIn($participant));
        } catch (\Throwable $e) {
            // On ne bloque jamais le check-in si l'envoi d'email échoue (ex: mauvaise config SMTP)
            report($e);
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Entrée validée !',
            'participant' => [
                'name'  => $participant->full_name,
                'event' => $participant->event->name,
                'time'  => $participant->checked_in_at->format('H:i'),
            ],
        ]);
    }
}