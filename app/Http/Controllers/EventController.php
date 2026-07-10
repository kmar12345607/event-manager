<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Event;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::withCount('participants')->latest()->paginate(10);
        return view('events.index', compact('events'));
    }

    public function create()
    {
        return view('events.create');
    }

    public function store(StoreEventRequest $request)
    {
        Event::create($request->validated());
        return redirect()->route('admin.events.index')->with('success', 'Événement créé !');
    }

    public function show(Event $event)
    {
        $participants = $event->participants()->latest()->paginate(10);
        return view('events.show', compact('event', 'participants'));
    }

    public function edit(Event $event)
    {
        return view('events.edit', compact('event'));
    }

    public function update(UpdateEventRequest $request, Event $event)
    {
        $event->update($request->validated());
        return redirect()->route('admin.events.index')->with('success', 'Événement mis à jour !');
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('admin.events.index')->with('success', 'Événement supprimé !');
    }
}
