<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::latest()->paginate(10);
        return view('events.index', compact('events'));
    }

    public function create()
    {
        return view('events.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'             => 'required|string|max:255',
            'event_date'       => 'required|date',
            'location'         => 'required|string|max:255',
            'description'      => 'nullable|string',
            'max_participants' => 'required|integer|min:1',
            'status'           => 'required|in:upcoming,ongoing,completed,cancelled',
        ]);

        Event::create($request->all());
        return redirect()->route('events.index')->with('success', 'Événement créé !');
    }

    public function show(Event $event)
    {
        $participants = $event->participants()->paginate(10);
        return view('events.show', compact('event', 'participants'));
    }

    public function edit(Event $event)
    {
        return view('events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $request->validate([
            'name'             => 'required|string|max:255',
            'event_date'       => 'required|date',
            'location'         => 'required|string|max:255',
            'description'      => 'nullable|string',
            'max_participants' => 'required|integer|min:1',
            'status'           => 'required|in:upcoming,ongoing,completed,cancelled',
        ]);

        $event->update($request->all());
        return redirect()->route('events.index')->with('success', 'Événement mis à jour !');
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('events.index')->with('success', 'Événement supprimé !');
    }
}