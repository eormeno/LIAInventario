<?php

namespace App\Http\Requests;

use App\Traits\ToastTrigger;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class StoreUserRequest extends FormRequest {
    use ToastTrigger;

    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        // Reglas base que aplican tanto para crear como actualizar
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email'],
            'roles' => ['required', 'array'],
            'coordinador' => ['nullable', 'boolean'],
        ];

        // Reglas adicionales para campos personales
        $personalFields = [
            'nombres' => ['required', 'string'],
            'apellidos' => ['required', 'string'],
            'registro' => ['required', 'string'],
            'cuil' => ['required', 'string'],
            'nacimiento' => ['required', 'date'],
            'telefono' => ['required', 'string'],
            'domicilio' => ['required', 'string'],
            'area' => ['required', 'string'],
        ];

        if ($this->isMethod('POST')) {
            // Reglas específicas para creación
            $rules['password'] = ['required', 'confirmed'];
            $rules['profile_photo'] = ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'];
            $rules['email'] = ['required', 'email', 'unique:users,email'];
            
            // Agregar campos personales requeridos para creación
            $rules = array_merge($rules, $personalFields);
        } else {
            // Reglas específicas para actualización
            $rules['password'] = ['nullable', 'confirmed'];
            $rules['profile_photo'] = ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'];
            $rules['email'] = ['required', 'email', 'unique:users,email,' . $this->user->id];

            // Modificar campos personales para que sean opcionales en actualización
            foreach ($personalFields as $field => $fieldRules) {
                $rules[$field] = ['nullable', ...$fieldRules];
            }
        }

        return $rules;
    }

    public function messages(): array {
        return [
            // name
            'name.required' => 'El nombre es requerido.',
            'name.string' => 'El nombre debe ser texto.',
            'name.max' => 'El nombre no puede tener más de 255 caracteres.',

            // email
            'email.required' => 'El correo es requerido.',
            'email.email' => 'El correo debe ser un formato válido.',
            'email.unique' => 'Este correo ya está registrado.',

            // password
            'password.required' => 'La contraseña es requerida.',
            'password.confirmed' => 'Las contraseñas no coinciden.',

            // roles
            'roles.required' => 'Se debe asignar al menos un rol.',
            'roles.array' => 'Los roles deben ser una lista válida.',

            // profile_photo
            'profile_photo.required' => 'La foto de perfil es requerida.',
            'profile_photo.image' => 'El archivo debe ser una imagen.',
            'profile_photo.mimes' => 'La imagen debe ser de tipo: jpeg, png, jpg, gif, svg.',
            'profile_photo.max' => 'La imagen no debe pesar más de 2MB.',

            // coordinador
            'coordinador.boolean' => 'El campo Coordinador debe ser verdadero o falso.',

            // nombres
            'nombres.required' => 'El nombre es requerido.',
            'nombres.string' => 'El nombre debe ser texto.',

            // apellidos
            'apellidos.required' => 'El apellido es requerido.',
            'apellidos.string' => 'El apellido debe ser texto.',

            // registro
            'registro.required' => 'El registro es requerido.',
            'registro.string' => 'El registro debe ser texto.',

            // cuil
            'cuil.required' => 'El CUIL es requerido.',
            'cuil.string' => 'El CUIL debe ser texto.',

            // nacimiento
            'nacimiento.required' => 'La fecha de nacimiento es requerida.',
            'nacimiento.date' => 'La fecha de nacimiento debe ser una fecha válida.',

            // teléfono
            'telefono.required' => 'El teléfono es requerido.',
            'telefono.string' => 'El teléfono debe ser texto.',

            // domicilio
            'domicilio.required' => 'El domicilio es requerido.',
            'domicilio.string' => 'El domicilio debe ser texto.',

            // area
            'area.required' => 'El área es requerida.',
            'area.string' => 'El área debe ser texto.',
        ];
    }

    protected function failedValidation(Validator $validator) {
        $this->errorToast($validator->errors()->first());
        parent::failedValidation($validator);
    }
}