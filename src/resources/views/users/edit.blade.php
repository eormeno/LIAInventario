<x-event-layout>
    <x-slot name="title">
        {{ __('Users Manager > Edit user') }}
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 sm:px-20">

                    <x-validation-errors class="mb-4" />
                    <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div id="image-preview" class="relative w-48 h-48 mt-2 overflow-hidden bg-gray-300">
                            <img id="preview-img" src="data:image/png;base64,{{ $user->profile_photo }}"
                                alt="Imagen de Perfil" class="absolute inset-0 object-cover w-full h-full">
                        </div>
                        <script>
                            function previewImage(event) {
                                const file = event.target.files[0];

                                if (file) {
                                    const previewImg = document.getElementById('preview-img');
                                    const reader = new FileReader();
                                    reader.onload = function(e) {
                                        previewImg.src = e.target.result;
                                    };
                                    reader.readAsDataURL(file);
                                }
                            }
                        </script>
                        <x-label for="profile_photo" value="Imagen de Perfil" />
                        <x-input id="profile_photo" class="block w-full mt-1" type="file" name="profile_photo"
                            :value="old('profile_photo')" autocomplete="image" onchange="previewImage(event)" />
                        <x-input-error for="profile_photo" class="mt-2" />
                        
                        <div>
                            <x-label for="name" value="{{ __('Usuario') }}" />
                            <x-input id="name" class="block w-full mt-1" type="text" name="name"
                                value="{{ $user->name }}" required autofocus autocomplete="name" />
                        </div>

                        <div class="mt-4">
                            <x-label for="email" value="{{ __('Email') }}" />
                            <x-input id="email" class="block w-full mt-1" type="email" name="email"
                                value="{{ $user->email }}" required autocomplete="email" />
                        </div>

                        <div class="mt-4">
                            <x-label for="password" value="{{ __('Contraseña') }}" />
                            <x-input id="password" class="block w-full mt-1" type="password" name="password"
                                autocomplete="password" />
                        </div>

                        <div class="mt-4">
                            <x-label for="password_confirmation" value="{{ __('Confirmar Contraseña') }}" />
                            <x-input id="password_confirmation" class="block w-full mt-1" type="password"
                                name="password_confirmation" autocomplete="new-password" />
                        </div>

                        <div class="mt-4">
                            <x-label for="email" value="{{ __('Email') }}" />
                            <x-input id="email" class="block w-full mt-1" type="email" name="email"
                                value="{{ $user->email }}" required autocomplete="email" />
                        </div>

                        <div class="mt-4">
                            <x-label for="nombres" value="{{ __('Nombres') }}" />
                            <x-input id="nombres" class="block w-full mt-1" type="text" name="nombres"
                                :value="old('nombres')" 
                                value="{{ $user->nombres }}" required autofocus autocomplete="nombres" />
                        </div>

                        <div class="mt-4">
                            <x-label for="apellidos" value="{{ __('Apellidos') }}" />
                            <x-input id="apellidos" class="block w-full mt-1" type="text" name="apellidos"
                                :value="old('apellidos')" 
                                value="{{ $user->apellidos }}" required autofocus autocomplete="apellidos" />
                        </div>

                        <div class="mt-4">
                            <x-label for="registro" value="{{ __('Registro') }}" />
                            <x-input id="registro" class="block w-full mt-1" type="text" name="registro"
                                :value="old('registro')"
                                value="{{ $user->registro }}" required autofocus autocomplete="registro" />
                        </div>

                        <div class="mt-4">
                            <x-label for="cuil" value="{{ __('CUIL') }}" />
                            <x-input id="cuil" class="block w-full mt-1" type="text" name="cuil"
                                :value="old('cuil')"
                                value="{{ $user->cuil }}" required autofocus autocomplete="cuil" />
                        </div>

                        <div class="mt-4">
                            <x-label for="nacimiento" value="{{ __('Fecha de Nacimiento') }}" />
                            <x-input id="nacimiento" class="block w-full mt-1" type="date" name="nacimiento"
                                :value="old('nacimiento')"
                                value="{{ $user->nacimiento }}" required autofocus autocomplete="nacimiento" />
                        </div>

                        <div class="mt-4">
                            <x-label for="telefono" value="{{ __('Teléfono o Celular') }}" />
                            <x-input id="telefono" class="block w-full mt-1" type="text" name="telefono"
                                :value="old('telefono')"
                                value="{{ $user->telefono }}" required autofocus autocomplete="telefono" />
                        </div>

                        <div class="mt-4">
                            <x-label for="domicilio" value="{{ __('Domicilio') }}" />
                            <x-input id="domicilio" class="block w-full mt-1" type="text" name="domicilio"
                                :value="old('domicilio')"
                                value="{{ $user->domicilio }}" required autofocus autocomplete="domicilio" />
                        </div>

                        <div class="mt-4">
                            <x-label for="area" value="{{ __('Área') }}" />
                            <select id="area" name="area" class="block w-full mt-1" required>
                                <option value="Software" {{ $user->area == 'Software' ? 'selected' : '' }}>Software</option>
                                <option value="Hardware" {{ $user->area == 'Hardware' ? 'selected' : '' }}>Hardware</option>
                                <option value="TI" {{ $user->area == 'TI' ? 'selected' : '' }}>TI</option>
                                <option value="Administrativa" {{ $user->area == 'Administrativa' ? 'selected' : '' }}>Administrativa</option>
                            </select>
                        </div>

                        <div class="mt-4">
                            <x-label for="coordinador" value="{{ __('Coordinador?') }}" />
                            <input id="coordinador" class="block mt-1" type="checkbox" name="coordinador" value="1" {{ $user->coordinador ? 'checked' : '' }} />
                            <x-input-error for="coordinador" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-label for="options" value="{{ __('Select Roles') }}" />
                            <select id="options" name="roles[]" multiple
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600">
                                @foreach ($roles as $role)
                                    <option value="{{ $role }}"
                                        @if (in_array($role, $userRole)) selected @endif>{{ $role }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-button class="ms-4">
                                {{ __('Edit user') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-event-layout>
