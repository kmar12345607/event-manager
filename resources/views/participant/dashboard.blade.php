@extends('layouts.public')

@section('title', 'Mon espace')

@section('content')
<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div data-intro="Bienvenue dans ton espace personnel ! Tu y retrouves toutes tes inscriptions et leur statut de présence."
             data-step="1"
             data-title="Mon espace">
            <h2 class="fw-bold mb-1" style="color:#1e293b;">
                <i class="bi bi-person-circle me-2 text-primary"></i>Bonjour {{ auth()->user()->name }}
            </h2>
            <p class="text-muted mb-0">Voici la liste de vos inscriptions aux événements.</p>
        </div>
        <a href="{{ route('participant.profile') }}" class="btn btn-outline-primary"
           data-intro="Clique ici pour voir tes informations personnelles."
           data-step="3"
           data-title="Mon profil">
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
        <div class="card border-0 shadow-sm"
             data-intro="Chaque ligne est un événement auquel tu es inscrit, avec la date et le lieu."
             data-step="2"
             data-title="Tes inscriptions">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Événement</th>
                                <th>Date</th>
                                <th>Lieu</th>
                                <th>Date d'inscription</th>
                                <th>Statut de présence</th>
                                <th class="pe-4">Billet</th>
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
                                <td>
                                    @if($inscription->attendance_status === 'present')
                                        <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Présent</span>
                                    @elseif($inscription->attendance_status === 'absent')
                                        <span class="badge bg-danger"><i class="bi bi-x-circle me-1"></i>Absent</span>
                                    @else
                                        <span class="badge bg-warning text-dark"><i class="bi bi-clock me-1"></i>Inscrit</span>
                                    @endif
                                </td>
                                <td class="pe-4">
                                    @if($inscription->event && $inscription->attendance_status !== 'absent')
                                        <button type="button" class="btn btn-sm btn-outline-dark"
                                                data-bs-toggle="modal"
                                                data-bs-target="#ticketModal"
                                                data-code="{{ $inscription->ticket_code }}"
                                                data-event="{{ $inscription->event->name }}"
                                                data-name="{{ $inscription->full_name }}"
                                                data-date="{{ \Carbon\Carbon::parse($inscription->event->event_date)->format('d/m/Y') }}">
                                            <i class="bi bi-qr-code me-1"></i>Voir
                                        </button>
                                    @else
                                        <span class="text-muted small">—</span>
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

<!-- Modale billet + QR code -->
<div class="modal fade" id="ticketModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius:16px; overflow:hidden;">
            <div class="modal-header border-0" style="background:#1e293b; color:white;">
                <h5 class="modal-title fw-bold"><i class="bi bi-ticket-perforated me-2"></i>Ton billet</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center py-4">
                <h6 id="ticket-event" class="fw-bold mb-1"></h6>
                <p id="ticket-name" class="text-muted mb-3"></p>
                <div id="ticket-qrcode" class="d-flex justify-content-center mb-3"></div>
                <p class="fw-semibold" style="letter-spacing:1px; font-family: monospace;" id="ticket-code"></p>
                <p class="text-muted small mb-0" id="ticket-date"></p>
                <p class="text-muted small mt-2">
                    <i class="bi bi-info-circle me-1"></i>Présente ce QR code à l'entrée pour valider ton accès.
                </p>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const ticketModal = document.getElementById('ticketModal');
    let qrInstance = null;

    ticketModal.addEventListener('show.bs.modal', function (event) {
        const btn = event.relatedTarget;
        const code  = btn.getAttribute('data-code');
        const event_ = btn.getAttribute('data-event');
        const name  = btn.getAttribute('data-name');
        const date  = btn.getAttribute('data-date');

        document.getElementById('ticket-event').textContent = event_;
        document.getElementById('ticket-name').textContent = name;
        document.getElementById('ticket-code').textContent = code;
        document.getElementById('ticket-date').textContent = date;

        const qrContainer = document.getElementById('ticket-qrcode');
        qrContainer.innerHTML = '';
        new QRCode(qrContainer, {
            text: code,
            width: 180,
            height: 180,
            colorDark: '#1e293b',
            colorLight: '#ffffff',
        });
    });
});
</script>
@endpush
@endsection