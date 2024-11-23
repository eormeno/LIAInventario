<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Models\Log;  // Asegúrate de que esté usando tu modelo Log y no Monolog


class TicketController extends Controller
{
     // Este método maneja la ruta para mostrar todos los tickets
     public function index()
     {
         // Obtener todos los tickets desde la base de datos
        //  $tickets = Ticket::all();
         $tickets = Ticket::with('creator')->get();
 
         // Retornar la vista y pasar los tickets
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
        'subject' => 'required|string|max:255',   // Asegúrate de que 'subject' coincida
        'description' => 'required|string',
        'status' => 'required|string',
    ]);

    // Crear un nuevo ticket con los datos del formulario
    Ticket::create([
        'subject' => $request->subject,
        'description' => $request->description,
        'status' => $request->status,
    ]);

    // Redirigir a otra página o mostrar un mensaje de éxito
    return redirect()->route('tickets.index')->with('success', 'Ticket creado correctamente');
}


public function show(Ticket $ticket)
{
    // Cargar los logs relacionados con el ticket, asegurándote de incluir la relación 'user' (quién hizo la acción)
    $logs = Log::where('ticket_id', $ticket->id)->with('user')->get();

    // Pasar los logs a la vista
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

