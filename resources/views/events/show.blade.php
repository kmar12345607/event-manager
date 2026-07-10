@extends('layouts.app')

@section('title', $event->name)
@section('page-title', $event->name)
@section('page-sub', "Détails de l'événement et gestion des participants")

@section('page-actions')
    <a href="{{ route('admin.events.index') }}" class="btn-primary" style="background:#64748b;">
        <i class="bi bi-arrow-left"></i> Retour
    </a>
    <a href="{{ route('admin.events.edit', $event) }}" class="btn-primary" style="background:#f59e0b;">
        <i class="bi bi-pencil"></i> Modifier
    </a>
    <a href="{{ route('admin.events.export', $event) }}" class="btn-primary" style="background:#10b981;">
        <i class="bi bi-download"></i> Exporter CSV
    </a>
@endsection

@section('content')

@php
    $statusLabels = [
        'upcoming'  => ['À venir', 'bg-primary'],
        'ongoing'   => ['En cours', 'bg-success'],
        'completed' => ['Terminé', 'bg-secondary'],
        'cancelled' => ['Annulé', 'bg-danger'],
    ];
    [$statusLabel, $statusBadge] = $statusLabels[$event->status] ?? ['—', 'bg-secondary'];
    $registeredCount = $event->participants()->count();
    $occupancy = $event->occupancyRate();
@endphp

<!-- Informations de l'événement -->
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
            <h4 class="fw-bold mb-0">{{ $event->name }}</h4>
            <span class="badge {{ $statusBadge }} fs-6">{{ $statusLabel }}</span>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-md-3">
                <div class="text-muted small">Date</div>
                <div class="fw-semibold">{{ \Carbon\Carbon::parse($event->event_date)->format('d/m/Y H:i') }}</div>
            </div>
            <div class="col-md-3">
                <div class="text-muted small">Lieu</div>
                <div class="fw-semibold">{{ $event->location }}</div>
            </div>
            <div class="col-md-3">
                <div class="text-muted small">Participants</div>
                <div class="fw-semibold">{{ $registeredCount }} / {{ $event->max_participants }}</div>
            </div>
            <div class="col-md-3">
                <div class="text-muted small">Taux de remplissage</div>
                <div class="fw-semibold">{{ $occupancy }}%</div>
            </div>
        </div>

        <div class="progress mb-3" style="height: 8px;">
            <div class="progress-bar {{ $occupancy >= 100 ? 'bg-danger' : 'bg-primary' }}"
                 style="width: {{ min($occupancy, 100) }}%"></div>
        </div>

        @if($event->description)
            <p class="text-muted mb-0">{{ $event->description }}</p>
        @endif
    </div>
</div>

<!-- Liste des participants -->
<div class="card shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center flex-wrap gap-2">
        <h5 class="mb-0"><i class="bi bi-people me-2"></i>Participants inscrits</h5>
        <a href="{{ route('admin.participants.create', ['event_id' => $event->id]) }}" class="btn btn-sm btn-primary">
            <i class="bi bi-person-plus me-1"></i>Inscrire un participant
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-primary">
                    <tr>
                        <th>Nom complet</th>
                        <th>Email</th>
                        <th>Téléphone</th>
                        <th>Date inscription</th>
                        <th>Statut présence</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($participants as $participant)
                    <tr>
                        <td class="fw-semibold">{{ $participant->full_name }}</td>
                        <td>{{ $participant->email }}</td>
                        <td>{{ $participant->phone ?? '—' }}</td>
                        <td>{{ \Carbon\Carbon::parse($participant->registration_date)->format('d/m/Y') }}</td>
                        <td>
                            <form action="{{ route('admin.participants.attendance', $participant) }}"
                                  method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <select name="attendance_status" class="form-select form-select-sm"
                                        style="width: auto; display: inline-block;"
                                        onchange="this.form.submit()">
                                    <option value="registered" {{ $participant->attendance_status === 'registered' ? 'selected' : '' }}>Inscrit</option>
                                    <option value="present" {{ $participant->attendance_status === 'present' ? 'selected' : '' }}>Présent</option>
                                    <option value="absent" {{ $participant->attendance_status === 'absent' ? 'selected' : '' }}>Absent</option>
                                </select>
                            </form>
                            <div class="mt-1" style="font-size: 11px;">
                                @if($participant->checked_in_at)
                                    <span class="text-success">
                                        <i class="bi bi-qr-code-scan me-1"></i>Scanné à {{ $participant->checked_in_at->format('H:i') }}
                                    </span>
                                @else
                                    <span class="text-muted">
                                        <i class="bi bi-dash-circle me-1"></i>Non scanné
                                    </span>
                                @endif
                            </div>
                        </td>
                        <td>
                            <a href="{{ route('admin.participants.edit', $participant) }}"
                               class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.participants.destroy', $participant) }}"
                                  method="POST" class="d-inline"
                                  onsubmit="return confirm('Supprimer ce participant ?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                            Aucun participant inscrit pour le moment.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $participants->links() }}
    </div>
</div>
@endsection