<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Crear Destino') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('destinos.store') }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div>
                                <x-input-label for="nombre" :value="__('Nombre del Destino')" />
                                <x-text-input id="nombre" name="nombre" type="text" class="mt-1 block w-full" :value="old('nombre')" required autofocus />
                                <x-input-error class="mt-2" :messages="$errors->get('nombre')" />
                            </div>

                            <div>
                                <x-input-label for="pais" :value="__('País')" />
                                <x-text-input id="pais" name="pais" type="text" class="mt-1 block w-full" :value="old('pais')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('pais')" />
                            </div>

                            <div class="md:col-span-2">
                                <x-input-label for="descripcion" :value="__('Descripción')" />
                                <textarea id="descripcion" name="descripcion" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" rows="4">{{ old('descripcion') }}</textarea>
                                <x-input-error class="mt-2" :messages="$errors->get('descripcion')" />
                            </div>

                            <div>
                                <x-input-label for="precio_base" :value="__('Precio Base')" />
                                <x-text-input id="precio_base" name="precio_base" type="number" step="0.01" class="mt-1 block w-full" :value="old('precio_base')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('precio_base')" />
                            </div>

                            <div>
                                <x-input-label for="activo" :value="__('Estado')" />
                                <div class="mt-2">
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="activo" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" {{ old('activo', true) ? 'checked' : '' }}>
                                        <span class="ml-2 text-sm text-gray-600">Activo</span>
                                    </label>
                                </div>
                            </div>

                            <div class="md:col-span-2">
                                <x-input-label for="imagen" :value="__('Imágenes')" />
                                <input id="imagen" name="imagen[]" type="file" multiple class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:rounded-full file:border-0 file:bg-indigo-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-indigo-700 hover:file:bg-indigo-100" accept="image/*" />
                                <x-input-error class="mt-2" :messages="$errors->get('imagen')" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end">
                            <x-primary-button>
                                {{ __('Guardar Destino') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
