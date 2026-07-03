<?php

use App\Http\Controllers\Api\PublicEventApiController;
use Illuminate\Support\Facades\Route;

// ─── API publique en lecture seule (sans authentification) ───
// GET /api/events           → liste des événements ouverts aux inscriptions
// GET /api/events/{event}   → détail d'un événement

Route::get('/events', [PublicEventApiController::class, 'index']);
Route::get('/events/{event}', [PublicEventApiController::class, 'show']);
