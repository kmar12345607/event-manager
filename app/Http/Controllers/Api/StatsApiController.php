<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Participant;
use Illuminate\Http\JsonResponse;

class StatsApiController extends Controller
{
    public function __invoke(): JsonResponse
    {
        $totalParticipants = Participant::count();
        $presentCount = Participant::where('attendance_status', 'present')->count();

        return response()->json([
            'total_events'       => Event::count(),
            'upcoming_events'    => Event::where('status', 'upcoming')->count(),
            'ongoing_events'     => Event::where('status', 'ongoing')->count(),
            'completed_events'   => Event::where('status', 'completed')->count(),
            'cancelled_events'   => Event::where('status', 'cancelled')->count(),
            'total_participants' => $totalParticipants,
            'present_count'      => $presentCount,
            'absent_count'       => Participant::where('attendance_status', 'absent')->count(),
            'registered_count'   => Participant::where('attendance_status', 'registered')->count(),
            'attendance_rate'    => $totalParticipants > 0
                ? round(($presentCount / $totalParticipants) * 100, 1)
                : 0,
        ]);
    }
}
