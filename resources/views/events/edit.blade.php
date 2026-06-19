@extends('layouts.app')

@section('content')
<div class="card shadow-sm mx-auto" style="max-width: 700px">
    <div class="card-header bg-warning">
        <h4 class="mb-0"><i class="bi bi-pencil me-2"></i>Modifier l'événement</h4>
    </div>
    <div class="card-body p-4">
        <form action="{{ route('events.update', $event) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label fw-bold">Nom de l'événement</label>
                <input type="text" name="name" class="form-control"
                       value="{{ old('name', $event->name) }}">
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Date et heure</label>
                    <input type="datetime-local" name="event_date" class="form-control"
                           value="{{ old('event_date', \Carbon\Carbon::parse($event->event_date)->format('Y-m-d\TH:i')) }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Lieu</label>
                    <input type="text" name="location" class="form-control"
                           value="{{ old('location', $event->location) }}">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Description</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description', $event->description) }}</textarea>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Max participants</label>
                    <input type="number" name="max_participants" class="form-control"
                           value="{{ old('max_participants', $event->max_participants) }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Statut</label>
                    <select name="status" class="form-select">
                        <option value="upcoming" {{ $event->status == 'upcoming' ? 'selected' : '' }}>À venir</option>
                        <option value="ongoing" {{ $event->status == 'ongoing' ? 'selected' : '' }}>En cours</option>
                        <option value="completed" {{ $event->status == 'completed' ? 'selected' : '' }}>Terminé</option>
                        <option value="cancelled" {{ $event->status == 'cancelled' ? 'selected' : '' }}>Annulé</option>
                    </select>
                </div>
            </div>

            <div class="d-flex gap-2 mt-2">
                <button type="submit" class="btn btn-warning">
                    <i class="bi bi-check-circle me-1"></i> Mettre à jour
                </button>
                <a href="{{ route('events.index') }}" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection