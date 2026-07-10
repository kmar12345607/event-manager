<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreParticipantRequest;
use App\Http\Requests\UpdateParticipantRequest;
use App\Models\Event;
use App\Models\Participant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ParticipantApiController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Participant::with('event');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('event_id')) {
            $query->where('event_id', $request->event_id);
        }

        return response()->json($query->latest()->paginate(15));
    }

    public function store(StoreParticipantRequest $request, Event $event): JsonResponse
    {
        $data = $request->validated();
        $data['event_id'] = $event->id;

        $participant = Participant::create($data);

        return response()->json($participant, 201);
    }

    public function show(Participant $participant): JsonResponse
    {
        return response()->json($participant->load('event'));
    }

    public function update(UpdateParticipantRequest $request, Participant $participant): JsonResponse
    {
        $participant->update($request->validated());

        return response()->json($participant);
    }

    public function destroy(Participant $participant): JsonResponse
    {
        $participant->delete();

        return response()->json(['message' => 'Participant supprimé.']);
    }

    public function updateAttendance(Request $request, Participant $participant): JsonResponse
    {
        $request->validate([
            'attendance_status' => 'required|in:registered,present,absent',
        ]);

        $participant->update(['attendance_status' => $request->attendance_status]);

        return response()->json($participant);
    }
}
