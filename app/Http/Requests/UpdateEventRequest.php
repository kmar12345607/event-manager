<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class UpdateEventRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'             => ['required', 'string', 'max:255'],
            'event_date'       => ['required', 'date'],
            'location'         => ['required', 'string', 'max:255'],
            'description'      => ['nullable', 'string', 'max:2000'],
            'max_participants' => ['required', 'integer', 'min:1', 'max:100000'],
            'status'           => ['required', 'in:upcoming,ongoing,completed,cancelled'],
        ];
    }

    /**
     * Règle métier : on ne peut pas fixer une capacité maximale
     * inférieure au nombre de participants déjà inscrits.
     */
    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            $event = $this->route('event');

            if (! $event) {
                return;
            }

            $currentCount = $event->participants()->count();

            if ($this->filled('max_participants') && (int) $this->max_participants < $currentCount) {
                $validator->errors()->add(
                    'max_participants',
                    "Impossible : {$currentCount} participant(s) déjà inscrit(s). La capacité minimale est {$currentCount}."
                );
            }
        });
    }
}
