<x-event-layout>
    <x-slot name="title">Editar log</x-slot>

    <div class="mx-auto w-1/2 mt-10 p-6 bg-white shadow-lg rounded-lg"> 
        <h2 class="text-2xl font-semibold mb-6">Editar Log</h2>

        <form action="{{ route('logs.update', $log) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Estado -->
            <div>
                <label for="estado" class="block text-sm font-medium text-gray-700">Estado:</label>
                <select name="estado" id="estado" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-indigo-200 focus:border-indigo-300">
                    <option value="cerrado" @if ($log->estado == 'cerrado') selected @endif>Cerrado</option>
                    <option value="en progreso" @if ($log->estado == 'en progreso') selected @endif>En progreso</option>
                </select>
            </div>

            <!-- Comentario -->
            <div>
                <label for="comentario" class="block text-sm font-medium text-gray-700">Comentario:</label>
                <textarea name="comentario" id="comentario"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-indigo-200 focus:border-indigo-300">{{ $log->comentario }}</textarea>
            </div>

            <!-- Imagen Actual -->
            <div>
                <label for="imagen" class="block text-sm font-medium text-gray-700">Imagen actual:</label>
                @if($log->imagen)
                    <div class="mt-2">
                        <img src="{{ asset('storage/' . $log->imagen) }}" alt="Vista previa" class="w-32 h-32 object-cover mb-2 rounded shadow-sm">
                    </div>
                @endif
            </div>

            <!-- Subir nueva imagen -->
            <div>
                <label for="imagen_nueva" class="block text-sm font-medium text-gray-700">Subir nueva imagen (opcional):</label>
                <input type="file" name="imagen" id="imagen_nueva" accept="image/*"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-indigo-200 focus:border-indigo-300">
            </div>

            <!-- Botón para enviar -->
            <div>
                <button type="submit" 
                    class="inline-block px-4 py-2 bg-[#1a237e] text-white rounded hover:bg-[#3949ab] transition-colors duration-200">
                    Guardar
                </button>
            </div>
        </form>
    </div>
</x-event-layout>