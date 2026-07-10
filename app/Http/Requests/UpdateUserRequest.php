<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Validator;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $user = $this->route('user');

        return [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => ['nullable', 'confirmed', Password::defaults()],
            'role'     => ['required', 'in:admin,participant'],
        ];
    }

    /**
     * Règle métier : un admin ne peut pas se rétrograder / se supprimer lui-même,
     * pour éviter de se retrouver bloqué hors du back-office.
     */
    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            $user = $this->route('user');

            if ($user && $user->id === auth()->id() && $this->role !== 'admin') {
                $validator->errors()->add('role', 'Vous ne pouvez pas retirer votre propre rôle administrateur.');
            }
        });
    }
}
