<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tickets') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Botón para crear un nuevo ticket -->
            <div class="mt-4">
                <a href="{{ route('tickets.create') }}" class="inline-flex items-center px-4 py-2 mb-2 bg-[#1a237e] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                    Crear Nuevo Ticket
                </a>
            </div>
            <div class="m-4 bg-white shadow-lg rounded-lg">
                <div class="divide-y divide-gray-200">
                    @foreach ($tickets as $ticket)
                        <div class="flex justify-between items-center p-4 hover:bg-gray-50">
                            <div class="flex items-center space-x-4">
                                <!-- Imagen y nombre del usuario creador -->
                                @if ($ticket->creator)
                                    <img src="{{ $ticket->creator->profile_photo_url }}" alt="Foto de {{ $ticket->creator->name }}" class="w-10 h-10 rounded-full">
                                    <div>
                                        <p class="text-sm font-medium text-gray-700">{{ $ticket->creator->name }}</p>
                                        <span class="text-xs text-gray-500">Creado el {{ $ticket->created_at->format('Y-m-d') }}</span>
                                    </div>
                                @else
                                    <div>
                                        <p class="text-sm font-medium text-gray-700">Usuario desconocido</p>
                                    </div>
                                @endif
                            </div>
                            <div class="flex items-center space-x-4">
                                <!-- ID del ticket, asunto y estado -->
                                <h3 class="text-sm font-medium text-gray-700">Ticket #{{ $ticket->id }}</h3>
                                <span class="text-sm text-gray-500">{{ $ticket->subject }}</span>
                              
                                @if($ticket->logs->isNotEmpty())
                                    <span class="bg-yellow-100 text-yellow-700 text-sm px-2 py-0.5 rounded-full">{{ $ticket->logs->first()->estado }}</span>
                                @else
                                    <p> No disponible</p>
                                @endif
                               <a href="{{ route('tickets.show', $ticket->id) }}" class="text-blue-500 hover:text-blue-700 text-sm font-medium">
                                    Ver
                                </a>

                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
             <div class="mt-6">
                            {{ $tickets->links() }}
            </div>
        </div>
    </div>
</x-app-layout>




