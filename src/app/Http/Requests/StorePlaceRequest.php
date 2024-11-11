<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePlaceRequest extends FormRequest {
    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
        ];
    }

    public function messages(): array {
        return [
            'name.required' => 'El nombre del lugar es requerido',
            'name.string' => 'El nombre del lugar debe ser una cadena de texto',
            'name.max' => 'El nombre del lugar no debe exceder los 255 caracteres',
            'description.required' => 'La descripción del lugar es requerida',
            'description.string' => 'La descripción del lugar debe ser una cadena de texto',
        ];
    }
}