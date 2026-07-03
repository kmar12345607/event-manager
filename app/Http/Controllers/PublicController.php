<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Participant;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    // Page d'accueil — liste des événements publics
public function home(Request $request)
{
    $query = Event::whereIn('status', ['upcoming', 'ongoing'])
                  ->withCount('participants')
                  ->orderBy('event_date');

    if ($request->status) {
        $query->where('status', $request->status);
    }

    $events = $query->paginate(6);
    return view('public.home', compact('events'));
}

    // Détail d'un événement
    public function show(Event $event)
    {
        $event->loadCount('participants');
        return view('public.show', compact('event'));
    }

    // Traitement du formulaire d'inscription
    public function register(Request $request, Event $event)
    {
        // Vérifier si l'événement accepte encore des inscriptions
        if ($event->isFull()) {
            return back()->with('error', 'Désolé, cet événement est complet.');
        }

        if (!in_array($event->status, ['upcoming', 'ongoing'])) {
            return back()->with('error', 'Les inscriptions sont fermées pour cet événement.');
        }

        if ($event->isPast()) {
            return back()->with('error', 'Cet événement est déjà passé, les inscriptions sont closes.');
        }

        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email'     => 'required|email|max:255',
            'phone'     => 'nullable|string|max:20',
            'notes'     => 'nullable|string|max:500',
        ]);

        // Vérifier si cet email est déjà inscrit à cet événement
        $exists = Participant::where('event_id', $event->id)
                             ->where('email', $validated['email'])
                             ->exists();

        if ($exists) {
            return back()->with('error', 'Cet email est déjà inscrit à cet événement.');
        }

        Participant::create([
            ...$validated,
            'event_id'          => $event->id,
            'registration_date' => now(),
            'attendance_status' => 'registered',
        ]);

        return redirect()->route('public.events.show', $event)
                         ->with('success', 'Inscription réussie ! À bientôt à ' . $event->name . ' 🎉');
    }
}