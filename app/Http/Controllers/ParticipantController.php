<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreParticipantRequest;
use App\Http\Requests\UpdateParticipantRequest;
use App\Models\Event;
use App\Models\Participant;
use Illuminate\Http\Request;

class ParticipantController extends Controller
{
    public function index(Request $request)
    {
        $query = Participant::with('event');

        if ($request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $participants = $query->latest()->paginate(10)->withQueryString();
        return view('participants.index', compact('participants'));
    }

    public function create(Request $request)
    {
        $events = Event::whereIn('status', ['upcoming', 'ongoing'])->get();
        $selectedEvent = $request->event_id;
        return view('participants.create', compact('events', 'selectedEvent'));
    }

    public function store(StoreParticipantRequest $request)
    {
        Participant::create($request->validated());

        return redirect()->route('admin.events.show', $request->event_id)
                         ->with('success', 'Participant inscrit avec succès !');
    }

    public function edit(Participant $participant)
    {
        $events = Event::whereIn('status', ['upcoming', 'ongoing'])->get();
        return view('participants.edit', compact('participant', 'events'));
    }

    public function update(UpdateParticipantRequest $request, Participant $participant)
    {
        $participant->update($request->validated());

        return redirect()->route('admin.events.show', $participant->event_id)
                         ->with('success', 'Participant mis à jour !');
    }

    public function destroy(Participant $participant)
    {
        $eventId = $participant->event_id;
        $participant->delete();
        return redirect()->route('admin.events.show', $eventId)
                         ->with('success', 'Participant supprimé !');
    }

    public function updateAttendance(Request $request, Participant $participant)
    {
        $request->validate([
            'attendance_status' => 'required|in:registered,present,absent',
        ]);
        $participant->update(['attendance_status' => $request->attendance_status]);
        return back()->with('success', 'Statut de présence mis à jour !');
    }

    public function export(Event $event)
    {
        $participants = $event->participants()->get();
        $filename = 'participants_event_' . $event->id . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($participants) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($file, ['Nom complet', 'Email', 'Téléphone', 'Date inscription', 'Statut présence', 'Notes'], ';');
            foreach ($participants as $p) {
                fputcsv($file, [
                    $p->full_name,
                    $p->email,
                    $p->phone ?? '',
                    $p->registration_date,
                    $p->attendance_status,
                    $p->notes ?? '',
                ], ';');
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
