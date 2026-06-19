<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\DashboardController;

// ─── FRONT-OFFICE public ──────────────────────────
Route::get('/', [PublicController::class, 'home'])->name('home');

Route::get('/event/{event}', [PublicController::class, 'show'])
     ->name('public.events.show');

Route::post('/event/{event}/register', [PublicController::class, 'register'])
     ->name('public.events.register');

// ─── BACK-OFFICE admin (protégé) ─────────────────
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
         ->name('dashboard');

    // Profil (généré par Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])
         ->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])
         ->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])
         ->name('profile.destroy');

    // Événements
    Route::resource('events', EventController::class);

    // Participants — route simple (pas imbriquée) pour garder participants.edit etc.
    Route::resource('participants', ParticipantController::class);

    // Changer statut de présence
    Route::patch(
        'participants/{participant}/attendance',
        [ParticipantController::class, 'updateAttendance']
    )->name('participants.attendance');

    // Export CSV
    Route::get(
        'events/{event}/export',
        [ParticipantController::class, 'export']
    )->name('events.export');
});

require __DIR__.'/auth.php';