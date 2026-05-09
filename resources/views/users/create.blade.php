<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Agregar Nuevo Usuario') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-3xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('users.store') }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <div class="grid gap-6 sm:grid-cols-2">
                            <div>
                                <x-input-label for="name" :value="__('Nombre Completo')" />
                                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required autofocus />
                                <x-input-error class="mt-2" :messages="$errors->get('name')" />
                            </div>

                            <div>
                                <x-input-label for="email" :value="__('Correo Electrónico')" />
                                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('email')" />
                            </div>
                        </div>

                        <div class="grid gap-6 sm:grid-cols-2">
                            <div>
                                <x-input-label for="password" :value="__('Contraseña')" />
                                <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" required />
                                <x-input-error class="mt-2" :messages="$errors->get('password')" />
                            </div>

                            <div>
                                <x-input-label for="password_confirmation" :value="__('Confirmar Contraseña')" />
                                <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" required />
                            </div>
                        </div>

                        <div class="space-y-2">
                            <x-input-label :value="__('Rol del Usuario')" />
                            <div class="grid grid-cols-2 gap-4">
                                <label class="relative flex cursor-pointer items-center justify-center rounded-xl border border-gray-200 bg-white px-4 py-3 shadow-sm transition hover:border-indigo-500 has-[:checked]:border-indigo-500 has-[:checked]:bg-indigo-50">
                                    <input type="radio" name="role" value="user" {{ old('role', 'user') === 'user' ? 'checked' : '' }} class="sr-only">
                                    <span class="text-sm font-medium">Usuario</span>
                                </label>
                                <label class="relative flex cursor-pointer items-center justify-center rounded-xl border border-gray-200 bg-white px-4 py-3 shadow-sm transition hover:border-indigo-500 has-[:checked]:border-indigo-500 has-[:checked]:bg-indigo-50">
                                    <input type="radio" name="role" value="admin" {{ old('role') === 'admin' ? 'checked' : '' }} class="sr-only">
                                    <span class="text-sm font-medium">Administrador</span>
                                </label>
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('role')" />
                        </div>

                        <div class="flex items-center justify-end gap-4 pt-6">
                            <a href="{{ route('users.index') }}" class="text-sm text-gray-600 hover:text-gray-900">{{ __('Cancelar') }}</a>
                            <x-primary-button>
                                {{ __('Registrar Usuario') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
