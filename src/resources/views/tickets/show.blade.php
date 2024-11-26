<!-- resources/views/tickets/show.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Detalles del Ticket') }} #{{ $ticket->id }}
            </h2>
            <span class=" text-white text-sm px-3 py-1 rounded-full">
                {{ $ticket->status }}
            </span>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-white shadow-xl sm:rounded-lg overflow-hidden">
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Información Principal del Ticket --}}
                    <div class="space-y-4">
                        <div>
                            <label class="block text-gray-900 dark:text-gray-900 font-medium mb-2">Asunto</label>
                            <p class="text-gray-800 dark:text-gray-600 ">{{ $ticket->subject }}</p>
                        </div>

                        <div>
                            <label class="block text-gray-900 dark:text-gray-900 font-medium mb-2">Fecha de Creación</label>
                            <p class="text-gray-800 dark:text-gray-600">
                                {{ $ticket->created_at->translatedFormat('d F Y, H:i') }}
                            </p>
                        </div>

                        {{-- Información del Creador --}}
                        <div class="flex items-center space-x-4">
                            @if ($ticket->creator)
                                <img 
                                    src="{{ $ticket->creator->profile_photo_url }}" 
                                    alt="Foto de {{ $ticket->creator->name }}" 
                                    class="w-16 h-16 rounded-full object-cover border-2 border-gray-300"
                                >
                                <div>
                                    <p class="font-medium text-gray-800 dark:text-gray-900">
                                        Creado por: {{ $ticket->creator->name }}
                                    </p>
                                    <p class="text-sm text-gray-800 dark:text-gray-900">
                                        {{ $ticket->creator->email }}
                                    </p>
                                </div>
                            @else
                                <p>Creado por: Usuario desconocido</p>
                            @endif
                        </div>
                    </div>

                    {{-- Historial de Logs --}}
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-900 mb-4">
                            Historial de Acciones
                        </h3>
                        
                        <div class="space-y-3 max-h-96 overflow-y-auto">
                            @forelse($logs as $log)
                                <div class="bg-gray-50 dark:bg-gray-200 p-3 rounded-lg shadow-sm relative">
                                    <div class="flex items-center space-x-3 mb-2">
                                        <img 
                                            src="{{ $log->user->profile_photo_url }}" 
                                            alt="Foto de {{ $log->user->name }}" 
                                            class="w-10 h-10 rounded-full object-cover"
                                        >
                                        <div>
                                            <p class="font-medium text-gray-800 dark:text-gray-800">
                                                {{ $log->user->name }}
                                            </p>
                                            <p class="text-xs text-gray-600 dark:text-gray-800">
                                                {{ $log->created_at->diffForHumans() }}
                                            </p>
                                        </div>
                                    </div>
                                    
                                    <p class="text-gray-700 dark:text-gray-800">
                                        {{ $log->comentario }}
                                    </p>
                                    
                                    <a href="{{ route('logs.show', $log->id) }}" 
                                       class="absolute bottom-2 right-2 text-blue-500 hover:text-blue-700 text-sm">
                                        Ver detalles
                                    </a>
                                </div>
                            @empty
                                <p class="text-gray-500 text-center">No hay logs disponibles</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                {{-- Acciones --}}
                <div class="bg-gray-100 dark:bg-white px-6 py-4 flex justify-between items-center">
                    @if($ticket->status != 'Resuelto')
                        <div class="space-x-3">
                            <form action="{{ route('tickets.update', $ticket->id) }}" method="POST" class="inline">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="bg-green-700 text-white px-4 py-2 rounded-md hover:bg-green-600 transition">
                                    Resolver Ticket
                                </button>
                            </form>

                            <a href="{{ route('logs.create',['ticket_id' => $ticket->id]) }}" 
                               class="inline-block px-4 py-2 bg-[#1a237e] text-white rounded hover:bg-[#3949ab] transition-colors duration-200">
                                Agregar nuevo Log
                            </a>
                        </div>
                    @endif

                    <a href="{{ route('tickets.index') }}" 
                       class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition">
                        Volver a la lista de tickets
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
