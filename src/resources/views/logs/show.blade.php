<x-crud-layout>
    <x-slot name="title">Detalle del log</x-slot>
    <!-- Contenedor principal para centrar el contenido -->
    <div class="ml-10 mr-10 mt-6 bg-white border border-gray-300 p-6 rounded-lg shadow">
        <!-- Título -->
        <h2 class="text-2xl font-semibold mb-4">Detalles del Log</h2>
        <!-- Información del log -->
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <p><span class="font-semibold">Usuario:</span> {{ $log->user_id }}</p>
            <!-- <p><span class="font-semibold">Ticket:</span> {{ $log->ticket_id }}</p> -->
            <p><span class="font-semibold">Estado:</span> {{ $log->estado }}</p>
            <p><span class="font-semibold">Comentario:</span> {{ $log->comentario }}</p>
            <p><span class="font-semibold">Fecha:</span> {{ $log->created_at }}</p>

            
            <!-- Mostrar imagen -->
            <div class="col-span-1 sm:col-span-2">
                <p class="font-semibold mb-2">Imagen:</p>
                @if($log->imagen)
                                    @if (Str::startsWith($log->imagen, 'data:image'))
                                        <img src="{{ $log->imagen }}" alt="Imagen Base64" class="w-32 h-32 object-cover rounded shadow-sm">
                                    @else
                                        <img src="{{ asset('storage/' . $log->imagen) }}" alt="Imagen subida" class="w-32 h-32 object-cover rounded shadow-sm">
                                    @endif
                                @else
                                    <span class="text-[#212121]">Sin imagen</span>
                                @endif
            </div>
        </div>
        <!-- Botón para volver al listado de logs -->
        <div class="mt-6">
            <a href="{{ route('tickets.show', $ticket->id) }}" class="inline-block px-4 py-2 bg-[#1a237e] text-white rounded hover:bg-indigo-700 transition">Volver</a>
        </div>
    </div>
</x-crud-layout>