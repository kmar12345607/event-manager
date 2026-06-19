@extends('layouts.app')

@section('content')
<div class="card shadow-sm mx-auto" style="max-width: 700px">
    <div class="card-header bg-primary text-white">
        <h4 class="mb-0"><i class="bi bi-plus-circle"></i> Nouvel événement</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('events.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-bold">Nom de l'événement</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name') }}">
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="row">
                <div class="col mb-3">
                    <label class="form-label fw-bold">Date</label>
                    <input type="date" name="date" class="form-control @error('date') is-invalid @enderror"
                           value="{{ old('date') }}">
                    @error('date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col mb-3">
                    <label class="form-label fw-bold">Lieu</label>
                    <input type="text" name="location" class="form-control @error('location') is-invalid @enderror"
                           value="{{ old('location') }}">
                    @error('location') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Description</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
            </div>
            <div class="row">
                <div class="col mb-3">
                    <label class="form-label fw-bold">Max participants</label>
                    <input type="number" name="max_participants" class="form-control" value="{{ old('max_participants') }}">
                </div>
                <div class="col mb-3">
                    <label class="form-label fw-bold">Statut</label>
                    <select name="status" class="form-select">
                        <option value="active">Actif</option>
                        <option value="cancelled">Annulé</option>
                        <option value="done">Terminé</option>
                    </select>
                </div>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle"></i> Créer
                </button>
                <a href="{{ route('events.index') }}" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection