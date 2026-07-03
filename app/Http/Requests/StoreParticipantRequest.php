<?php

namespace App\Http\Requests;

use App\Models\Event;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class StoreParticipantRequest extends FormRequest
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

    /**
     * Règles métier avancées :
     * - un même email ne peut pas être inscrit deux fois au même événement
     * - impossible d'inscrire un participant sur un événement complet
     */
    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            if (! $this->filled('event_id') || ! $this->filled('email')) {
                return;
            }

            $event = Event::find($this->event_id);

            if (! $event) {
                return;
            }

            $alreadyRegistered = $event->participants()
                ->where('email', $this->email)
                ->exists();

            if ($alreadyRegistered) {
                $validator->errors()->add('email', 'Cet email est déjà inscrit à cet événement.');
            }

            if ($event->participants()->count() >= $event->max_participants) {
                $validator->errors()->add('event_id', 'Cet événement est complet, plus de places disponibles.');
            }
        });
    }
}
