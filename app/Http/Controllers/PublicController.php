<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

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
        return view('public.show', [
            'event'    => $event,
            'pageTour' => 'evenement-details',
        ]);
    }

    // Traitement du formulaire d'inscription (nécessite un compte connecté ET vérifié)
    public function register(Request $request, Event $event)
    {
        /** @var \App\Models\User $currentUser */
        $currentUser = Auth::user();

        // Compte connecté mais email pas encore confirmé : on garde en mémoire la page
        // de l'événement pour y revenir automatiquement une fois l'email vérifié,
        // au lieu de perdre l'inscription en cours de route.
        if (! $currentUser->hasVerifiedEmail()) {
            session(['url.intended' => route('public.events.show', $event)]);

            return redirect()->route('verification.notice')
                ->with('error', "Merci de vérifier votre email avant de confirmer votre inscription. Un lien vient d'être envoyé à votre adresse.");
        }

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
            'phone'     => 'nullable|string|max:20',
            'notes'     => 'nullable|string|max:500',
        ]);

        // L'email vient toujours du compte connecté (pas resaisi par le client)
        $email = $currentUser->email;

        // Vérifier si ce compte est déjà inscrit à cet événement
        $exists = Participant::where('event_id', $event->id)
                             ->where('email', $email)
                             ->exists();

        if ($exists) {
            return back()->with('error', 'Vous êtes déjà inscrit(e) à cet événement.');
        }

        Participant::create([
            ...$validated,
            'email'              => $email,
            'event_id'          => $event->id,
            'registration_date' => now(),
            'attendance_status' => 'registered',
        ]);

        return redirect()->route('public.events.show', $event)
                         ->with('success', 'Inscription réussie ! À bientôt à ' . $event->name . ' 🎉');
    }
}