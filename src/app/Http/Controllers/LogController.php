<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\DebugHelper;
use App\Traits\ToastTrigger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class LogController extends Controller
{
    /**
     * Display a listing of the resource.
     */    
    public function index(): View {
        $logs = Log::latest()->paginate(5);
        return view('logs.index', compact('logs'));
    }

    public function create(): View {
        return view('logs.create');
    }

    public function store(Request $request) {
        // Verificar si el usuario está autenticado
        if (!auth()->check()) {
            return redirect()->route('login')->withErrors(['auth' => 'Debes estar logueado para realizar esta acción.']);
        }
    
        // Fusionar el user_id con la solicitud
        $request->merge(['user_id' => auth()->id()]);
    
        // Validación de los datos
        $validated = $request->validate([
            'estado' => 'required',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'comentario' => 'required',
        ]);
    
        // Asegúrate de que el user_id esté en los datos validados
        $validated['user_id'] = auth()->id();
    
        // Verificar si hay una imagen y guardarla
        if ($request->hasFile('imagen')) {
            $imagePath = $request->file('imagen')->store('logs_images', 'public');
            $validated['imagen'] = $imagePath;
        }

    
        // Crear el registro en la base de datos
        Log::create($validated);
    
        // Redirigir con éxito
        return redirect()->route('logs.index')->with('success', 'Activo creado con éxito');
    }
    
    
    
    

    public function show(Log $log): View {
        return view('logs.show', compact('log'));
    }

    public function edit(Log $log): View {
        return view('logs.edit', compact('log'));
    }

    public function update(Request $request, Log $log): RedirectResponse {
        if ($request->hasFile('imagen')) {
            \Log::info('Imagen recibida:', [$request->file('imagen')]); // Log de la imagen recibida
        }
        $validated = $request->validate([
            'estado' => 'required',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'comentario' => 'required',
        ]);
        // Manejar la subida de la nueva imagen si es necesario
        if ($request->hasFile('imagen')) {
            // Borrar la imagen anterior si existe
            if ($log->imagen) {
                Storage::delete('public/' . $log->imagen);
            }

            // Guardar la nueva imagen
            $imagePath = $request->file('imagen')->store('logs_images', 'public');
            $validated['imagen'] = $imagePath;
        }
        $log->update($validated);
        return redirect()->route('logs.index')->with('success', 'Activo actualizado con éxito');

    }

    public function destroy(Log $log) {
        $log->delete();
        return redirect()->route('logs.index');
    }

    public function upload(Request $request): RedirectResponse
    {
        // Validar el archivo subido
        $request->validate([
            'file' => 'required|file|mimes:jpg,png,jpeg,gif|max:2048',
        ]);

        // Almacenar el archivo en la carpeta 'uploads'
        $fileName = time() . '.' . $request->file->extension();
        $request->file->move(public_path('uploads'), $fileName);

        // Guardar el nombre del archivo en la base de datos (considera si esto es lo necesario)
        Log::create(['filename' => $fileName]);

        return back()->with('success', 'Archivo subido correctamente.');
    }
}
