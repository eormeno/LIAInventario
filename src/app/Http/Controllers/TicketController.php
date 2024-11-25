<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Log;  // Asegúrate de que esté usando tu modelo Log y no Monolog


class TicketController extends Controller
{
     // Este método maneja la ruta para mostrar todos los tickets
     public function index()
{
    // Obtener los tickets con su relación 'creator' y aplicar la paginación
    $tickets = Ticket::with([
        'creator', 
        'logs' => function ($query) {
            $query->latest()->take(1); // Obtiene solo el último log
        }
    ])->latest()->paginate(5);
    // Retornar la vista y pasar los tickets paginados
    return view('tickets.index', compact('tickets'));
}

    public function create()
    {
        return view('tickets.create');
    }

    public function store(Request $request)
{
    // Validar los datos del formulario
    $request->validate([
        'subject' => 'required|string|max:255',
        'description' => 'required|string',
        'status' => 'required|string',
    ]);

    // Crear el ticket
    $ticket = Ticket::create([
        'subject' => $request->subject,
        'created_by' => Auth::id(), // Asignar el ID del usuario autenticado
    ]);

    $log = Log::create([
        'ticket_id'=> $ticket->id,
        'comentario' => $request->description,
        'estado' => $request->status,
        'user_id' => Auth::id(), // Asignar el ID del usuario autenticado
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

    public function destroy(Ticket $ticket)
    {
        $ticket->delete();

        return redirect()->route('tickets.index')->with('success', 'Ticket eliminado');
    }
}

