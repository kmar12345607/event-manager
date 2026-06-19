@extends('layouts.app')

@section('content')
<div class="card shadow-sm mx-auto" style="max-width: 700px">
    <div class="card-header bg-warning">
        <h4 class="mb-0"><i class="bi bi-pencil me-2"></i>Modifier le participant</h4>
    </div>
    <div class="card-body p-4">
        <form action="{{ route('participants.update', $participant) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label fw-bold">Événement</label>
                <select name="event_id" class="form-select">
                    @foreach($events as $event)
                        <option value="{{ $event->id }}"
                            {{ $participant->event_id == $event->id ? 'selected' : '' }}>
                            {{ $event->name }} ({{ \Carbon\Carbon::parse($event->event_date)->format('d/m/Y') }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Nom complet</label>
                    <input type="text" name="full_name" class="form-control"
                           value="{{ old('full_name', $participant->full_name) }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Email</label>
                    <input type="email" name="email" class="form-control"
                           value="{{ old('email', $participant->email) }}">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Téléphone</label>
                    <input type="text" name="phone" class="form-control"
                           value="{{ old('phone', $participant->phone) }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Date d'inscription</label>
                    <input type="date" name="registration_date" class="form-control"
                           value="{{ old('registration_date', $participant->registration_date) }}">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Statut de présence</label>
                    <select name="attendance_status" class="form-select">
                        <option value="registered" {{ $participant->attendance_status == 'registered' ? 'selected' : '' }}>Inscrit</option>
                        <option value="present" {{ $participant->attendance_status == 'present' ? 'selected' : '' }}>Présent</option>
                        <option value="absent" {{ $participant->attendance_status == 'absent' ? 'selected' : '' }}>Absent</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Notes</label>
                    <input type="text" name="notes" class="form-control"
                           value="{{ old('notes', $participant->notes) }}">
                </div>
            </div>

            <div class="d-flex gap-2 mt-2">
                <button type="submit" class="btn btn-warning">
                    <i class="bi bi-check-circle me-1"></i> Mettre à jour
                </button>
                <a href="{{ route('participants.index') }}" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection