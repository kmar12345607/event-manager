@extends('layouts.app')

@section('title', 'Modifier le compte')
@section('page-title', 'Modifier le compte')
@section('page-sub', 'Mettez à jour les informations du compte')

@section('content')
<div class="card shadow-sm mx-auto" style="max-width: 700px">
    <div class="card-header bg-warning">
        <h4 class="mb-0"><i class="bi bi-pencil me-2"></i>Modifier le compte</h4>
    </div>
    <div class="card-body p-4">
        <form action="{{ route('admin.users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label fw-bold">Nom complet</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name', $user->name) }}">
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Email</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                       value="{{ old('email', $user->email) }}">
                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Nouveau mot de passe <span class="text-muted fw-normal">(optionnel)</span></label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Confirmer</label>
                    <input type="password" name="password_confirmation" class="form-control">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Rôle</label>
                <select name="role" class="form-select @error('role') is-invalid @enderror"
                        {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                    <option value="participant" {{ $user->role == 'participant' ? 'selected' : '' }}>Participant</option>
                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Administrateur</option>
                </select>
                @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
                @if($user->id === auth()->id())
                    <input type="hidden" name="role" value="admin">
                    <small class="text-muted">Vous ne pouvez pas changer votre propre rôle.</small>
                @endif
            </div>

            <div class="d-flex gap-2 mt-2">
                <button type="submit" class="btn btn-warning">
                    <i class="bi bi-check-circle me-1"></i> Mettre à jour
                </button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection
