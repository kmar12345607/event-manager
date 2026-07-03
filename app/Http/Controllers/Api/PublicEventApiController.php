<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\JsonResponse;

class PublicEventApiController extends Controller
{
    /**
     * Liste publique des événements ouverts aux inscriptions.
     */
    public function index(): JsonResponse
    {
        $events = Event::openForRegistration()
            ->withCount('participants')
            ->orderBy('event_date')
            ->get()
            ->map(fn (Event $event) => [
                'id'                 => $event->id,
                'name'               => $event->name,
                'event_date'         => $event->event_date,
                'location'           => $event->location,
                'description'        => $event->description,
                'max_participants'   => $event->max_participants,
                'participants_count' => $event->participants_count,
                'spots_left'         => $event->spotsLeft(),
                'status'             => $event->status,
            ]);

        return response()->json(['data' => $events]);
    }

    /**
     * Détail public d'un événement.
     */
    public function show(Event $event): JsonResponse
    {
        $event->loadCount('participants');

        return response()->json([
            'id'                 => $event->id,
            'name'               => $event->name,
            'event_date'         => $event->event_date,
            'location'           => $event->location,
            'description'        => $event->description,
            'max_participants'   => $event->max_participants,
            'participants_count' => $event->participants_count,
            'spots_left'         => $event->spotsLeft(),
            'status'             => $event->status,
        ]);
    }
}
