<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use App\Models\Event;
use Illuminate\Http\Request;

class ParticipantController extends Controller
{
    public function index(Request $request)
    {
        $query = Participant::with('event');

        if ($request->search) {
            $query->where('full_name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
        }

        $participants = $query->latest()->paginate(10)->withQueryString();
        return view('participants.index', compact('participants'));
    }

    public function create(Request $request)
    {
        $events = Event::where('status', 'active')->get();
        $selectedEvent = $request->event_id;
        return view('participants.create', compact('events', 'selectedEvent'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'event_id'          => 'required|exists:events,id',
            'full_name'         => 'required|string|max:255',
            'email'             => 'required|email',
            'phone'             => 'nullable|string|max:20',
            'registration_date' => 'required|date',
            'attendance_status' => 'required|in:registered,present,absent',
            'notes'             => 'nullable|string',
        ]);

        // Vérifier places disponibles
        $event = Event::findOrFail($request->event_id);
        if ($event->participants()->count() >= $event->max_participants) {
            return back()->withErrors(['event_id' => 'Cet événement est complet !'])->withInput();
        }

        Participant::create($request->all());
        return redirect()->route('events.show', $request->event_id)
                         ->with('success', 'Participant inscrit avec succès !');
    }

    public function edit(Participant $participant)
    {
        $events = Event::where('status', 'active')->get();
        return view('participants.edit', compact('participant', 'events'));
    }

    public function update(Request $request, Participant $participant)
    {
        $request->validate([
            'full_name'         => 'required|string|max:255',
            'email'             => 'required|email',
            'phone'             => 'nullable|string|max:20',
            'registration_date' => 'required|date',
            'attendance_status' => 'required|in:registered,present,absent',
            'notes'             => 'nullable|string',
        ]);

        $participant->update($request->all());
        return redirect()->route('events.show', $participant->event_id)
                         ->with('success', 'Participant mis à jour !');
    }

    public function destroy(Participant $participant)
    {
        $eventId = $participant->event_id;
        $participant->delete();
        return redirect()->route('events.show', $eventId)
                         ->with('success', 'Participant supprimé !');
    }
}