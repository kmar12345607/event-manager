@extends('layouts.app')

@section('content')
<div class="card shadow-sm mx-auto" style="max-width: 700px">
    <div class="card-header bg-primary text-white">
        <h4 class="mb-0"><i class="bi bi-plus-circle me-2"></i>Nouvel événement</h4>
    </div>
    <div class="card-body p-4">
        <form action="{{ route('events.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-bold">Nom de l'événement</label>
                <input type="text" name="name"
                       class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name') }}" placeholder="Ex: Conférence Tech 2026">
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Date et heure</label>
                    <input type="datetime-local" name="event_date"
                           class="form-control @error('event_date') is-invalid @enderror"
                           value="{{ old('event_date') }}">
                    @error('event_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Lieu</label>
                    <input type="text" name="location"
                           class="form-control @error('location') is-invalid @enderror"
                           value="{{ old('location') }}" placeholder="Ex: ESPRIT Tunis">
                    @error('location') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Description</label>
                <textarea name="description" class="form-control" rows="3"
                          placeholder="Description de l'événement...">{{ old('description') }}</textarea>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Max participants</label>
                    <input type="number" name="max_participants" class="form-control"
                           value="{{ old('max_participants') }}" min="1" placeholder="Ex: 100">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Statut</label>
                    <select name="status" class="form-select">
                        <option value="upcoming" {{ old('status') == 'upcoming' ? 'selected' : '' }}>À venir</option>
                        <option value="ongoing" {{ old('status') == 'ongoing' ? 'selected' : '' }}>En cours</option>
                        <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Terminé</option>
                        <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Annulé</option>
                    </select>
                </div>
            </div>

            <div class="d-flex gap-2 mt-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-1"></i> Créer
                </button>
                <a href="{{ route('events.index') }}" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection