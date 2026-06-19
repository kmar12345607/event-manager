@extends('layouts.app')

@section('content')
<div class="card shadow-sm mb-4">
    <div class="card-header bg-info text-white d-flex justify-content-between">
        <h4 class="mb-0"><i class="bi bi-calendar-event"></i> {{ $event->name }}</h4>
        <a href="{{ route('events.index') }}" class="btn btn-light btn-sm">← Retour</a>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <p><strong>Date :</strong> {{ \Carbon\Carbon::parse($event->date)->format('d/m/Y') }}</p>
                <p><strong>Lieu :</strong> {{ $event->location }}</p>
                <p><strong>Description :</strong> {{ $event->description ?? '—' }}</p>
            </div>
            <div class="col-md-6">
                <p><strong>Max participants :</strong> {{ $event->max_participants }}</p>
                <p><strong>Inscrits :</strong> {{ $event->participants->count() }}</p>
                <p><strong>Statut :</strong>
                    <span class="badge bg-{{ $event->status === 'active' ? 'success' : ($event->status === 'cancelled' ? 'danger' : 'secondary') }}">
                        {{ ucfirst($event->status) }}
                    </span>
                </p>
            </div>
        </div>
    </div>
</div>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h5><i class="bi bi-people"></i> Participants</h5>
    <a href="#" class="btn btn-success btn-sm">
        <i class="bi bi-person-plus"></i> Ajouter un participant
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <table class="table table-hover">
            <thead class="table-light">
                <tr>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Téléphone</th>
                    <th>Statut présence</th>
                </tr>
            </thead>
            <tbody>
                @forelse($participants as $participant)
                <tr>
                    <td>{{ $participant->full_name }}</td>
                    <td>{{ $participant->email }}</td>
                    <td>{{ $participant->phone ?? '—' }}</td>
                    <td>
                        @if($participant->attendance_status === 'present')
                            <span class="badge bg-success">Présent</span>
                        @elseif($participant->attendance_status === 'absent')
                            <span class="badge bg-danger">Absent</span>
                        @else
                            <span class="badge bg-warning text-dark">Inscrit</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center text-muted">Aucun participant pour cet événement.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        {{ $participants->links() }}
    </div>
</div>
@endsection