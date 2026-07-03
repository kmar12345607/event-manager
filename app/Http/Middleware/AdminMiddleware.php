<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Si pas connecté → page login
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Si connecté mais pas admin → page d'accueil avec message
        if (!auth()->user()->isAdmin()) {
            return redirect()->route('home')
                ->with('error', 'Accès réservé aux administrateurs.');
        }

        return $next($request);
    }
}