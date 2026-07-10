@extends('layouts.app')

@section('title', 'Événements')
@section('page-title', 'Événements')
@section('page-sub', 'Gérez tous vos événements')

@section('page-actions')
    <a href="{{ route('admin.events.create') }}" class="btn-primary">
        <i class="bi bi-plus-circle"></i> Nouvel événement
    </a>
@endsection

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <table class="table table-hover align-middle">
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
                @forelse($events as $event)
                <tr>
                    <td class="fw-semibold">{{ $event->name }}</td>
                    <td>{{ \Carbon\Carbon::parse($event->event_date)->format('d/m/Y') }}</td>
                    <td>{{ $event->location }}</td>
                    <td>{{ $event->participants->count() }} / {{ $event->max_participants }}</td>
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
                        <a href="{{ route('admin.events.edit', $event) }}" class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('admin.events.destroy', $event) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Supprimer cet événement ?')">
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
                        Aucun événement trouvé.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        {{ $events->links() }}
    </div>
</div>
@endsection