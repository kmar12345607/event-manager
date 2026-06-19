@extends('layouts.public')
@section('title', $event->name)

@section('content')
<div class="container py-5">
    <div class="row justify-content-center g-4">

        <!-- Infos événement -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-3 sticky-top" style="top: 80px">
                <div class="card-body p-4">
                    <h4 class="fw-bold mb-1">{{ $event->name }}</h4>
                    @php
                        $isFull = $event->participants_count >= $event->max_participants;
                        $percent = $event->max_participants > 0
                            ? round(($event->participants_count / $event->max_participants) * 100)
                            : 0;
                    @endphp
                    <span class="badge bg-primary mb-3">
                        {{ $event->status === 'upcoming' ? 'À venir' : 'En cours' }}
                    </span>

                    <ul class="list-unstyled text-muted mb-4">
                        <li class="mb-2">
                            <i class="bi bi-calendar3 me-2 text-primary"></i>
                            {{ $event->event_date->format('l d F Y à H:i') }}
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-geo-alt me-2 text-primary"></i>
                            {{ $event->location }}
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-people me-2 text-primary"></i>
                            {{ $event->participants_count }} / {{ $event->max_participants }} inscrits
                        </li>
                    </ul>

                    <!-- Barre capacité -->
                    <div class="mb-4">
                        <div class="d-flex justify-content-between small text-muted mb-1">
                            <span>Remplissage</span>
                            <span>{{ $percent }}%</span>
                        </div>
                        <div class="progress" style="height:8px;border-radius:4px">
                            <div class="progress-bar {{ $percent >= 90 ? 'bg-danger' : ($percent >= 60 ? 'bg-warning' : 'bg-success') }}"
                                 style="width:{{ $percent }}%"></div>
                        </div>
                    </div>

                    @if($event->description)
                        <p class="text-muted small">{{ $event->description }}</p>
                    @endif

                    <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-arrow-left me-1"></i> Retour aux événements
                    </a>
                </div>
            </div>
        </div>

        <!-- Formulaire d'inscription -->
        <div class="col-lg-6">
            @if($isFull)
                <div class="card border-0 shadow-sm rounded-3 text-center p-5">
                    <i class="bi bi-calendar-x fs-1 text-danger mb-3"></i>
                    <h5 class="fw-semibold">Événement complet</h5>
                    <p class="text-muted">Toutes les places ont été prises. Revenez pour les prochains événements.</p>
                    <a href="{{ route('home') }}" class="btn btn-primary mt-2">
                        Voir d'autres événements
                    </a>
                </div>
            @else
                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-body p-4">
                        <h5 class="fw-semibold mb-1">S'inscrire à cet événement</h5>
                        <p class="text-muted small mb-4">
                            Remplissez le formulaire ci-dessous pour réserver votre place.
                        </p>

                        <form action="{{ route('public.events.register', $event) }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label fw-medium">
                                    Nom complet <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="full_name"
                                       class="form-control @error('full_name') is-invalid @enderror"
                                       value="{{ old('full_name') }}"
                                       placeholder="Ex: Ahmed Ben Ali">
                                @error('full_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-medium">
                                    Email <span class="text-danger">*</span>
                                </label>
                                <input type="email" name="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       value="{{ old('email') }}"
                                       placeholder="Ex: ahmed@gmail.com">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-medium">Téléphone</label>
                                <input type="text" name="phone"
                                       class="form-control @error('phone') is-invalid @enderror"
                                       value="{{ old('phone') }}"
                                       placeholder="Ex: +216 22 111 111">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-medium">Notes / Questions</label>
                                <textarea name="notes" class="form-control" rows="3"
                                          placeholder="Une question ou remarque ?">{{ old('notes') }}</textarea>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
                                <i class="bi bi-check-circle me-2"></i>Confirmer mon inscription
                            </button>

                            <p class="text-muted text-center mt-3" style="font-size:.75rem">
                                <i class="bi bi-shield-check me-1"></i>
                                Vos données sont utilisées uniquement pour la gestion de cet événement.
                            </p>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection