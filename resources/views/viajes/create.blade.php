<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Crear Paquete de Viaje') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('viajes.store') }}" class="space-y-6">
                        @csrf

                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div class="md:col-span-2">
                                <x-input-label for="nombre" :value="__('Nombre del Paquete')" />
                                <x-text-input id="nombre" name="nombre" type="text" class="mt-1 block w-full" :value="old('nombre')" required autofocus />
                                <x-input-error class="mt-2" :messages="$errors->get('nombre')" />
                            </div>

                            <div>
                                <x-input-label for="destino_id" :value="__('Destino')" />
                                <select id="destino_id" name="destino_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    <option value="">Selecciona un destino</option>
                                    @foreach($destinos as $destino)
                                        <option value="{{ $destino->id }}" {{ old('destino_id') == $destino->id ? 'selected' : '' }}>
                                            {{ $destino->nombre }} ({{ $destino->pais }})
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('destino_id')" />
                            </div>

                            <div>
                                <x-input-label for="hospedaje_id" :value="__('Hospedaje')" />
                                <select id="hospedaje_id" name="hospedaje_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    <option value="">Selecciona un hospedaje</option>
                                    @foreach($hospedajes as $hospedaje)
                                        <option value="{{ $hospedaje->id }}" {{ old('hospedaje_id') == $hospedaje->id ? 'selected' : '' }}>
                                            {{ $hospedaje->nombre }} - ${{ $hospedaje->precio_noche }}/noche
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('hospedaje_id')" />
                            </div>

                            <div>
                                <x-input-label for="transporte_id" :value="__('Transporte')" />
                                <select id="transporte_id" name="transporte_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    <option value="">Selecciona un transporte</option>
                                    @foreach($transportes as $transporte)
                                        <option value="{{ $transporte->id }}" {{ old('transporte_id') == $transporte->id ? 'selected' : '' }}>
                                            {{ $transporte->tipo }}: {{ $transporte->origen }} -> {{ $transporte->destino }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('transporte_id')" />
                            </div>

                            <div>
                                <x-input-label for="capacidad" :value="__('Capacidad Total (Lugares)')" />
                                <x-text-input id="capacidad" name="capacidad" type="number" class="mt-1 block w-full" :value="old('capacidad')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('capacidad')" />
                            </div>

                            <div>
                                <x-input-label for="fecha_inicio" :value="__('Fecha de Inicio')" />
                                <x-text-input id="fecha_inicio" name="fecha_inicio" type="date" class="mt-1 block w-full" :value="old('fecha_inicio')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('fecha_inicio')" />
                            </div>

                            <div>
                                <x-input-label for="fecha_fin" :value="__('Fecha de Fin')" />
                                <x-text-input id="fecha_fin" name="fecha_fin" type="date" class="mt-1 block w-full" :value="old('fecha_fin')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('fecha_fin')" />
                            </div>

                            <div>
                                <x-input-label for="precio_total" :value="__('Precio Total del Paquete')" />
                                <x-text-input id="precio_total" name="precio_total" type="number" step="0.01" class="mt-1 block w-full" :value="old('precio_total')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('precio_total')" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end">
                            <x-primary-button>
                                {{ __('Crear Paquete') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
