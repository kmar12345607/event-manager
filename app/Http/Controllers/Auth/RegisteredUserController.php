<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'participant', // ← toujours participant à l'inscription
        ]);

        event(new Registered($user));

        Auth::login($user);

        // Si le client venait d'une page événement (redirect_to), on l'y ramène
        if ($request->filled('redirect_to') && str_starts_with($request->redirect_to, url('/'))) {
            // On mémorise aussi cette destination en session : si le client va vérifier
            // son email AVANT de finir de remplir le formulaire d'inscription, il sera
            // quand même ramené ici après la vérification (et pas sur "Mon espace").
            session(['url.intended' => $request->redirect_to]);

            return redirect($request->redirect_to);
        }

        // Redirige vers l'espace participant (pas le dashboard admin)
        return redirect()->route('participant.dashboard');
    }
}