<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row items-center justify-between gap-4">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Gestión de Hospedajes') }}
            </h2>
            @can('admin')
                <a href="{{ route('hospedajes.create') }}" class="inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-indigo-700">
                    {{ __('Nuevo Hospedaje') }}
                </a>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            {{-- Filter Bar --}}
            <div class="mb-8 overflow-hidden bg-white shadow-sm sm:rounded-3xl p-6">
                <form action="{{ route('hospedajes.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                    <div>
                        <x-input-label for="search" :value="__('Buscar')" />
                        <x-text-input id="search" name="search" type="text" class="mt-1 block w-full" :value="request('search')" placeholder="Nombre del hotel..." />
                    </div>
                    <div>
                        <x-input-label for="categoria" :value="__('Categoría')" />
                        <select name="categoria" id="categoria" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Todas las categorías</option>
                            @foreach($categorias as $cat)
                                <option value="{{ $cat }}" {{ request('categoria') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <x-input-label for="destino_id" :value="__('Destino')" />
                        <select name="destino_id" id="destino_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Todos los destinos</option>
                            @foreach($destinos as $dest)
                                <option value="{{ $dest->id }}" {{ request('destino_id') == $dest->id ? 'selected' : '' }}>{{ $dest->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex gap-2">
                        <x-primary-button class="flex-1 justify-center">
                            {{ __('Filtrar') }}
                        </x-primary-button>
                        @if(request()->anyFilled(['search', 'categoria', 'destino_id']))
                            <a href="{{ route('hospedajes.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 transition">
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

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-gray-500">
                            <thead class="bg-gray-50 text-xs font-semibold uppercase text-gray-700">
                                <tr>
                                    <th class="px-6 py-3">Nombre</th>
                                    <th class="px-6 py-3">Destino</th>
                                    <th class="px-6 py-3">Categoría</th>
                                    <th class="px-6 py-3">Precio/Noche</th>
                                    <th class="px-6 py-3">Hab. Disp.</th>
                                    <th class="px-6 py-3 text-right">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                @forelse($hospedajes as $hospedaje)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="whitespace-nowrap px-6 py-4">
                                            <div class="font-bold text-gray-900">{{ $hospedaje->nombre }}</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="inline-flex items-center text-indigo-600 font-medium">
                                                {{ $hospedaje->destino->nombre }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-bold text-blue-800 uppercase">
                                                {{ $hospedaje->categoria }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 font-black text-gray-900">${{ number_format($hospedaje->precio_noche, 2) }}</td>
                                        <td class="px-6 py-4">
                                            @if($hospedaje->habitaciones_disp > 0)
                                                <span class="text-green-600 font-bold">{{ $hospedaje->habitaciones_disp }} disponibles</span>
                                            @else
                                                <span class="text-red-500 font-bold">Agotado</span>
                                            @endif
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4 text-right">
                                            <div class="flex justify-end items-center gap-3">
                                                <a href="{{ route('hospedajes.show', $hospedaje) }}" class="text-xs font-bold text-gray-400 hover:text-gray-600 uppercase tracking-widest">Ver</a>
                                                @can('admin')
                                                    <a href="{{ route('hospedajes.edit', $hospedaje) }}" class="text-indigo-600 hover:text-indigo-900 font-bold uppercase text-xs">Editar</a>
                                                    <form action="{{ route('hospedajes.destroy', $hospedaje) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este hospedaje?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-500 hover:text-red-700 font-bold uppercase text-xs">Eliminar</button>
                                                    </form>
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="py-12 text-center text-gray-500">
                                            No se encontraron hospedajes que coincidan con los filtros.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
