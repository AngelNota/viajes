<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Crear Hospedaje') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('hospedajes.store') }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
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
                                <x-input-label for="nombre" :value="__('Nombre del Hospedaje')" />
                                <x-text-input id="nombre" name="nombre" type="text" class="mt-1 block w-full" :value="old('nombre')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('nombre')" />
                            </div>

                            <div>
                                <x-input-label for="categoria" :value="__('Categoría')" />
                                <x-text-input id="categoria" name="categoria" type="text" class="mt-1 block w-full" :value="old('categoria')" placeholder="Hotel, Hostal, Resort..." required />
                                <x-input-error class="mt-2" :messages="$errors->get('categoria')" />
                            </div>

                            <div>
                                <x-input-label for="precio_noche" :value="__('Precio por Noche')" />
                                <x-text-input id="precio_noche" name="precio_noche" type="number" step="0.01" class="mt-1 block w-full" :value="old('precio_noche')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('precio_noche')" />
                            </div>

                            <div>
                                <x-input-label for="habitaciones_disp" :value="__('Habitaciones Disponibles')" />
                                <x-text-input id="habitaciones_disp" name="habitaciones_disp" type="number" class="mt-1 block w-full" :value="old('habitaciones_disp')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('habitaciones_disp')" />
                            </div>

                            <div class="md:col-span-2">
                                <x-input-label for="imagen" :value="__('Imágenes')" />
                                <input id="imagen" name="imagen[]" type="file" multiple class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:rounded-full file:border-0 file:bg-indigo-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-indigo-700 hover:file:bg-indigo-100" accept="image/*" />
                                <x-input-error class="mt-2" :messages="$errors->get('imagen')" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end">
                            <x-primary-button>
                                {{ __('Guardar Hospedaje') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
