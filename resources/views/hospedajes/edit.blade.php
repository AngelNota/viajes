<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Editar Hospedaje') }}: {{ $hospedaje->nombre }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('hospedajes.update', $hospedaje) }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div>
                                <x-input-label for="destino_id" :value="__('Destino')" />
                                <select id="destino_id" name="destino_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    @foreach($destinos as $destino)
                                        <option value="{{ $destino->id }}" {{ old('destino_id', $hospedaje->destino_id) == $destino->id ? 'selected' : '' }}>
                                            {{ $destino->nombre }} ({{ $destino->pais }})
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('destino_id')" />
                            </div>

                            <div>
                                <x-input-label for="nombre" :value="__('Nombre del Hospedaje')" />
                                <x-text-input id="nombre" name="nombre" type="text" class="mt-1 block w-full" :value="old('nombre', $hospedaje->nombre)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('nombre')" />
                            </div>

                            <div>
                                <x-input-label for="categoria" :value="__('Categoría')" />
                                <x-text-input id="categoria" name="categoria" type="text" class="mt-1 block w-full" :value="old('categoria', $hospedaje->categoria)" placeholder="Hotel, Hostal, Resort..." required />
                                <x-input-error class="mt-2" :messages="$errors->get('categoria')" />
                            </div>

                            <div>
                                <x-input-label for="precio_noche" :value="__('Precio por Noche')" />
                                <x-text-input id="precio_noche" name="precio_noche" type="number" step="0.01" class="mt-1 block w-full" :value="old('precio_noche', $hospedaje->precio_noche)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('precio_noche')" />
                            </div>

                            <div>
                                <x-input-label for="habitaciones_disp" :value="__('Habitaciones Disponibles')" />
                                <x-text-input id="habitaciones_disp" name="habitaciones_disp" type="number" class="mt-1 block w-full" :value="old('habitaciones_disp', $hospedaje->habitaciones_disp)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('habitaciones_disp')" />
                            </div>

                            <div class="md:col-span-2">
                                <x-input-label for="imagen" :value="__('Imágenes')" />
                                @if($hospedaje->imagen)
                                    <div class="mb-4 grid grid-cols-5 gap-2">
                                        @php $imagenes = json_decode($hospedaje->imagen, true) ?? []; @endphp
                                        @foreach($imagenes as $img)
                                            <img src="{{ asset('storage/' . $img) }}" alt="Actual" class="h-16 w-16 rounded-lg object-cover">
                                        @endforeach
                                    </div>
                                @endif
                                <input id="imagen" name="imagen[]" type="file" multiple class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:rounded-full file:border-0 file:bg-indigo-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-indigo-700 hover:file:bg-indigo-100" accept="image/*" />
                                <x-input-error class="mt-2" :messages="$errors->get('imagen')" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end space-x-3">
                            <a href="{{ route('hospedajes.index') }}" class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-700 shadow-sm transition duration-150 ease-in-out hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25">
                                {{ __('Cancelar') }}
                            </a>
                            <x-primary-button>
                                {{ __('Actualizar Hospedaje') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
