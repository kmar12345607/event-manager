<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEventRequest extends FormRequest
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

    public function messages(): array
    {
        return [
            'name.required'             => "Le nom de l'événement est obligatoire.",
            'event_date.required'       => 'La date et l\'heure sont obligatoires.',
            'location.required'         => 'Le lieu est obligatoire.',
            'max_participants.required' => 'Le nombre maximum de participants est obligatoire.',
            'max_participants.min'      => 'Il faut au moins 1 place disponible.',
        ];
    }
}
