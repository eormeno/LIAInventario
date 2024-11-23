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
                <form method="POST" action="{{ route('tickets.store') }}">
                    @csrf
                    <div class="p-6">
                        <div class="mb-4">
                            <label for="subject" class="block text-gray-700">Asunto</label>
                            <input type="text" id="subject" name="subject" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-gray-700">Descripción</label>
                            <textarea id="description" name="description" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required></textarea>
                        </div>

                        <div class="mb-4">
                            <label for="status" class="block text-gray-700">Estado</label>
                            <select id="status" name="status" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="Pendiente">Pendiente</option>
                                <option value="En Proceso">En Proceso</option>
                                <option value="Resuelto">Resuelto</option>
                            </select>
                        </div>

                        <div class="mt-4">
                            <x-button class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 float-end">
                                {{ __('Crear ticket') }}
                            </x-button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
