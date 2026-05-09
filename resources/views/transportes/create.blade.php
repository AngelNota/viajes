<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Crear Transporte') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('transportes.store') }}" class="space-y-6">
                        @csrf

                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div>
                                <x-input-label for="tipo" :value="__('Medio de Transporte')" />
                                <select id="tipo" name="tipo" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    <option value="autobús" {{ old('tipo') == 'autobús' ? 'selected' : '' }}>Autobús</option>
                                    <option value="avión" {{ old('tipo') == 'avión' ? 'selected' : '' }}>Avión</option>
                                    <option value="tren" {{ old('tipo') == 'tren' ? 'selected' : '' }}>Tren</option>
                                    <option value="barco" {{ old('tipo') == 'barco' ? 'selected' : '' }}>Barco</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('tipo')" />
                            </div>

                            <div>
                                <x-input-label for="origen" :value="__('Ciudad de Origen')" />
                                <x-text-input id="origen" name="origen" type="text" class="mt-1 block w-full" :value="old('origen')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('origen')" />
                            </div>

                            <div>
                                <x-input-label for="destino" :value="__('Ciudad de Destino')" />
                                <x-text-input id="destino" name="destino" type="text" class="mt-1 block w-full" :value="old('destino')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('destino')" />
                            </div>

                            <div>
                                <x-input-label for="capacidad" :value="__('Capacidad (Plazas)')" />
                                <x-text-input id="capacidad" name="capacidad" type="number" class="mt-1 block w-full" :value="old('capacidad')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('capacidad')" />
                            </div>

                            <div>
                                <x-input-label for="precio" :value="__('Precio')" />
                                <x-text-input id="precio" name="precio" type="number" step="0.01" class="mt-1 block w-full" :value="old('precio')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('precio')" />
                            </div>

                            <div>
                                <x-input-label for="fecha_salida" :value="__('Fecha y Hora de Salida')" />
                                <x-text-input id="fecha_salida" name="fecha_salida" type="datetime-local" class="mt-1 block w-full" :value="old('fecha_salida')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('fecha_salida')" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end">
                            <x-primary-button>
                                {{ __('Guardar Transporte') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
