<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Gestión de Destinos') }}
            </h2>
            @can('admin')
                <a href="{{ route('destinos.create') }}" class="inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-indigo-700 focus:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 active:bg-indigo-900">
                    {{ __('Nuevo Destino') }}
                </a>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (session('success'))
                        <div class="mb-4 rounded-lg bg-green-100 p-4 text-sm text-green-700" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                        @forelse($destinos as $destino)
                            <div class="flex flex-col overflow-hidden rounded-lg border border-gray-200 shadow-sm transition hover:shadow-md">
                                @php
                                    $imagenes = json_decode($destino->imagen, true) ?? [];
                                    $primeraImagen = !empty($imagenes) ? asset('storage/' . $imagenes[0]) : 'https://via.placeholder.com/400x250?text=No+Image';
                                @endphp
                                <img src="{{ $primeraImagen }}" alt="{{ $destino->nombre }}" class="h-48 w-full object-cover">
                                
                                <div class="flex flex-1 flex-col p-4">
                                    <div class="mb-2 flex items-center justify-between">
                                        <h3 class="text-lg font-bold text-gray-900">{{ $destino->nombre }}</h3>
                                        <span class="rounded-full bg-indigo-100 px-2 py-1 text-xs font-semibold text-indigo-800">
                                            {{ $destino->pais }}
                                        </span>
                                    </div>
                                    
                                    <p class="mb-4 line-clamp-3 flex-1 text-sm text-gray-600">
                                        {{ $destino->descripcion ?? 'Sin descripción disponible.' }}
                                    </p>
                                    
                                    <div class="mb-4 flex items-center justify-between">
                                        <span class="text-lg font-bold text-gray-900">
                                            ${{ number_format($destino->precio_base, 2) }}
                                        </span>
                                        @if($destino->activo)
                                            <span class="text-xs font-medium text-green-600 uppercase tracking-wider">Activo</span>
                                        @else
                                            <span class="text-xs font-medium text-red-600 uppercase tracking-wider">Inactivo</span>
                                        @endif
                                    </div>

                                    @can('admin')
                                        <div class="mt-auto flex space-x-2 pt-4 border-t border-gray-100">
                                            <a href="{{ route('destinos.edit', $destino) }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-900">Editar</a>
                                            <form action="{{ route('destinos.destroy', $destino) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este destino?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-sm font-medium text-red-600 hover:text-red-900">Eliminar</button>
                                            </form>
                                        </div>
                                    @endcan
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full py-12 text-center text-gray-500">
                                No hay destinos registrados aún.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
