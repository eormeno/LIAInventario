<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Log;
use App\Models\Asset;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreTicketRequest;
use App\Traits\ToastTrigger;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    use ToastTrigger;

    public function index()
    {
        $user = auth()->user();

        // Consulta base con relaciones y último log
        $ticketsQuery = Ticket::with([
            'creator',
            'logs' => function ($query) {
                $query->latest()->take(1); // Solo el último log
            }
        ]);

        // Filtrar según rol y área
        if ($user->hasRole('root') || $user->coordinador) {
            $tickets = $ticketsQuery->latest()->paginate(5);
        } elseif (strtolower($user->area) === 'hardware') {
            $tickets = $ticketsQuery->whereRaw('LOWER(area) = ?', ['hardware'])->latest()->paginate(5);
        } elseif (strtolower($user->area) === 'software') {
            $tickets = $ticketsQuery->whereRaw('LOWER(area) = ?', ['software'])->latest()->paginate(5);
        } elseif (strtolower($user->area) === 'ti') {
            $tickets = $ticketsQuery->whereRaw('LOWER(area) = ?', ['ti'])->latest()->paginate(5);
        } else {
            $tickets = collect(); // Retorna una colección vacía
        }

        return view('tickets.index', compact('tickets'));
    }

    public function create()
    {
        return view('tickets.create');
    }

    public function store(StoreTicketRequest $request)
    {
        // Obtener el Asset usando `codigo_inventario` o `codigo_patrimonio`
        $asset = Asset::where('codigo_inventario', $request->asset_code)
                      ->orWhere('codigo_patrimonio', $request->asset_code)
                      ->first();

        // Crear el ticket con los datos validados
        $ticket = Ticket::create([
            'subject' => $request->subject,
            'created_by' => Auth::id(),
            'asset_id' => $asset->id, // Asignar el ID del activo encontrado
        ]);

        // Manejar la imagen (si está presente)
        $imagePath = null;
        if ($request->hasFile('imagen')) {
            $imagePath = $request->file('imagen')->store('logs_images', 'public');
        }

        // Crear un log relacionado
        Log::create([
            'ticket_id' => $ticket->id,
            'comentario' => $request->description,
            'estado' => $request->status,
            'user_id' => Auth::id(),
            'imagen' => $imagePath,
        ]);

        $this->infoToast('Ticket creado exitosamente');
        return redirect()->route('tickets.index');
    }

    public function show($ticketId)
    {
        $ticket = Ticket::findOrFail($ticketId);
        $logs = $ticket->logs; // Asume la relación 'logs' en el modelo Ticket
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

        $this->infoToast('Ticket actualizado correctamente');
        return redirect()->route('tickets.index');
    }

    public function resolveTicket($ticketId)
    {
        $ticket = Ticket::findOrFail($ticketId);

        $this->createLog($ticket, 'Ticket resuelto');
        return redirect()->route('tickets.index')->with('success', 'Ticket resuelto correctamente');
    }

    private function createLog($ticket, $comentario)
    {
        $estado = $comentario === 'Ticket resuelto' ? 'Resuelto' : 'En progreso';

        Log::create([
            'ticket_id' => $ticket->id,
            'comentario' => $comentario,
            'estado' => $estado,
            'user_id' => Auth::id(),
            'imagen' => null,
        ]);
    }

    public function assignToArea(Request $request, Ticket $ticket)
    {
        $validated = $request->validate([
            'area' => 'required|in:hardware,software,ti',
        ]);

        if ($ticket->area === $validated['area']) {
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
        $this->infoToast('Ticket eliminado exitosamente');
        return redirect()->route('tickets.index');
    }

    public function reopen(Ticket $ticket)
    {
        $this->createLog($ticket, 'Ticket reabierto');
        return redirect()->route('tickets.show', $ticket->id)->with('success', 'Ticket reabierto');
    }
}

