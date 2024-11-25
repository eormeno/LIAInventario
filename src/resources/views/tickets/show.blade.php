<!-- resources/views/tickets/show.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detalles del Ticket') }} #{{ $ticket->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-4">
                        <label class="block text-gray-700">Asunto:</label>
                        <p class="text-gray-800">{{ $ticket->subject }}</p>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Descripción:</label>
                        <p class="text-gray-800">{{ $ticket->description }}</p>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Estado:</label>
                        <span class="bg-yellow-100 text-yellow-700 text-sm px-2 py-0.5 rounded-full">{{ $ticket->logs->last()->estado }}</span>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Fecha de creación:</label>
                        <p class="text-gray-800">{{ $ticket->created_at->format('Y-m-d') }}</p>
                    </div>

                    <div class="ticket-detail">

                    <!-- Mostrar el usuario creador -->
                    @if ($ticket->creator)
                        <div class="creator-info">
                            <img src="{{ $ticket->creator->profile_photo_url }}" alt="Foto de {{ $ticket->creator->name }}" width="100" height="100">
                            <p>Creado por: {{ $ticket->creator->name }}</p>
                        </div>
                    @else
                        <p>Creado por: Usuario desconocido</p>
                    @endif
                </div>

                 <!-- En tickets/show.blade.php -->
<div class="mt-4">
    <h3 class="text-lg font-medium">Historial de acciones</h3>
    <ul>
        @foreach($logs as $log)
            <li>
                <strong>{{ $log->comentario }}</strong> por {{ $log->user->name }} el {{ $log->created_at->format('Y-m-d H:i') }}
            </li>
        @endforeach
    </ul>
</div>


                    <!-- En tu vista tickets/show.blade.php -->
@if($ticket->status != 'Resuelto')
    <form action="{{ route('tickets.update', $ticket->id) }}" method="POST" class="inline">
        @csrf
        @method('PUT')
        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md">
            Resolver Ticket
        </button>
    </form>

    <div class="mt-4">
        <a href="{{ route('logs.create',['ticket_id' => $ticket->id]) }}" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-700">
            Agregar nuevo Log
        </a>
    </div>
@endif

                    <div class="mt-4">
                        <a href="{{ route('tickets.index') }}" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-700">
                            Volver a la lista de tickets
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
