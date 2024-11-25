<x-event-layout>
    <x-slot name="title">Logs</x-slot>
     <div class="py-6">
    <!-- Tabla de logs -->
    <div class="overflow-x-auto">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mt-4">
                <a href="{{ route('logs.create') }}" class="inline-flex items-center px-4 py-2 mb-2 bg-[#1a237e] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                    Crear Nuevo Log
                </a>
            </div>
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
        <div class="mx-0">
            <table class="min-w-full bg-white border border-[#e0e0e0] shadow-sm">
            <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                <thead>
                    <tr class="text-white bg-[#1a237e] border-b border-[#e0e0e0]">
                        <th class="py-3 px-4 text-left text-sm font-medium">Usuario</th>
                        <th class="py-3 px-4 text-left text-sm font-medium">Ticket</th>
                        <th class="py-3 px-4 text-left text-sm font-medium">Estado</th>
                        <th class="py-3 px-4 text-left text-sm font-medium">Imagen</th>
                        <th class="py-3 px-4 text-left text-sm font-medium">Comentario</th>
                        <th class="py-3 px-4 text-left text-sm font-medium">Fecha de creación</th>
                        <th class="py-3 px-4 text-left text-sm font-medium">Acciones</th>
                    </tr>
                </thead>
                <tbody class="text-[#212121]">
                    @foreach ($logs as $key =>$log)
                        <tr class="border-b border-[#e0e0e0] hover:bg-[#f5f5f5] transition-colors duration-150">
                            <td class="py-3 px-4 text-sm">{{ $log->user_id }}</td>
                            <td class="py-3 px-4 text-sm">{{ $log->ticket_id }}</td>
                            <td class="py-3 px-4 text-sm">{{ $log->estado }}</td>
                            <td class="py-3 px-4">
                                @if($log->imagen)
                                    @if (Str::startsWith($log->imagen, 'data:image'))
                                        <img src="{{ $log->imagen }}" alt="Imagen Base64" class="w-32 h-32 object-cover rounded shadow-sm">
                                    @else
                                        <img src="{{ asset('storage/' . $log->imagen) }}" alt="Imagen subida" class="w-32 h-32 object-cover rounded shadow-sm">
                                    @endif
                                @else
                                    <span class="text-[#212121]">Sin imagen</span>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-sm">{{ $log->comentario }}</td>
                            <td class="py-3 px-4 text-sm">{{ $log->created_at }}</td>
                            <td class="py-3 px-4">
                                <div class="flex space-x-3">
                                    <!-- Ver -->
                                    <a href="{{ route('logs.show', $log) }}" 
                                       class="text-[#3949ab] hover:text-[#1a237e] transition-colors duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        </svg>
                                    </a>
                                   
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Paginación -->
    <div class="mt-6">
        {{ $logs->links() }}
    </div>
    </div>
    </div>
    </div>
</div>
</x-event-layout>
