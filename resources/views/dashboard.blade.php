@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Tableau de bord')
@section('page-sub', "Vue d'ensemble de vos événements et participants")

@section('content')

<div class="stats-grid">
    <div class="stat-card blue">
        <div class="stat-header">
            <span class="stat-label">Total événements</span>
            <div class="stat-icon blue"><i class="bi bi-calendar-event"></i></div>
        </div>
        <div class="stat-value">{{ $stats['total_events'] }}</div>
        <div class="stat-change">{{ $stats['upcoming_events'] }} à venir</div>
    </div>

    <div class="stat-card navy">
        <div class="stat-header">
            <span class="stat-label">Total participants</span>
            <div class="stat-icon navy"><i class="bi bi-people"></i></div>
        </div>
        <div class="stat-value">{{ $stats['total_participants'] }}</div>
        <div class="stat-change">Toutes inscriptions confondues</div>
    </div>

    <div class="stat-card green">
        <div class="stat-header">
            <span class="stat-label">Taux de présence</span>
            <div class="stat-icon green"><i class="bi bi-check-circle"></i></div>
        </div>
        <div class="stat-value">{{ $stats['attendance_rate'] }}<span class="stat-suffix">%</span></div>
        <div class="stat-change">{{ $stats['present_count'] }} participant(s) présent(s)</div>
    </div>

    <div class="stat-card orange">
        <div class="stat-header">
            <span class="stat-label">Événements à venir</span>
            <div class="stat-icon orange"><i class="bi bi-clock-history"></i></div>
        </div>
        <div class="stat-value">{{ $stats['upcoming_events'] }}</div>
        <div class="stat-change">Ouverts aux inscriptions</div>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="bi bi-calendar3 me-2"></i>Événements récents</h5>
        <a href="{{ route('admin.events.index') }}" class="btn btn-sm btn-outline-primary">Voir tous</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-primary">
                    <tr>
                        <th>Nom</th>
                        <th>Date</th>
                        <th>Lieu</th>
                        <th>Participants</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentEvents as $event)
                    <tr>
                        <td class="fw-semibold">{{ $event->name }}</td>
                        <td>{{ \Carbon\Carbon::parse($event->event_date)->format('d/m/Y') }}</td>
                        <td>{{ $event->location }}</td>
                        <td>{{ $event->participants_count }} / {{ $event->max_participants }}</td>
                        <td>
                            @if($event->status === 'upcoming')
                                <span class="badge bg-primary">À venir</span>
                            @elseif($event->status === 'ongoing')
                                <span class="badge bg-success">En cours</span>
                            @elseif($event->status === 'cancelled')
                                <span class="badge bg-danger">Annulé</span>
                            @else
                                <span class="badge bg-secondary">Terminé</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.events.show', $event) }}" class="btn btn-sm btn-info text-white">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                            Aucun événement pour le moment.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
