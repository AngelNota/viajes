<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row items-center justify-between gap-4">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Catálogo de Destinos') }}
            </h2>
            @can('admin')
                <a href="{{ route('destinos.create') }}" class="inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-indigo-700">
                    {{ __('Nuevo Destino') }}
                </a>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            {{-- RF-03: Filter Bar --}}
            <div class="mb-8 overflow-hidden bg-white shadow-sm sm:rounded-3xl p-6">
                <form action="{{ route('destinos.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                    <div class="md:col-span-1">
                        <x-input-label for="search" :value="__('Buscar')" />
                        <x-text-input id="search" name="search" type="text" class="mt-1 block w-full" :value="request('search')" placeholder="Nombre, país..." />
                    </div>
                    <div>
                        <x-input-label for="pais" :value="__('País')" />
                        <select name="pais" id="pais" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Todos los países</option>
                            @foreach($paises as $pais)
                                <option value="{{ $pais }}" {{ request('pais') == $pais ? 'selected' : '' }}>{{ $pais }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <x-input-label for="sort" :value="__('Ordenar por')" />
                        <select name="sort" id="sort" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Más recientes</option>
                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Precio: Menor a Mayor</option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Precio: Mayor a Menor</option>
                        </select>
                    </div>
                    <div class="flex gap-2">
                        <x-primary-button class="flex-1 justify-center">
                            {{ __('Filtrar') }}
                        </x-primary-button>
                        @if(request()->anyFilled(['search', 'pais', 'sort']))
                            <a href="{{ route('destinos.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (session('success'))
                        <div class="mb-4 rounded-lg bg-green-100 p-4 text-sm text-green-700" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                        @forelse($destinos as $destino)
                            <div class="flex flex-col overflow-hidden rounded-2xl border border-gray-100 shadow-sm transition-all hover:shadow-lg bg-white">
                                @php
                                    $imagenes = json_decode($destino->imagen, true) ?? [];
                                    $primeraImagen = !empty($imagenes) ? asset('storage/' . $imagenes[0]) : 'https://via.placeholder.com/400x250?text=' . urlencode($destino->nombre);
                                @endphp
                                <div class="relative h-48 overflow-hidden">
                                    <img src="{{ $primeraImagen }}" alt="{{ $destino->nombre }}" class="h-full w-full object-cover">
                                    <div class="absolute top-4 right-4 rounded-full bg-white/90 px-3 py-1 text-xs font-bold text-gray-900 shadow-sm backdrop-blur-md">
                                        {{ $destino->pais }}
                                    </div>
                                </div>
                                
                                <div class="flex flex-1 flex-col p-5">
                                    <h3 class="text-xl font-black text-gray-900 mb-2">{{ $destino->nombre }}</h3>
                                    
                                    <p class="mb-4 line-clamp-2 text-sm text-gray-600 flex-1">
                                        {{ $destino->descripcion ?? 'Sin descripción disponible.' }}
                                    </p>
                                    
                                    <div class="mb-4 flex items-center justify-between">
                                        <div class="flex flex-col">
                                            <span class="text-[10px] uppercase font-bold text-gray-400">Desde</span>
                                            <span class="text-2xl font-black text-indigo-600">
                                                ${{ number_format($destino->precio_base, 2) }}
                                            </span>
                                        </div>
                                        @if(!$destino->activo)
                                            <span class="rounded-full bg-red-100 px-2 py-1 text-[10px] font-bold text-red-700 uppercase">Inactivo</span>
                                        @endif
                                    </div>

                                    <div class="mt-auto flex space-x-2 pt-4 border-t border-gray-50">
                                        <a href="{{ route('destinos.show', $destino) }}" class="flex-1 text-center rounded-xl bg-gray-100 py-2 text-xs font-bold text-gray-700 transition hover:bg-gray-200 uppercase tracking-widest">Ver más</a>
                                        @can('admin')
                                            <a href="{{ route('destinos.edit', $destino) }}" class="rounded-xl border border-indigo-100 p-2 text-indigo-600 hover:bg-indigo-50"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg></a>
                                        @endcan
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full py-12 text-center text-gray-500">
                                <p class="text-xl">No se encontraron destinos que coincidan con tu búsqueda.</p>
                                <a href="{{ route('destinos.index') }}" class="mt-4 inline-block text-indigo-600 font-bold underline">Limpiar filtros</a>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
