<?php

namespace App\Http\Requests;

use App\Traits\ToastTrigger;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class StoreAssetRequest extends FormRequest
{
    use ToastTrigger;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Reglas comunes para crear y actualizar
        $rules = [
            'nombre' => ['required', 'string', 'max:255'],
            'codigo_inventario' => ['required', 'string'],
            'codigo_patrimonio' => ['required', 'string'],
            'detalle' => ['required', 'string'],
            'imagen' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'tipo' => ['required', 'string'],
            'cantidad' => ['required', 'integer'],
            'alta' => ['nullable', 'date'],
            'baja' => ['nullable', 'date'],
            'observaciones' => ['nullable', 'string'],
            'place_id' => ['nullable', 'exists:places,id'], // Validación para place_id
        ];

        if ($this->isMethod('POST')) {
            // Reglas específicas para creación
            $rules['codigo_inventario'][] = 'unique:assets,codigo_inventario';
            $rules['codigo_patrimonio'][] = 'unique:assets,codigo_patrimonio';
        } else {
            // Reglas específicas para actualización
            $rules['codigo_inventario'][] = 'unique:assets,codigo_inventario,' . $this->asset->id;
            $rules['codigo_patrimonio'][] = 'unique:assets,codigo_patrimonio,' . $this->asset->id;
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.string' => 'El nombre debe ser texto.',
            'nombre.max' => 'El nombre no puede tener más de 255 caracteres.',

            'codigo_inventario.required' => 'El código de inventario es obligatorio.',
            'codigo_inventario.string' => 'El código de inventario debe ser texto.',
            'codigo_inventario.unique' => 'El código de inventario ya está registrado.',

            'codigo_patrimonio.required' => 'El código de patrimonio es obligatorio.',
            'codigo_patrimonio.string' => 'El código de patrimonio debe ser texto.',
            'codigo_patrimonio.unique' => 'El código de patrimonio ya está registrado.',

            'detalle.required' => 'El detalle es obligatorio.',
            'detalle.string' => 'El detalle debe ser texto.',

            'imagen.image' => 'El archivo debe ser una imagen.',
            'imagen.mimes' => 'La imagen debe ser de tipo: jpg, jpeg o png.',
            'imagen.max' => 'La imagen no debe superar los 2MB.',

            'tipo.required' => 'El tipo es obligatorio.',
            'tipo.string' => 'El tipo debe ser texto.',

            'cantidad.required' => 'La cantidad es obligatoria.',
            'cantidad.integer' => 'La cantidad debe ser un número entero.',

            'alta.date' => 'La fecha de alta debe ser una fecha válida.',

            'baja.date' => 'La fecha de baja debe ser una fecha válida.',

            'observaciones.string' => 'Las observaciones deben ser texto.',

            'place_id.exists' => 'El lugar seleccionado no es válido.', // Mensaje de validación para place_id
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $this->errorToast($validator->errors()->first());
        parent::failedValidation($validator);
    }
}
