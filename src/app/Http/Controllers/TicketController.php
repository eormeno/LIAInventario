<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTicketRequest;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Log;  // Asegúrate de que esté usando tu modelo Log y no Monolog


class TicketController extends Controller
{
     // Este método maneja la ruta para mostrar todos los tickets
//      public function index()
// {
//     // Obtener los tickets con su relación 'creator' y aplicar la paginación
//     $tickets = Ticket::with([
//         'creator', 
//         'logs' => function ($query) {
//             $query->latest()->take(1); // Obtiene solo el último log
//         }
//     ])->latest()->paginate(5);
//     // Retornar la vista y pasar los tickets paginados
//     return view('tickets.index', compact('tickets'));
// }

public function index()
{
    $user = auth()->user();
    $tickets = collect(); // Colección por defecto para usuarios sin acceso

    if ($user && $user->roles) {
        $ticketsQuery = Ticket::with([
            'creator',
            'logs' => function ($query) {
                $query->latest()->take(1);
            }
        ]);

        if ($user->hasRole('root') || $user->hasRole('coordinador')) {
            $tickets = $ticketsQuery->latest()->paginate(5);
        } elseif ($user->hasRole('hardware')) {
            $tickets = $ticketsQuery->where('area', 'hardware')->latest()->paginate(5);
        } elseif ($user->hasRole('software')) {
            $tickets = $ticketsQuery->where('area', 'software')->latest()->paginate(5);
        }
    }

    return view('tickets.index', compact('tickets'));
}



    public function create()
    {
        return view('tickets.create');
    }

    public function store(StoreTicketRequest $request)
{
    // Validar los datos del formulario
    $request->validate([
        'subject' => 'required|string|max:255',
        'description' => 'required|string',
        'status' => 'required|string',
        'imagen' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'asset_code' => 'required|string',

    ]);

    // Crear el ticket
    $ticket = Ticket::create([
        'subject' => $request->subject,
        'created_by' => Auth::id(), // Asignar el ID del usuario autenticado
        'asset_id' => $request->asset_code,
    ]);
    
    $imagePath = null;

    if ($request->hasFile('imagen')) {
        // Guardar la nueva imagen
        $imagePath = $request->file('imagen')->store('logs_images', 'public');
    }
    $log = Log::create([
        'ticket_id'=> $ticket->id,
        'comentario' => $request->description,
        'estado' => $request->status,
        'user_id' => Auth::id(), // Asignar el ID del usuario autenticado
        'imagen' => $imagePath,
    ]);


    return redirect()->route('tickets.index')->with('success', 'Ticket creado exitosamente.');
}



public function show($ticketId)
{
    // Obtén el ticket por ID
    $ticket = Ticket::findOrFail($ticketId);
    
    // Obtén el historial de acciones o logs asociados al ticket
    $logs = $ticket->logs;  // Esto asume que tienes una relación 'logs' en tu modelo de Ticket
    
    // Pasa el ticket y los logs a la vista
    return view('tickets.show', compact('ticket', 'logs'));
}





    public function edit(Ticket $ticket)
    {
        return view('tickets.edit', compact('ticket'));
    }

    public function update(Request $request, Ticket $ticket)
    {
        $ticket->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return redirect()->route('tickets.index')->with('success', 'Ticket actualizado');
    }

    public function resolveTicket($ticketId)
    {
        $ticket = Ticket::findOrFail($ticketId);


        // Crea un log para esta acción
        $this->createLog($ticket, 'Ticket resuelto');

        return redirect()->route('tickets.index', $ticketId)->with('success', 'Ticket resuelto correctamente');
    }

    private function createLog($ticket, $comentario)
    {
        if ($comentario == 'Ticket resuelto'){
            $estado = 'Resuelto';
        }else{
            $estado = 'En progreso';
        }

        Log::create([
            'ticket_id' => $ticket->id,
            'comentario' => $comentario,
            'estado' => $estado, // O el estado que corresponda al log
            'user_id' => Auth::id(), // El ID del usuario autenticado
            'imagen' => null, // O la imagen si es necesario
        ]);
    }


    public function assignToArea(Request $request, Ticket $ticket) {
        $validated = $request->validate([
            'area' => 'required|in:hardware,software',
        ]);
        //si el ticket se intenta asignar al area a la que ya pertenece, se redirige con mensaje de erorr
        if ($ticket->area == $validated['area']) {
            return redirect()->route('tickets.show', $ticket->id)->with('error', 'El ticket ya se encuentra en el área: ' . $validated['area']);
        }
        $ticket->area = $validated['area'];
        $ticket->save();

        $this->createLog($ticket, 'Ticket derivado al área: ' . $validated['area']);

        return redirect()->route('tickets.show', $ticket->id)->with('success', 'El ticket ha sido asignado al área: ' . $validated['area']);
    }

    public function destroy(Ticket $ticket)
    {
        $ticket->delete();

        return redirect()->route('tickets.index')->with('success', 'Ticket eliminado');
    }

    public function reopen(Ticket $ticket){
        $this->createLog($ticket, 'Ticket reabierto');
        return redirect()->route('tickets.show', $ticket->id)->with('success', 'Ticket reabierto');
    }
}

