<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Event;
use Illuminate\Http\JsonResponse;

class EventApiController extends Controller
{
    public function index(): JsonResponse
    {
        $events = Event::withCount('participants')->latest()->paginate(15);

        return response()->json($events);
    }

    public function store(StoreEventRequest $request): JsonResponse
    {
        $event = Event::create($request->validated());

        return response()->json($event, 201);
    }

    public function show(Event $event): JsonResponse
    {
        $event->loadCount('participants');
        $event->spots_left = $event->spotsLeft();
        $event->occupancy_rate = $event->occupancyRate();

        return response()->json($event);
    }

    public function update(UpdateEventRequest $request, Event $event): JsonResponse
    {
        $event->update($request->validated());

        return response()->json($event);
    }

    public function destroy(Event $event): JsonResponse
    {
        $event->delete();

        return response()->json(['message' => 'Événement supprimé.']);
    }
}
