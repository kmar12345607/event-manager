@extends('layouts.app')

@push('styles')
    @vite('resources/css/app.css')
@endpush

@section('title', 'Profil')
@section('page-title', 'Mon profil')
@section('page-sub', 'Gérez vos informations de compte et votre mot de passe')

@section('content')
    <div class="py-2">
        <div class="mx-auto" style="max-width: 720px;">
            <div class="page-card mb-4">
                <div class="p-4">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="page-card mb-4">
                <div class="p-4">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="page-card mb-4">
                <div class="p-4">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
@endsection
