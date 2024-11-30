<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tickets') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Botón para crear un nuevo ticket -->
            <div class="mt-4 mb-4">
                <a href="{{ route('tickets.create') }}" class="inline-flex items-center px-4 py-2 bg-[#1a237e] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                    Crear Nuevo Ticket
                </a>
            </div>
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <table class="w-full">
                    <thead class="bg-[#1a237e]">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-white uppercase tracking-wider">Creador</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-white uppercase tracking-wider">N° Ticket</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-white uppercase tracking-wider">Asunto</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-white uppercase tracking-wider">Estado</th>
                            <th class="px-4 py-2 text-right text-xs font-medium text-white uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($tickets as $ticket)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        @if ($ticket->creator)
                                            <img src="{{ $ticket->creator->profile_photo_url }}" alt="Foto de {{ $ticket->creator->name }}" class="w-10 h-10 rounded-full mr-4">
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">{{ $ticket->creator->name }}</div>
                                                <div class="text-sm text-gray-600">{{ $ticket->created_at->format('Y-m-d') }}</div>
                                            </div>
                                        @else
                                            <div class="text-sm font-medium text-gray-900">Usuario desconocido</div>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                                    #{{ $ticket->id }}
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $ticket->subject }}
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    @if($ticket->logs->isNotEmpty())
                                        <span 
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                {{ $ticket->logs->first()->estado == 'Creado' ? 'bg-yellow-100 text-yellow-800' : '' }} 
                                                {{ $ticket->logs->first()->estado == 'En Progreso' ? 'bg-green-100 text-green-800' : '' }} 
                                                {{ $ticket->logs->first()->estado == 'Cerrado' ? 'bg-red-100 text-red-800' : '' }} 
                                                {{ !in_array($ticket->logs->first()->estado, ['Creado', 'En Progreso', 'Cerrado']) ? 'bg-gray-100 text-gray-800' : '' }}">
                                                {{ $ticket->logs->first()->estado }}
                                            </span>
                                    @else
                                        <span class="text-sm text-gray-500">No disponible</span>
                                    @endif
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('tickets.show', $ticket->id) }}" class="text-blue-600 hover:text-blue-900">
                                        Ver
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-6">
                @if($tickets instanceof \Illuminate\Contracts\Pagination\Paginator)
    {{ $tickets->links() }}
@else
    <p>No hay tickets disponibles.</p>
@endif

            </div>
        </div>
    </div>
</x-app-layout>




