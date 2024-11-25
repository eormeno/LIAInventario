<x-crud-layout>
	<x-slot name="title">Nuevo Log</x-slot>
    <form action="{{ route('logs.store') }}" method="POST" enctype="multipart/form-data">

        @csrf
        <input type="hidden" name="ticket_id" value="{{ $ticket_id }}">
        <label for="estado">Estado</label>
        <select name="estado" required>
            <option value="En progreso">En progreso</option>
        </select>
                    <!-- Imagen -->
        <div>
            <label for="imagen" class="block text-sm font-medium text-gray-700">Imagen:</label>
            <input type="file" name="imagen" id="imagen" accept="image/*" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-indigo-200 focus:border-indigo-300">
        </div>
        <label for="comentario">Comentario</label>
        <textarea name="comentario"></textarea>
        <button type="submit">Guardar</button>
    </form>
</x-crud-layout>