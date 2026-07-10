<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        // Si le client venait d'une page événement (redirect_to), on l'y ramène
        if ($request->filled('redirect_to') && $this->isSafeInternalUrl($request->redirect_to)) {
            session(['url.intended' => $request->redirect_to]);

            return redirect($request->redirect_to);
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('participant.dashboard');
    }

    // Sécurité : n'autoriser que les redirections vers notre propre site
    private function isSafeInternalUrl(string $url): bool
    {
        return str_starts_with($url, url('/'));
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}