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
    return [
      'name' => ['required', 'string', 'max:255'],
      'email' => ['required', 'email', 'unique:users,email'],
      'password' => ['required', 'confirmed'],
      'roles' => ['required', 'array'],
      'profile_photo' => ['required','image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
      'coordinador' => ['nullable', 'boolean'], // Validar si es booleano
      'nombres' => ['required', 'string'],
      'apellidos' => ['required', 'string'],
      'registro' => ['required', 'string'],
      'cuil' => ['required', 'string'],
      'nacimiento' => ['required', 'date'],
      'telefono' => ['required', 'string'],
      'domicilio' => ['required', 'string'],
      'area' => ['required', 'string'],
    ];
  }

  public function messages(): array {
    return [
      'name.required' => 'El nombre es requerido.',
      'email.required' => 'El correo es requerido.',
      'email.email' => 'El correo debe ser un formato válido.',
      'password.required' => 'La contraseña es requerida.',
      'password.confirmed' => 'Las contraseñas no coinciden.',
      'roles.required' => 'Se debe asignar al menos un rol.',
      'profile_photo.regex' => 'La imagen debe estar en formato base64 válido.',
      'coordinador.boolean' => 'El campo Coordinador debe ser verdadero o falso.',
      'nombres.required' => 'El nombre es requerido.',
      'apellidos.required' => 'El apellido es requerido.',
      'cuil.required' => 'El CUIL es requerido.',
      'nacimiento.required' => 'La fecha de nacimiento es requerida.',
      'telefono.required' => 'El teléfono es requerido.',
      'domicilio.required' => 'El domicilio es requerido.',
      'area.required' => 'El área es requerida.',
    ];
  }

  protected function failedValidation(Validator $validator) {
    $this->errorToast($validator->errors()->first());
    parent::failedValidation($validator);
  }
}
