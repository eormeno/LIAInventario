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
        return true; // Cambia a `false` si no quieres que esté autorizado
    }

    public function rules()
    {
        return [
            'asset_code' => 'required|exists:assets,id',
            'subject' => 'required|string|max:255',
            'description' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'asset_code.required' => 'El código de activo es obligatorio.',
            'asset_code.exists' => 'El código de activo no es válido.',
            'subject.required' => 'El asunto es obligatorio.',
            'description.required' => 'Debes agregar un comentario'
        ];
    }

    protected function failedValidation(Validator $validator) {
        $this->errorToast($validator->errors()->first());
        parent::failedValidation($validator);
    }
}
