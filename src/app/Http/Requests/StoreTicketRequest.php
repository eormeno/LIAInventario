<?php

namespace App\Http\Requests;

use App\Traits\ToastTrigger;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class StoreTicketRequest extends FormRequest
{
    use ToastTrigger;

    public function authorize()
    {
        return true; // Asegúrate de manejar autorizaciones si es necesario
    }

    public function rules()
    {
        return [
            'asset_code' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    if (!\App\Models\Asset::where('codigo_inventario', $value)
                                          ->orWhere('codigo_patrimonio', $value)->exists()) {
                        $fail('El código de activo no es válido.');
                    }
                }
            ],
            'subject' => 'required|string|max:255',
            'description' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'asset_code.required' => 'El código de activo es obligatorio.',
            'subject.required' => 'El asunto es obligatorio.',
            'description.required' => 'La descripción es requerida.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $this->errorToast($validator->errors()->first());
        parent::failedValidation($validator);
    }
}