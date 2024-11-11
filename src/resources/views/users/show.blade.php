<x-event-layout>
    <x-slot name="title">
        {{ __('Users Manager') }}
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 sm:px-20">
                    <div class="row">
                        <div class="mb-4 col-lg-12 margin-tb">
                            <div class="pull-left">
                                <div class="float-end">
                                    <x-button onclick="window.location='{{ route('users.index') }}'">
                                        {{ __('Back') }}
                                    </x-button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <img src="data:image/png;base64,{{ $user->profile_photo }}" alt="Imagen de Perfil" width="255">
                    <div class="row">
                        <div class="mb-3 col-xs-12">
                            <div class="form-group">
                                <strong>Usuario:</strong>
                                {{ $user->name }}
                            </div>
                        </div>
                        <div class="mb-3 col-xs-12">
                            <div class="form-group">
                                <strong>Email:</strong>
                                {{ $user->email }}
                            </div>
                        </div>
                        <div class="mb-3 col-xs-12">
                            <div class="form-group">
                                <strong>Roles:</strong>
                                @if (!empty($user->getRoleNames()))
                                    @foreach ($user->getRoleNames() as $v)
                                        <label class="badge badge-secondary text-dark">{{ $v }}</label>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <div class="mb-3 col-xs-12">
                            <div class="form-group">
                                <strong>Registro:</strong>
                                {{ $user->registro }}
                            </div>
                        </div>
                        <div class="mb-3 col-xs-12">
                            <div class="form-group">
                                <strong>Nombres y Apellidos:</strong>
                                {{ $user->nombres.' '.$user->apellidos }}
                            </div>
                        </div>
                        <div class="mb-3 col-xs-12">
                            <div class="form-group">
                                <strong>CUIL:</strong>
                                {{ $user->cuil }}
                            </div>
                        </div>
                        <div class="mb-3 col-xs-12">
                            <div class="form-group">
                                <strong>Fecha de nacimiento:</strong>
                                {{ $user->nacimiento }}
                            </div>
                        </div>
                        <div class="mb-3 col-xs-12">
                            <div class="form-group">
                                <strong>Teléfono:</strong>
                                {{ $user->telefono }}
                            </div>
                        </div>
                        <div class="mb-3 col-xs-12">
                            <div class="form-group">
                                <strong>Domicilio:</strong>
                                {{ $user->domicilio }}
                            </div>
                        </div>
                        <div class="mb-3 col-xs-12">
                            <div class="form-group">
                                <strong>Area Asignada:</strong>
                                {{ $user->area.($user->coordinador ? ' (Coordinador)' : '') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-event-layout>
