@extends('layouts.app')

@section('title', 'Participants')
@section('page-title', 'Participants')
@section('page-sub', 'Gérez tous les participants inscrits')

@section('page-actions')
    <a href="{{ route('admin.participants.create') }}" class="btn-primary">
        <i class="bi bi-person-plus"></i> Nouveau participant
    </a>
@endsection

@section('content')

<!-- Recherche -->
<div class="card shadow-sm mb-4">
    <div class="card-body py-2">
        <form method="GET" action="{{ route('admin.participants.index') }}">
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0">
                    <i class="bi bi-search text-muted"></i>
                </span>
                <input type="text" name="search" class="form-control border-start-0"
                       placeholder="Rechercher par nom ou email..."
                       value="{{ request('search') }}">
                <button class="btn btn-primary" type="submit">Rechercher</button>
                @if(request('search'))
                    <a href="{{ route('admin.participants.index') }}" class="btn btn-outline-secondary">✕</a>
                @endif
            </div>
        </form>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <table class="table table-hover align-middle">
            <thead class="table-primary">
                <tr>
                    <th>Nom complet</th>
                    <th>Email</th>
                    <th>Téléphone</th>
                    <th>Événement</th>
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
                    <td>
                        <a href="{{ route('admin.events.show', $participant->event_id) }}"
                           class="text-decoration-none">
                            {{ $participant->event->name ?? '—' }}
                        </a>
                    </td>
                    <td>{{ \Carbon\Carbon::parse($participant->registration_date)->format('d/m/Y') }}</td>
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
                    <td colspan="7" class="text-center text-muted py-4">
                        <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                        Aucun participant trouvé.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        {{ $participants->links() }}
    </div>
</div>
@endsection