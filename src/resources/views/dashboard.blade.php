{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden sm:rounded-lg">
                @role('registered')
                    <div class="m-4 text-xl text-gray-600 dark:text-gray-200">
                        <b>Usted está registrado en el sistema.</b><br> Para poder acceder a funcionalidades
                         específicas, debe dirigirse personalmente al área de administración de la
                         organización.
                    </div>
                @endrole
                @role('root')
                    <div class="m-4 text-xl text-gray-600 dark:text-gray-200">
                        <b>Usted es usuario raíz.</b><br> Puede acceder a todas las funcionalidades del sistema.
                    </div>
                @else
                    @can('roles-list')
                        <p>Roles List</p>
                    @endcan
                    @can('roles-create')
                        <p>Roles Create</p>
                    @endcan
                    @can('roles-edit')
                        <p>Roles Edit</p>
                    @endcan
                    @can('roles-delete')
                        <p>Roles Delete</p>
                    @endcan
                    @can('users-list')
                        <p>Users List</p>
                    @endcan
                    @can('users-create')
                        <p>Users Create</p>
                    @endcan
                    @can('users-edit')
                        <p>Users Edit</p>
                    @endcan
                    @can('users-delete')
                        <p>Users Delete</p>
                    @endcan
                    @can('root user')
                        <p>Root User</p>
                    @endcan
                @endrole
            </div>
        </div>
    </div>
</x-app-layout> --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Inicio') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @role('registered')
                <div class="bg-gray-200 text-gray-500 shadow-md rounded-lg p-6">
                    <div class="text-xl">
                        <span class="font-bold">Usted está registrado en el sistema.</span><br>
                        Para poder acceder a funcionalidades específicas, debe dirigirse personalmente al área de administración de la organización.
                    </div>
                </div>
            
                
            @endrole

            @role('root')
                <div class="bg-gray-200 text-gray-500 shadow-md rounded-lg p-6">
                    <div class="text-xl">
                        <span class="font-bold">Usted es usuario raíz.</span><br>
                        Puede acceder a todas las funcionalidades del sistema.
                    </div>
                </div>
            @endrole

            @role('root')
                <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                    <div class="px-6 py-4 bg-[#3949ab] border-b flex justify-between items-center">
                        <h2 class="text-lg font-semibold text-white">Tickets Recientes</h2>
                        <a href="{{ route('tickets.index') }}" class="text-blue-100 hover:text-blue-200 text-sm">
                            Ver todos los tickets
                        </a>
                    </div>
                    
                    @if($tickets->count() > 0)
                        <table class="w-full">
                            <thead>
                                <tr class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wider">
                                    <th class="px-4 py-3 text-left">N° Ticket</th>
                                    <th class="px-4 py-3 text-left">Asunto</th>
                                    <th class="px-4 py-3 text-left">Estado</th>
                                    <th class="px-4 py-3 text-left">Fecha</th>
                                    <th class="px-4 py-3 text-right">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach ($tickets->take(5) as $ticket)
                                    <tr class="hover:bg-gray-50 transition duration-150">
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                                            #{{ $ticket->id }}
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $ticket->subject }}
                                        </td>
                                        <td class="px-4 py-4">
                                            <span 
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                {{ $ticket->logs->first()->estado == 'Creado' ? 'bg-yellow-100 text-yellow-800' : '' }} 
                                                {{ $ticket->logs->first()->estado == 'En Progreso' ? 'bg-green-100 text-green-800' : '' }} 
                                                {{ $ticket->logs->first()->estado == 'Cerrado' ? 'bg-red-100 text-red-800' : '' }} 
                                                {{ !in_array($ticket->logs->first()->estado, ['Creado', 'En Progreso', 'Cerrado']) ? 'bg-gray-100 text-gray-800' : '' }}">
                                                {{ $ticket->logs->first()->estado }}
                                            </span>
                                        </td>


                                        <td class="px-4 py-4 text-sm text-gray-500">
                                            {{ $ticket->created_at->format('Y-m-d') }}
                                        </td>
                                        <td class="px-4 py-4 text-right">
                                            <a href="{{ route('tickets.show', $ticket->id) }}" 
                                               class="text-blue-600 hover:text-blue-900 text-sm">
                                                Ver
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="text-center py-6 text-gray-500">
                            No hay tickets recientes
                        </div>
                    @endif
                </div>
            @endrole

            @role('registered')
                <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                    <div class="px-6 py-4 bg-[#3949ab] border-b flex justify-between items-center">
                        <h2 class="text-lg font-semibold text-white">Tickets Recientes</h2>
                        <a href="{{ route('tickets.index') }}" class="text-blue-100 hover:text-blue-200 text-sm">
                            Ver todos los tickets
                        </a>
                    </div>
                    
                    @if($tickets->count() > 0)
                        <table class="w-full">
                            <thead>
                                <tr class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wider">
                                    <th class="px-4 py-3 text-left">N° Ticket</th>
                                    <th class="px-4 py-3 text-left">Asunto</th>
                                    <th class="px-4 py-3 text-left">Estado</th>
                                    <th class="px-4 py-3 text-left">Fecha</th>
                                    <th class="px-4 py-3 text-right">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach ($tickets->take(5) as $ticket)
                                    <tr class="hover:bg-gray-50 transition duration-150">
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                                            #{{ $ticket->id }}
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $ticket->subject }}
                                        </td>
                                        <td class="px-4 py-4">
                                            <span 
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                {{ $ticket->logs->first()->estado == 'Creado' ? 'bg-yellow-100 text-yellow-800' : '' }} 
                                                {{ $ticket->logs->first()->estado == 'En Progreso' ? 'bg-green-100 text-green-800' : '' }} 
                                                {{ $ticket->logs->first()->estado == 'Cerrado' ? 'bg-red-100 text-red-800' : '' }} 
                                                {{ !in_array($ticket->logs->first()->estado, ['Creado', 'En Progreso', 'Cerrado']) ? 'bg-gray-100 text-gray-800' : '' }}">
                                                {{ $ticket->logs->first()->estado }}
                                            </span>
                                        </td>


                                        <td class="px-4 py-4 text-sm text-gray-500">
                                            {{ $ticket->created_at->format('Y-m-d') }}
                                        </td>
                                        <td class="px-4 py-4 text-right">
                                            <a href="{{ route('tickets.show', $ticket->id) }}" 
                                               class="text-blue-600 hover:text-blue-900 text-sm">
                                                Ver
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="text-center py-6 text-gray-500">
                            No hay tickets recientes
                        </div>
                    @endif
                </div>
            @endrole
        </div>
    </div>
</x-app-layout>


