@extends('layouts.app')

@section('title', 'Détails de l'événement')
@section('page-title', 'Détails de l'événement')
@section('page-sub', 'Consultez les infos et gérez les participants')

@section('content')
<div class="card shadow-sm mb-4">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h4 class="mb-0"><i class="bi bi-calendar-event me-2"></i>{{ $event->name }}</h4>
        <a href="{{ route('admin.events.index') }}" class="btn btn-light btn-sm">← Retour</a>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <p><i class="bi bi-calendar me-2 text-primary"></i>
                    <strong>Date :</strong>
                    {{ \Carbon\Carbon::parse($event->event_date)->format('d/m/Y à H:i') }}
                </p>
                <p><i class="bi bi-geo-alt me-2 text-primary"></i>
                    <strong>Lieu :</strong> {{ $event->location }}
                </p>
                <p><i class="bi bi-text-paragraph me-2 text-primary"></i>
                    <strong>Description :</strong> {{ $event->description ?? '—' }}
                </p>
            </div>
            <div class="col-md-6">
                <p><i class="bi bi-people me-2 text-primary"></i>
                    <strong>Participants :</strong>
                    {{ $event->participants->count() }} / {{ $event->max_participants }}
                </p>
                <p><i class="bi bi-flag me-2 text-primary"></i>
                    <strong>Statut :</strong>
                    @if($event->status === 'upcoming')
                        <span class="badge bg-primary">À venir</span>
                    @elseif($event->status === 'ongoing')
                        <span class="badge bg-success">En cours</span>
                    @elseif($event->status === 'cancelled')
                        <span class="badge bg-danger">Annulé</span>
                    @else
                        <span class="badge bg-secondary">Terminé</span>
                    @endif
                </p>
            </div>
        </div>
    </div>
</div>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold"><i class="bi bi-people me-2"></i>Participants ({{ $participants->total() }})</h5>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.participants.create', ['event_id' => $event->id]) }}"
           class="btn btn-success btn-sm">
            <i class="bi bi-person-plus me-1"></i>Ajouter
        </a>
        <a href="{{ route('admin.events.export', $event) }}" class="btn btn-outline-primary btn-sm">
            <i class="bi bi-file-earmark-csv me-1"></i>Export CSV
        </a>
        <a href="{{ route('admin.events.edit', $event) }}" class="btn btn-warning btn-sm">
            <i class="bi bi-pencil me-1"></i>Modifier
        </a>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Téléphone</th>
                    <th>Statut présence</th>
                    <th>Mise à jour rapide</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($participants as $participant)
                <tr>
                    <td class="fw-semibold">{{ $participant->full_name }}</td>
                    <td>{{ $participant->email }}</td>
                    <td>{{ $participant->phone ?? '—' }}</td>
                    <td>
                        @if($participant->attendance_status === 'present')
                            <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Présent</span>
                        @elseif($participant->attendance_status === 'absent')
                            <span class="badge bg-danger"><i class="bi bi-x-circle me-1"></i>Absent</span>
                        @else
                            <span class="badge bg-warning text-dark"><i class="bi bi-clock me-1"></i>Inscrit</span>
                        @endif
                    </td>
                    <td>
                        <form action="{{ route('admin.participants.attendance', $participant) }}"
                              method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <select name="attendance_status"
                                    class="form-select form-select-sm d-inline w-auto"
                                    onchange="this.form.submit()">
                                <option value="registered" {{ $participant->attendance_status === 'registered' ? 'selected' : '' }}>Inscrit</option>
                                <option value="present" {{ $participant->attendance_status === 'present' ? 'selected' : '' }}>Présent</option>
                                <option value="absent" {{ $participant->attendance_status === 'absent' ? 'selected' : '' }}>Absent</option>
                            </select>
                        </form>
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
                        Aucun participant pour cet événement.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        {{ $participants->links() }}
    </div>
</div>
@endsection