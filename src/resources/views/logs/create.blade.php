<x-crud-layout>
    <x-slot name="title">Nuevo Log</x-slot>
    
    <div class="max-w-md mx-auto bg-white p-8 rounded-xl shadow-lg">
        <form action="{{ route('logs.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            <input type="hidden" name="ticket_id" value="{{ $ticket_id }}">
            
            <div>
                <label for="estado" class="block text-sm font-medium text-gray-700 mb-2">Estado</label>
                <select 
                    name="estado" 
                    id="estado" 
                    required 
                    class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm 
                           focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                >
                    <option value="En progreso">En progreso</option>
                    <option value="Pendiente">Pendiente</option>
                    <option value="Resuelto">Resuelto</option>
                </select>
            </div>

            <div>
                <label for="imagen" class="block text-sm font-medium text-gray-700 mb-2">
                    Imagen (Opcional)
                </label>
                <label for="imagen" class="block text-sm font-medium text-gray-700">Imagen:</label>
                <input type="file" name="imagen" id="imagen" accept="image/*"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-indigo-200 focus:border-indigo-300">

            </div>
                       

            <div>
                <label for="comentario" class="block text-sm font-medium text-gray-700 mb-2">
                    Comentario
                </label>
                <textarea 
                    name="comentario" 
                    id="comentario" 
                    rows="4"
                    class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm 
                           focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                    placeholder="Ingrese sus observaciones..."
                ></textarea>
            </div>

            <div>
                <button 
                    type="submit" 
                    class="inline-flex items-center px-4 py-2 bg-[#1a237e] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150"
                >
                    Guardar Log
                </button>
            </div>
        </form>
    </div>
</x-crud-layout>