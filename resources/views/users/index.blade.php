@extends('layouts.app')

@section('title', 'Utilisateurs')
@section('page-title', 'Comptes utilisateurs')
@section('page-sub', 'Gérez les comptes administrateurs et participants')

@section('page-actions')
    <a href="{{ route('admin.users.create') }}" class="btn-primary">
        <i class="bi bi-person-plus"></i> Nouveau compte
    </a>
@endsection

@section('content')
<div class="page-card">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Utilisateur</th>
                    <th>Email</th>
                    <th>Rôle</th>
                    <th>Créé le</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            <div style="width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,#1a237e,#1565c0);display:flex;align-items:center;justify-content:center;color:white;font-weight:800;font-size:0.85rem;flex-shrink:0;">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div class="fw-bold" style="color:#0d1b4b;">
                                {{ $user->name }}
                                @if($user->id === auth()->id())
                                    <span class="text-muted fw-normal">(vous)</span>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if($user->role === 'admin')
                            <span class="badge-status badge-present"><i class="bi bi-shield-check"></i> Admin</span>
                        @else
                            <span class="badge-status badge-registered"><i class="bi bi-person"></i> Participant</span>
                        @endif
                    </td>
                    <td>{{ $user->created_at->format('d/m/Y') }}</td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.users.edit', $user) }}" class="btn-action btn-edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            @if($user->id !== auth()->id())
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Supprimer ce compte ?')">
                                @csrf @method('DELETE')
                                <button class="btn-action btn-del"><i class="bi bi-trash"></i></button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-5 text-muted">
                        <i class="bi bi-people fs-2 d-block mb-2"></i>
                        Aucun compte trouvé.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($users->hasPages())
    <div class="p-3 border-top">{{ $users->links() }}</div>
    @endif
</div>
@endsection
