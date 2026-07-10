@extends('layouts.app')

@section('title', 'Nouveau participant')
@section('page-title', 'Nouveau participant')
@section('page-sub', 'Inscrivez un participant à un événement')

@section('content')
<div class="card shadow-sm mx-auto" style="max-width: 700px">
    <div class="card-header bg-primary text-white">
        <h4 class="mb-0"><i class="bi bi-person-plus me-2"></i>Nouveau participant</h4>
    </div>
    <div class="card-body p-4">
        <form action="{{ route('admin.participants.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label fw-bold">Événement</label>
                <select name="event_id" class="form-select @error('event_id') is-invalid @enderror">
                    <option value="">-- Choisir un événement --</option>
                    @foreach($events as $event)
                        <option value="{{ $event->id }}"
                            {{ (old('event_id', $selectedEvent) == $event->id) ? 'selected' : '' }}>
                            {{ $event->name }} ({{ \Carbon\Carbon::parse($event->event_date)->format('d/m/Y') }})
                        </option>
                    @endforeach
                </select>
                @error('event_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Nom complet</label>
                    <input type="text" name="full_name"
                           class="form-control @error('full_name') is-invalid @enderror"
                           value="{{ old('full_name') }}" placeholder="Prénom Nom">
                    @error('full_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Email</label>
                    <input type="email" name="email"
                           class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email') }}" placeholder="email@exemple.com">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Téléphone</label>
                    <input type="text" name="phone" class="form-control"
                           value="{{ old('phone') }}" placeholder="2X XXX XXX">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Date d'inscription</label>
                    <input type="date" name="registration_date"
                           class="form-control @error('registration_date') is-invalid @enderror"
                           value="{{ old('registration_date', date('Y-m-d')) }}">
                    @error('registration_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Statut de présence</label>
                    <select name="attendance_status" class="form-select">
                        <option value="registered" {{ old('attendance_status') == 'registered' ? 'selected' : '' }}>
                            Inscrit
                        </option>
                        <option value="present" {{ old('attendance_status') == 'present' ? 'selected' : '' }}>
                            Présent
                        </option>
                        <option value="absent" {{ old('attendance_status') == 'absent' ? 'selected' : '' }}>
                            Absent
                        </option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Notes <span class="text-muted fw-normal">(optionnel)</span></label>
                    <input type="text" name="notes" class="form-control"
                           value="{{ old('notes') }}" placeholder="Notes supplémentaires...">
                </div>
            </div>

            <div class="d-flex gap-2 mt-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-1"></i> Inscrire
                </button>
                <a href="{{ route('admin.participants.index') }}" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection