<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use Illuminate\Http\Request;

class ParticipantAccountController extends Controller
{
    // Espace personnel du participant : ses inscriptions
    public function index()
    {
        // Récupère les inscriptions liées à l'email du compte connecté
        $inscriptions = Participant::with('event')
            ->where('email', auth()->user()->email)
            ->latest()
            ->get();

        return view('participant.dashboard', compact('inscriptions'));
    }

    public function profile()
    {
        $user = auth()->user();
        return view('participant.profile', compact('user'));
    }
}