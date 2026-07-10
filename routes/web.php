<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ParticipantAccountController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CheckinController;
use App\Http\Controllers\Api\EventApiController;
use App\Http\Controllers\Api\ParticipantApiController;
use App\Http\Controllers\Api\StatsApiController;

// ─── FRONT-OFFICE public (sans login) ────────────────
Route::get('/', [PublicController::class, 'home'])->name('home');

Route::get('/event/{event}', [PublicController::class, 'show'])
     ->name('public.events.show');

Route::post('/event/{event}/register', [PublicController::class, 'register'])
     ->middleware('auth')
     ->name('public.events.register');

// ─── ESPACE PARTICIPANT (connecté, rôle participant, email vérifié) ──
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/mon-espace', [ParticipantAccountController::class, 'index'])
         ->name('participant.dashboard');
    Route::get('/mon-profil', [ParticipantAccountController::class, 'profile'])
         ->name('participant.profile');
});

// ─── BACK-OFFICE ADMIN (connecté + rôle admin) ───────
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
         ->name('dashboard');

    // Événements
    Route::resource('events', EventController::class);

    // Participants
    Route::resource('participants', ParticipantController::class);

    // Changer statut de présence
    Route::patch('participants/{participant}/attendance',
        [ParticipantController::class, 'updateAttendance']
    )->name('participants.attendance');

    // Export CSV
    Route::get('events/{event}/export',
        [ParticipantController::class, 'export']
    )->name('events.export');

    // Scanner billets (QR code check-in)
    Route::get('/scanner', [CheckinController::class, 'index'])->name('scanner');
    Route::post('/scanner/verify', [CheckinController::class, 'verify'])->name('scanner.verify');

    // Comptes utilisateurs (admin / participant)
    Route::resource('users', UserController::class);

    // Profil admin
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ─── API interne JSON (authentifiée par session, réservée admin) ───
    Route::prefix('api')->name('api.')->group(function () {
        Route::apiResource('events', EventApiController::class);
        Route::apiResource('participants', ParticipantApiController::class)->except(['store']);
        Route::post('events/{event}/participants', [ParticipantApiController::class, 'store'])->name('participants.store');
        Route::patch('participants/{participant}/attendance', [ParticipantApiController::class, 'updateAttendance'])->name('participants.attendance');
        Route::get('stats', StatsApiController::class)->name('stats');
    });
});

require __DIR__.'/auth.php';