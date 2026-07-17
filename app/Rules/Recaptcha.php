<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;

class Recaptcha implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $secret = config('services.recaptcha.secret_key');

        // Si aucune clé n'est configurée, on ne bloque pas le développeur
        // (utile tant que tu n'as pas encore mis tes clés dans .env)
        if (empty($secret)) {
            return;
        }

        if (empty($value)) {
            $fail('Merci de valider la case "Je ne suis pas un robot".');
            return;
        }

        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret'   => $secret,
            'response' => $value,
            'remoteip' => request()->ip(),
        ]);

        if (! $response->json('success', false)) {
            $fail('La vérification anti-robot a échoué, merci de réessayer.');
        }
    }
}