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

    public function update(Request $request, $id) {
        $request->validate([
            'name' => 'required',
            'email' => "required|email|unique:users,email,$id",
            'roles' => 'required'
        ]);

        $input = $request->all();
        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id', $id)->delete();

        $user->assignRole($request->input('roles'));
        $this->infoToast('User updated successfully');
        return redirect()->route('users.index');
    }

    public function destroy($id) {
        User::find($id)->delete();
        $this->successToast('User deleted successfully');
        return redirect()->route('users.index');
    }
}
