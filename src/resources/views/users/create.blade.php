<x-event-layout>
    <x-slot name="title">
        {{ __('Users Manager > Create new user') }}
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 sm:px-20">

                    <x-validation-errors class="mb-4" />

                    <form action="{{ route('users.store') }}" method="POST"
                    enctype="multipart/form-data" novalidate>
                        @csrf
                        <div class="mb-3">
                            <!-- Contenedor para la vista previa de la imagen -->
                            <div id="image-preview" class="w-48 h-48 mt-2 bg-gray-300">
                                <!-- La imagen se mostrará aquí -->
                            </div>
                            <script>
                                function previewImage(event) {
                                    const file = event.target.files[0]; // Obtener el archivo seleccionado
                                    const previewContainer = document.getElementById('image-preview'); // El contenedor donde se mostrará la vista previa

                                    if (file) {
                                        // Si el archivo es una imagen
                                        const reader = new FileReader(); // Usamos FileReader para leer el archivo
                                        reader.onload = function(e) {
                                            // Establecer la imagen como fondo del contenedor
                                            previewContainer.style.backgroundImage = `url(${e.target.result})`;
                                            previewContainer.style.backgroundSize = 'cover'; // Ajusta la imagen al tamaño del contenedor
                                            previewContainer.style.backgroundPosition = 'center';
                                            previewContainer.style.backgroundColor = 'transparent'; // Elimina el color de fondo gris
                                        };
                                        reader.readAsDataURL(file); // Leer la imagen como URL base64
                                    } else {
                                        // Si no se ha seleccionado una imagen, mostrar el rectángulo gris
                                        previewContainer.style.backgroundImage = 'none';
                                        previewContainer.style.backgroundColor = '#ccc'; // Fondo gris
                                    }
                                }
                            </script>

                            <x-label for="profile_photo" value="Imagen de Perfil" />
                            <x-input id="profile_photo" class="block w-full mt-1" type="file" name="profile_photo"
                                :value="old('profile_photo')" required autocomplete="image" onchange="previewImage(event)"/>
                            <x-input-error for="profile_photo" class="mt-2" />
                        </div>

                        <div>
                            <x-label for="name" value="{{ __('Usuario') }}" />
                            <x-input id="name" class="block w-full mt-1" type="text" name="name"
                                :value="old('name')" required autofocus autocomplete="name" />
                        </div>

                        <div class="mt-4">
                            <x-label for="email" value="{{ __('Email') }}" />
                            <x-input id="email" class="block w-full mt-1" type="email" name="email"
                                :value="old('email')" required autocomplete="username" />
                        </div>

                        <div class="mt-4">
                            <x-label for="password" value="{{ __('Password') }}" />
                            <x-input id="password" class="block w-full mt-1" type="password" name="password" required
                                autocomplete="new-password" />
                        </div>

                        <div class="mt-4">
                            <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                            <x-input id="password_confirmation" class="block w-full mt-1" type="password"
                                name="password_confirmation" required autocomplete="new-password" />
                        </div>

                        <div class="mt-4">
                            <x-label for="nombres" value="{{ __('Nombres') }}" />
                            <x-input id="nombres" class="block w-full mt-1" type="text" name="nombres"
                                :value="old('nombres')" required autofocus autocomplete="nombres" />
                        </div>

                        <div class="mt-4">
                            <x-label for="apellidos" value="{{ __('Apellidos') }}" />
                            <x-input id="apellidos" class="block w-full mt-1" type="text" name="apellidos"
                                :value="old('apellidos')" required autofocus autocomplete="apellidos" />
                        </div>

                        <div class="mt-4">
                            <x-label for="registro" value="{{ __('Registro') }}" />
                            <x-input id="registro" class="block w-full mt-1" type="text" name="registro"
                                :value="old('registro')" required autofocus autocomplete="registro" />
                        </div>

                        <div class="mt-4">
                            <x-label for="cuil" value="{{ __('CUIL') }}" />
                            <x-input id="cuil" class="block w-full mt-1" type="text" name="cuil"
                                :value="old('cuil')" required autofocus autocomplete="cuil" />
                        </div>

                        <div class="mt-4">
                            <x-label for="nacimiento" value="{{ __('Fecha de Nacimiento') }}" />
                            <x-input id="nacimiento" class="block w-full mt-1" type="date" name="nacimiento"
                                :value="old('nacimiento')" required autofocus autocomplete="nacimiento" />
                        </div>

                        <div class="mt-4">
                            <x-label for="telefono" value="{{ __('Teléfono o Celular') }}" />
                            <x-input id="telefono" class="block w-full mt-1" type="text" name="telefono"
                                :value="old('telefono')" required autofocus autocomplete="telefono" />
                        </div>

                        <div class="mt-4">
                            <x-label for="domicilio" value="{{ __('Domicilio') }}" />
                            <x-input id="domicilio" class="block w-full mt-1" type="text" name="domicilio"
                                :value="old('domicilio')" required autofocus autocomplete="domicilio" />
                        </div>

                        <div class="mt-4">
                            <x-label for="area" value="{{ __('Area') }}" />
                            <select id="area" name="area" class="block w-full mt-1" required>
                                <option value="Software" {{ old('area') == 'Software' ? 'selected' : '' }}>Software</option>
                                <option value="Hardware" {{ old('area') == 'Hardware' ? 'selected' : '' }}>Hardware</option>
                                <option value="TI" {{ old('area') == 'TI' ? 'selected' : '' }}>TI</option>
                                <option value="Administrativa" {{ old('area') == 'Administrativa' ? 'selected' : '' }}>Administrativa</option>
                            </select>
                        </div>

                        <div class="mt-4">
                            <x-label for="coordinador" value="{{ __('Coordinador?') }}" />
                            <input id="coordinador" class="block mt-1" type="checkbox" name="coordinador" value="1" {{ old('coordinador') ? 'checked' : '' }} />
                            <x-input-error for="coordinador" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-label for="options" value="{{ __('Select Roles') }}" />
                            <select id="options" name="roles[]" multiple
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600">
                                @foreach ($roles as $role)
                                    <option value="{{ $role }}">{{ $role }}</option>
                                @endforeach
                            </select>


                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('roles.index') }}"
                                class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 float-end">
                                {{ __('Users list') }}
                            </a>

                            <x-button class="ms-4">
                                {{ __('Create user') }}
                            </x-button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-event-layout>
