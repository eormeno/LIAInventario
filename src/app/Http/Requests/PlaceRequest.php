<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\ToastTrigger;


class PlaceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['string'], // Base para ambos métodos
        ];

        // Si es un método POST (crear), hacemos que la descripción sea obligatoria
        if ($this->isMethod('POST')) {
            $rules['description'][] = 'required';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre del lugar es requerido',
            'name.string' => 'El nombre del lugar debe ser una cadena de texto',
            'name.max' => 'El nombre del lugar no debe exceder los 255 caracteres',
            'description.required' => 'La descripción del lugar es requerida',
            'description.string' => 'La descripción del lugar debe ser una cadena de texto',
        ];
    }
}