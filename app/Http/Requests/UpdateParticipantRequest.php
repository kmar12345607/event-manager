<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class UpdateParticipantRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'event_id'          => ['required', 'exists:events,id'],
            'full_name'         => ['required', 'string', 'max:255'],
            'email'             => ['required', 'email', 'max:255'],
            'phone'             => ['nullable', 'string', 'max:20'],
            'registration_date' => ['required', 'date'],
            'attendance_status' => ['required', 'in:registered,present,absent'],
            'notes'             => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            $participant = $this->route('participant');

            if (! $participant || ! $this->filled('event_id') || ! $this->filled('email')) {
                return;
            }

            $duplicate = \App\Models\Participant::where('event_id', $this->event_id)
                ->where('email', $this->email)
                ->where('id', '!=', $participant->id)
                ->exists();

            if ($duplicate) {
                $validator->errors()->add('email', 'Cet email est déjà inscrit à cet événement.');
            }
        });
    }
}
