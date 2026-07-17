<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use Illuminate\Support\Facades\Auth;

class ParticipantAccountController extends Controller
{
    // Espace personnel du participant : ses inscriptions
    public function index()
    {
        // Récupère les inscriptions liées à l'email du compte connecté
        $inscriptions = Participant::with('event')
            ->where('email', Auth::user()->email)
            ->latest()
            ->get();

        return view('participant.dashboard', compact('inscriptions'));
    }

    public function profile()
    {
        $user = Auth::user();
        return view('participant.profile', compact('user'));
    }

    // Affiche le billet d'une inscription (uniquement si elle appartient au compte connecté)
    public function ticket(Participant $participant)
    {
        abort_unless($participant->email === Auth::user()->email, 403);

        $participant->load('event');

        return view('participant.ticket', compact('participant'));
    }
}