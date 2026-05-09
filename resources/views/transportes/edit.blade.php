<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Editar Transporte') }}: {{ $transporte->tipo }} ({{ $transporte->origen }} -> {{ $transporte->destino }})
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('transportes.update', $transporte) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div>
                                <x-input-label for="tipo" :value="__('Tipo de Transporte')" />
                                <x-text-input id="tipo" name="tipo" type="text" class="mt-1 block w-full" :value="old('tipo', $transporte->tipo)" required autofocus />
                                <x-input-error class="mt-2" :messages="$errors->get('tipo')" />
                            </div>

                            <div>
                                <x-input-label for="capacidad" :value="__('Capacidad (Plazas)')" />
                                <x-text-input id="capacidad" name="capacidad" type="number" class="mt-1 block w-full" :value="old('capacidad', $transporte->capacidad)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('capacidad')" />
                            </div>

                            <div>
                                <x-input-label for="origen" :value="__('Ciudad de Origen')" />
                                <x-text-input id="origen" name="origen" type="text" class="mt-1 block w-full" :value="old('origen', $transporte->origen)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('origen')" />
                            </div>

                            <div>
                                <x-input-label for="destino" :value="__('Ciudad de Destino')" />
                                <x-text-input id="destino" name="destino" type="text" class="mt-1 block w-full" :value="old('destino', $transporte->destino)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('destino')" />
                            </div>

                            <div>
                                <x-input-label for="precio" :value="__('Precio por Persona')" />
                                <x-text-input id="precio" name="precio" type="number" step="0.01" class="mt-1 block w-full" :value="old('precio', $transporte->precio)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('precio')" />
                            </div>

                            <div>
                                <x-input-label for="fecha_salida" :value="__('Fecha y Hora de Salida')" />
                                <x-text-input id="fecha_salida" name="fecha_salida" type="datetime-local" class="mt-1 block w-full" :value="old('fecha_salida', \Carbon\Carbon::parse($transporte->fecha_salida)->format('Y-m-d\TH:i'))" required />
                                <x-input-error class="mt-2" :messages="$errors->get('fecha_salida')" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end space-x-3">
                            <a href="{{ route('transportes.index') }}" class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-700 shadow-sm transition duration-150 ease-in-out hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25">
                                {{ __('Cancelar') }}
                            </a>
                            <x-primary-button>
                                {{ __('Actualizar Transporte') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
