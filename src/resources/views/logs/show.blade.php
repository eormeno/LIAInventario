<x-crud-layout>
    <x-slot name="title">Detalle del log</x-slot>
    <!-- Contenedor principal para centrar el contenido -->
    <div class="ml-10 mr-10 mt-6 bg-white border border-gray-300 p-6 rounded-lg shadow">
        <!-- Título -->
        <h2 class="text-2xl font-semibold mb-4">Detalles del Log</h2>

        <!-- Información del log -->
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <p><span class="font-semibold">Usuario:</span> {{ $log->user_id }}</p>
            <p><span class="font-semibold">Estado:</span> {{ $log->estado }}</p>
            <p><span class="font-semibold">Comentario:</span> {{ $log->comentario }}</p>
            <p><span class="font-semibold">Fecha:</span> {{ $log->created_at }}</p>

            <!-- Mostrar el código del Activo Relacionado -->
            <div class="col-span-1 sm:col-span-2 bg-gray-50 dark:bg-gray-200 p-4 rounded-lg shadow-sm border">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-900 mb-3">
                    Información del Activo Relacionado
                </h3>
                @if ($log->ticket && $log->ticket->asset)
                    <p class="mb-2">
                        <span class="font-semibold text-gray-800 dark:text-gray-700">Código del Activo Relacionado:</span>
                        <span class="text-gray-700 dark:text-gray-800">{{ $log->ticket->asset->codigo_inventario ?? 'N/A' }}</span>
                    </p>
                    <p>
                        <span class="font-semibold text-gray-800 dark:text-gray-700">Código de Patrimonio Relacionado:</span>
                        <span class="text-gray-700 dark:text-gray-800">{{ $log->ticket->asset->codigo_patrimonio ?? 'N/A' }}</span>
                    </p>
                @else
                    <p class="text-red-500">No hay un activo asociado a este log</p>
                @endif
            </div>

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

        <!-- Botones para navegación -->
        <div class="mt-6 flex justify-end space-x-4">
            <a href="{{ route('logs.index') }}" 
               class="inline-block px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 transition">
                Volver a Logs
            </a>
            <a href="{{ route('tickets.show', $ticket->id) }}" 
               class="inline-block px-4 py-2 bg-[#1a237e] text-white rounded hover:bg-indigo-700 transition">
                Ir a Ticket
            </a>
        </div>
    </div>
</x-crud-layout>
