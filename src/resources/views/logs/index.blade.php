<x-event-layout>
    <x-slot name="title">Logs</x-slot>
    <!-- Tabla de logs -->
    <div class="overflow-x-auto">
        <div class="mx-10">
            <table class="min-w-full bg-white border border-[#e0e0e0] shadow-sm">
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
                        <tr class="{{ $key % 2 === 0 ? 'bg-gray-100' : 'bg-white' }} hover:bg-[#f5f5f5] transition-colors duration-150 border-b border-[#e0e0e0]">
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
                                    <!-- Editar -->
                                    <a href="{{ route('logs.edit', $log) }}" 
                                       class="text-[#3949ab] hover:text-[#1a237e] transition-colors duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                        </svg>
                                    </a>
                                    <!-- Eliminar -->
                                    <form action="{{ route('logs.destroy', $log) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="text-[#f44336] hover:text-[#d32f2f] transition-colors duration-200">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                            </svg>
                                        </button>
                                    </form>
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
</x-event-layout>
