<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Ticket;
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

    public function create(Request $request)
{
    // Obtener el ID del ticket desde la URL
    $ticket_id = $request->query('ticket_id'); // o $request->ticket_id si es un parámetro directo

    // Aquí puedes hacer lo que necesites, por ejemplo, cargar el ticket:
    $ticket = Ticket::findOrFail($ticket_id);

    // Pasar el ticket a la vista para que el usuario pueda agregar un log relacionado
    return view('logs.create', compact('ticket_id'));
}

    // En el controlador de Log (por ejemplo: LogController.php)
    public function store(Request $request) {
        // Verificar si el usuario está autenticado
        if (!auth()->check()) {
            $userId = \App\Models\User::factory()->create()->id;
        } else {
            $userId = auth()->id();
        }
    
        $ticketId = $request->input('ticket_id'); // Asegúrate de obtener el valor de ticket_id desde el request

        // Verifica que ticket_id no sea nulo
        if (!$ticketId) {
            return redirect()->back()->withErrors(['ticket_id' => 'Ticket ID es obligatorio']);
        }
    
        // Asegurarse de que el user_id esté presente en los datos validados
        $validated = $request->validate([
            'estado' => 'required',
            'comentario' => 'required',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'ticket_id' => 'required|exists:tickets,id', // Verifica que ticket_id exista en la tabla tickets
        ]);

        if ($request->hasFile('imagen')) {
            // Guardar la nueva imagen
            $imagePath = $request->file('imagen')->store('logs_images', 'public');
            $validated['imagen'] = $imagePath;
        }
    
        // Añadir el user_id y ticket_id al array de validación
        $validated['user_id'] = $userId;
        $validated['ticket_id'] = $ticketId;
    
        // Crear el registro
        Log::create($validated);
    
        return redirect()->route('tickets.show', ['ticket' => $ticketId])->with('success', 'Log creado con éxito');

    }
    

    
    
    public function show(Log $log): View {
        $ticket = $log->ticket;
        return view('logs.show', compact('log','ticket'));
    }

    public function edit(Log $log): View {
        return view('logs.edit', compact('log'));
    }

    public function update(Request $request, Log $log): RedirectResponse {

        $validated = $request->validate([
            'estado' => 'required',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'comentario' => 'required',
        ]);
        // Manejar la subida de la nueva imagen si es necesario
        if ($request->hasFile('imagen')) {
            dd('hola');
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
