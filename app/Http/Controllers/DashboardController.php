<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Participant;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_events'       => Event::count(),
            'total_participants' => Participant::count(),
            'present_count'      => Participant::where('attendance_status', 'present')->count(),
            'upcoming_events'    => Event::where('status', 'upcoming')->count(),
        ];

        $stats['attendance_rate'] = $stats['total_participants'] > 0
            ? round(($stats['present_count'] / $stats['total_participants']) * 100, 1)
            : 0;

        $recentEvents = Event::withCount('participants')->latest()->take(5)->get();

        return view('dashboard', compact('stats', 'recentEvents'));
    }
}