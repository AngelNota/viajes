<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Editar Destino') }}: {{ $destino->nombre }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('destinos.update', $destino) }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <x-input-label for="nombre" :value="__('Nombre del Destino')" />
                            <x-text-input id="nombre" name="nombre" type="text" class="mt-1 block w-full" :value="old('nombre', $destino->nombre)" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('nombre')" />
                        </div>

                        <div>
                            <x-input-label for="pais" :value="__('País')" />
                            <x-text-input id="pais" name="pais" type="text" class="mt-1 block w-full" :value="old('pais', $destino->pais)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('pais')" />
                        </div>

                        <div>
                            <x-input-label for="descripcion" :value="__('Descripción')" />
                            <textarea id="descripcion" name="descripcion" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('descripcion', $destino->descripcion) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('descripcion')" />
                        </div>

                        <div>
                            <x-input-label for="precio_base" :value="__('Precio Base')" />
                            <x-text-input id="precio_base" name="precio_base" type="number" step="0.01" class="mt-1 block w-full" :value="old('precio_base', $destino->precio_base)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('precio_base')" />
                        </div>

                        <div class="flex items-center">
                            <input id="activo" name="activo" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" {{ old('activo', $destino->activo) ? 'checked' : '' }}>
                            <x-input-label for="activo" class="ml-2" :value="__('Activo')" />
                        </div>

                        <div class="flex items-center justify-end space-x-3">
                            <a href="{{ route('destinos.index') }}" class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-700 shadow-sm transition duration-150 ease-in-out hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25">
                                {{ __('Cancelar') }}
                            </a>
                            <x-primary-button>
                                {{ __('Actualizar Destino') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
