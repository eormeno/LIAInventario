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
            @php
                $user = auth()->user();
                $canViewTickets = $user->hasRole('root')|| $user->coordinador || in_array(strtolower($user->area), ['hardware', 'software']);
               
            @endphp

            {{-- Mensaje según rol --}}
            @if(auth()->user()->hasRole('registered')||('users-admin') && !$canViewTickets)
                <div class="bg-gray-200 text-gray-500 shadow-md rounded-lg p-6">
                    <div class="text-xl">
                        <span class="font-bold">Usted está registrado en el sistema.</span><br>
                        Para poder acceder a funcionalidades específicas, debe dirigirse personalmente al área de administración de la organización.
                    </div>
                </div>
            @else

            <div class="bg-gray-200 text-gray-500 shadow-md rounded-lg p-6">
            @role('root')
                    <div class="m-4 text-xl text-gray-600 dark:text-gray-900">
                        <b>Usted es usuario raíz.</b><br> Puede acceder a todas las funcionalidades del sistema.
                    </div>
            @endrole
            </div>
            
            
            @if(auth()->user()->hasRole('registered,root') && $canViewTickets)
                {{-- Tickets recientes --}}
                <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                    <div class="px-6 py-4 bg-[#3949ab] border-b flex justify-between items-center">
                        <h2 class="text-lg font-semibold text-white">Tickets Recientes</h2>
                        <a href="{{ route('tickets.index') }}" class="text-blue-100 hover:text-blue-200 text-sm">
                            Ver todos los tickets
                        </a>
                    </div>

                    @php
                        $ticketsQuery = \App\Models\Ticket::with(['creator', 'logs' => function ($query) {
                            $query->latest()->take(1);
                        }]);

                        if ($user->hasRole('root') || $user->hasRole('coordinador')) {
                            $tickets = $ticketsQuery->latest()->take(5)->get();
                        } elseif (strtolower($user->area) === 'hardware') {
                            $tickets = $ticketsQuery->whereRaw('LOWER(area) = ?', ['hardware'])->latest()->take(5)->get();
                        } elseif (strtolower($user->area) === 'software') {
                            $tickets = $ticketsQuery->whereRaw('LOWER(area) = ?', ['software'])->latest()->take(5)->get();
                        } else {
                            $tickets = collect(); // Colección vacía
                        }
                    @endphp

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
                                @foreach ($tickets as $ticket)
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
                                                {{ !in_array($ticket->logs->first()->estado, ['Creado', 'En Progreso', 'Cerrado']) ? 'bg-gray-100 text-gray-800' : '' }} ">
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
            @endif
        </div>
    </div>
    @endif
    

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @php
                $user = auth()->user();
                $canViewAdminContent = $user->hasRole('root') || $user->hasRole('users-admin');
            @endphp

            @if(!$canViewAdminContent)
                {{-- <div class="bg-gray-200 text-gray-500 shadow-md rounded-lg p-6">
                    <div class="text-xl">
                        <span class="font-bold">Acceso denegado.</span><br>
                        No tiene permisos para acceder a esta sección administrativa.
                    </div>
                </div> --}}
            @else
                
                <div class="bg-white shadow-lg rounded-lg overflow-hidden mb-6">
                    <div class="px-6 py-4 bg-[#3949ab] border-b flex justify-between items-center">
                        <h2 class="text-lg font-semibold text-white">Usuarios Recientes</h2>
                        <a href="{{ route('users.index') }}" class="text-blue-100 hover:text-blue-200 text-sm">
                            Ver todos los usuarios
                        </a>
                    </div>

                    @php
                        $recentUsers = \App\Models\User::latest()->take(5)->get();
                    @endphp

                    @if($recentUsers->count() > 0)
                        <table class="w-full">
                            <thead>
                                <tr class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wider">
                                    <th class="px-4 py-3 text-left">Nombre</th>
                                    <th class="px-4 py-3 text-left">Email</th>
                                    <th class="px-4 py-3 text-left">Rol</th>
                                    <th class="px-4 py-3 text-left">Fecha Registro</th>
                                    <th class="px-4 py-3 text-right">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach ($recentUsers as $user)
                                    <tr class="hover:bg-gray-50 transition duration-150">
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $user->name }}
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $user->email }}
                                        </td>
                                        <td class="px-4 py-4">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                {{ $user->roles->pluck('name')->first() ?? 'Sin rol' }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-4 text-sm text-gray-500">
                                            {{ $user->created_at->format('Y-m-d') }}
                                        </td>
                                        <td class="px-4 py-4 text-right">
                                            <a href="{{ route('users.show', $user->id) }}" 
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
                            No hay usuarios recientes
                        </div>
                    @endif
                </div>

                
                <div class="bg-white shadow-lg rounded-lg overflow-hidden mb-6">
                    <div class="px-6 py-4 bg-[#3949ab] border-b flex justify-between items-center">
                        <h2 class="text-lg font-semibold text-white">Lugares Recientes</h2>
                        <a href="{{ route('places.index') }}" class="text-blue-100 hover:text-blue-200 text-sm">
                            Ver todos los lugares
                        </a>
                    </div>

                    @php
                        $recentPlaces = \App\Models\Place::latest()->take(5)->get();
                    @endphp

                    @if($recentPlaces->count() > 0)
                        <table class="w-full">
                            <thead>
                                <tr class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wider">
                                    <th class="px-4 py-3 text-left">Nombre</th>
                                    <th class="px-4 py-3 text-left">Descripción</th>
                                    <th class="px-4 py-3 text-left">Fecha Creación</th>
                                    <th class="px-4 py-3 text-right">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach ($recentPlaces as $place)
                                    <tr class="hover:bg-gray-50 transition duration-150">
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $place->name }}
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $place->description }}
                                        </td>
                                        <td class="px-4 py-4 text-sm text-gray-500">
                                            {{ $place->created_at->format('Y-m-d') }}
                                        </td>
                                        <td class="px-4 py-4 text-right">
                                            <a href="{{ route('places.show', $place->id) }}" 
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
                            No hay lugares recientes
                        </div>
                    @endif
                </div>

               
                <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                    <div class="px-6 py-4 bg-[#3949ab] border-b flex justify-between items-center">
                        <h2 class="text-lg font-semibold text-white">Activos Recientes</h2>
                        <a href="{{ route('assets.index') }}" class="text-blue-100 hover:text-blue-200 text-sm">
                            Ver todos los activos
                        </a>
                    </div>

                    @php
                        $recentAssets = \App\Models\Asset::latest()->take(5)->get();
                    @endphp

                    @if($recentAssets->count() > 0)
                        <table class="w-full">
                            <thead>
                                <tr class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wider">
                                    <th class="px-4 py-3 text-left">Nombre</th>
                                    <th class="px-4 py-3 text-left">Código de inventario</th>
                                    <th class="px-4 py-3 text-left">Código de patrimonio</th>
                                    <th class="px-4 py-3 text-left">Estado</th>
                                    <th class="px-4 py-3 text-left">Ubicación</th>
                                    <th class="px-4 py-3 text-right">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach ($recentAssets as $asset)
                                    <tr class="hover:bg-gray-50 transition duration-150">
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $asset->nombre }}
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $asset->codigo_inventario }}
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $asset->codigo_patrimonio }}
                                        </td>
                                        <td class="px-4 py-4">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                {{ $asset->status == 'Disponible' ? 'bg-green-100 text-green-800' : '' }}
                                                {{ $asset->status == 'En uso' ? 'bg-blue-100 text-blue-800' : '' }}
                                                {{ $asset->status == 'Mantenimiento' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                {{ $asset->status == 'Dado de baja' ? 'bg-red-100 text-red-800' : '' }}">
                                                {{ $asset->status }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-4 text-sm text-gray-500">
                                            {{ $asset->place ? $asset->place->name : 'Sin ubicación' }}
                                        </td>
                                        <td class="px-4 py-4 text-right">
                                            <a href="{{ route('assets.show', $asset->id) }}" 
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
                            No hay activos recientes
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>
</x-app-layout>





