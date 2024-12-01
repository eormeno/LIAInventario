<!-- resources/views/tickets/create.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Crear Ticket') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden sm:rounded-lg">
            @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

                <form method="POST" action="{{ route('tickets.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="p-6">
                        <div class="mb-4">
                        <label class="block text-gray-700 mb-2">Código de Activo</label>
                        <input type="text" id="assetCode" name="asset_code" placeholder="Ingresar código" class="flex-grow px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div class="mb-4">
                            <label for="subject" class="block text-gray-700">Asunto</label>
                            <input type="text" id="subject" name="subject" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-gray-700">Comentario</label>
                            <textarea id="description" name="description" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required></textarea>
                        </div>

                         <div>
                <label for="imagen" class="block text-sm font-medium text-gray-700 mb-2">
                    Imagen (Opcional)
                </label>
                <label for="imagen" class="block text-sm font-medium text-gray-700">Imagen:</label>
                <input type="file" name="imagen" id="imagen" accept="image/*"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-indigo-200 focus:border-indigo-300">

            </div>

                        <div class="mb-4">
                            <label for="status" class="block text-gray-700">Estado</label>
                            <select id="status" name="status" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="Pendiente">Pendiente</option>
                            </select>
                        </div>

                        <div class="mt-4">
                            <x-button class="inline-flex items-center px-4 py-2 mb-2  bg-[#1a237e] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                                {{ __('Crear ticket') }}
                            </x-button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>



