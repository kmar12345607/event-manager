@extends('layouts.public')

@section('title', 'Mon espace')

@section('content')
<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div>
            <h2 class="fw-bold mb-1" style="color:#1e293b;">
                <i class="bi bi-person-circle me-2 text-primary"></i>Bonjour {{ auth()->user()->name }}
            </h2>
            <p class="text-muted mb-0">Voici la liste de vos inscriptions aux événements.</p>
        </div>
        <a href="{{ route('participant.profile') }}" class="btn btn-outline-primary">
            <i class="bi bi-gear me-1"></i>Mon profil
        </a>
    </div>

    @if($inscriptions->isEmpty())
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5 text-muted">
                <i class="bi bi-calendar-x fs-1 d-block mb-3"></i>
                <p class="mb-3">Vous n'êtes inscrit à aucun événement pour le moment.</p>
                <a href="{{ route('home') }}" class="btn btn-primary">
                    <i class="bi bi-search me-1"></i>Découvrir les événements
                </a>
            </div>
        </div>
    @else
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Événement</th>
                                <th>Date</th>
                                <th>Lieu</th>
                                <th>Date d'inscription</th>
                                <th class="pe-4">Statut de présence</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($inscriptions as $inscription)
                            <tr>
                                <td class="ps-4 fw-semibold">
                                    @if($inscription->event)
                                        <a href="{{ route('public.events.show', $inscription->event) }}" class="text-decoration-none">
                                            {{ $inscription->event->name }}
                                        </a>
                                    @else
                                        <span class="text-muted">Événement supprimé</span>
                                    @endif
                                </td>
                                <td>{{ $inscription->event ? \Carbon\Carbon::parse($inscription->event->event_date)->format('d/m/Y') : '—' }}</td>
                                <td>{{ $inscription->event->location ?? '—' }}</td>
                                <td>{{ \Carbon\Carbon::parse($inscription->registration_date)->format('d/m/Y') }}</td>
                                <td class="pe-4">
                                    @if($inscription->attendance_status === 'present')
                                        <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Présent</span>
                                    @elseif($inscription->attendance_status === 'absent')
                                        <span class="badge bg-danger"><i class="bi bi-x-circle me-1"></i>Absent</span>
                                    @else
                                        <span class="badge bg-warning text-dark"><i class="bi bi-clock me-1"></i>Inscrit</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif

</div>
@endsection
