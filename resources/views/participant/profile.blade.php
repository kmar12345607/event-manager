@extends('layouts.public')

@section('title', 'Mon profil')

@section('content')
<div class="container py-5">
    <div class="mx-auto" style="max-width: 560px;">

        <div class="mb-4">
            <a href="{{ route('participant.dashboard') }}" class="text-decoration-none text-muted">
                <i class="bi bi-arrow-left me-1"></i>Retour à mon espace
            </a>
        </div>

        <div class="card border-0 shadow-sm"
             data-intro="Voici tes informations personnelles. Elles sont en lecture seule ici : pour les modifier, contacte l'organisateur."
             data-step="1"
             data-title="Mon profil">
            <div class="card-body p-4 text-center">
                <div class="mx-auto mb-3 d-flex align-items-center justify-content-center"
                     style="width:72px;height:72px;border-radius:50%;background:#2563eb;color:#fff;font-size:1.6rem;font-weight:700;">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <h4 class="fw-bold mb-1">{{ $user->name }}</h4>
                <p class="text-muted mb-4">{{ $user->email }}</p>

                <hr>

                <div class="text-start">
                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted">Type de compte</span>
                        <span class="fw-semibold">Participant</span>
                    </div>
                    <div class="d-flex justify-content-between py-2">
                        <span class="text-muted">Membre depuis</span>
                        <span class="fw-semibold">{{ $user->created_at->format('d/m/Y') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <p class="text-muted text-center small mt-3">
            Pour modifier vos informations, contactez l'organisateur de l'événement.
        </p>
    </div>
</div>
<form method="POST" action="{{ route('logout') }}" class="text-center mt-3">
            @csrf
            <button type="submit" class="btn btn-outline-danger">
                <i class="bi bi-box-arrow-right me-1"></i>Se déconnecter
            </button>
        </form>
@endsection
