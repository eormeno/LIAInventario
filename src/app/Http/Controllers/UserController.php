<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\DebugHelper;
use App\Traits\ToastTrigger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;

class UserController extends Controller {
    use DebugHelper, ToastTrigger;

    public function index(Request $request) {
        $data = User::latest()->paginate(7);
        return view('users.index', compact('data'));
    }

    public function create() {
        $roles = Role::pluck('name', 'name')->all();
        return view('users.create', compact('roles'));
    }

    public function store(StoreUserRequest $request) {
        // Los datos ya están validados en StoreUserRequest
        $validated = $request->validated();

        // Procesar la imagen
        $file = $request->file('profile_photo'); 
        $contents = file_get_contents($file);
        $base64Image = base64_encode($contents);

        // Agregar la imagen al array validado
        $validated['profile_photo'] = $base64Image;

        // Si el campo 'coordinador' está presente, se debe guardar como verdadero o falso
        $validated['coordinador'] = $request->has('coordinador') ? true : false;

        // Hashear la contraseña antes de guardarla
        $validated['password'] = Hash::make($validated['password']);

        // Crear el usuario
        $user = User::create($validated);

        // Asignar roles al usuario
        $user->assignRole($validated['roles']);

        // Redirigir con mensaje de éxito
        return redirect()->route('users.index')
            ->with('success', 'Usuario creado con éxito');
    }

    public function show($id) {
        $user = User::find($id);
        return view('users.show', compact('user'));
    }

    public function edit(User $user) {
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();
        return view('users.edit', compact('user', 'roles', 'userRole'));
    }

    public function update(StoreUserRequest $request, User $user) {
        // Los datos ya están validados por UserRequest
        $validated = $request->validated();
    
        // Si hay una nueva imagen, procesarla
        if ($request->hasFile('profile_photo')) {
            $file = $request->file('profile_photo');
            $contents = file_get_contents($file);
            $base64Image = base64_encode($contents);
            $validated['profile_photo'] = $base64Image;
        } else {
            // Si no hay nueva imagen, removemos profile_photo del array
            // para no sobrescribir la imagen existente
            unset($validated['profile_photo']);
        }
    
        // El campo coordinador debe ser booleano
        $validated['coordinador'] = $request->has('coordinador') ? true : false;
    
        // Si viene password lo hasheamos, si no, lo removemos para no sobrescribir
        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }
    
        // Actualizar el usuario
        $user->update($validated);
    
        // Actualizar roles
        if (isset($validated['roles'])) {
            DB::table('model_has_roles')->where('model_id', $user->id)->delete();
            $user->assignRole($validated['roles']);
        }
    
        $this->infoToast('Usuario actualizado exitosamente');
        return redirect()->route('users.index');
    }

    public function destroy($id) {
        User::find($id)->delete();
        $this->successToast('Usuario eliminado exitosamente');
        return redirect()->route('users.index');
    }
}
