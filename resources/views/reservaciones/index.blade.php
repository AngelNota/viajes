<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ Auth::user()->isAdmin() ? __('Todas las Reservaciones') : __('Mis Reservaciones') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            {{-- Filter Bar --}}
            <div class="mb-8 overflow-hidden bg-white shadow-sm sm:rounded-3xl p-6">
                <form action="{{ route('reservaciones.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                    <div>
                        <x-input-label for="search" :value="__('Buscar Folio o Viaje')" />
                        <x-text-input id="search" name="search" type="text" class="mt-1 block w-full" :value="request('search')" placeholder="Folio o nombre..." />
                    </div>
                    <div>
                        <x-input-label for="estado" :value="__('Estado')" />
                        <select name="estado" id="estado" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Cualquier estado</option>
                            @foreach($estados as $est)
                                <option value="{{ $est }}" {{ request('estado') == $est ? 'selected' : '' }}>{{ ucfirst($est) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex gap-2">
                        <x-primary-button class="flex-1 justify-center">
                            {{ __('Filtrar') }}
                        </x-primary-button>
                        @if(request()->anyFilled(['search', 'estado']))
                            <a href="{{ route('reservaciones.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 transition">
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
                                    <th class="px-6 py-3">Folio</th>
                                    @if(Auth::user()->isAdmin())
                                        <th class="px-6 py-3">Usuario</th>
                                    @endif
                                    <th class="px-6 py-3">Viaje</th>
                                    <th class="px-6 py-3">Monto</th>
                                    <th class="px-6 py-3">Estado</th>
                                    <th class="px-6 py-3 text-right">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                @forelse($reservaciones as $reservacion)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="whitespace-nowrap px-6 py-4 font-black text-indigo-600">#{{ $reservacion->folio }}</td>
                                        @if(Auth::user()->isAdmin())
                                            <td class="px-6 py-4 font-medium text-gray-900">{{ $reservacion->user->name }}</td>
                                        @endif
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-bold text-gray-900">{{ $reservacion->viaje->nombre }}</div>
                                            <div class="text-[10px] text-gray-500 uppercase tracking-widest">{{ $reservacion->viaje->destino->nombre }}</div>
                                        </td>
                                        <td class="px-6 py-4 font-black text-gray-900">${{ number_format($reservacion->monto_pagado, 2) }}</td>
                                        <td class="px-6 py-4">
                                            @php
                                                $colors = [
                                                    'pendiente' => 'bg-yellow-100 text-yellow-800',
                                                    'confirmado' => 'bg-green-100 text-green-800',
                                                    'completado' => 'bg-blue-100 text-blue-800',
                                                    'cancelado' => 'bg-red-100 text-red-800',
                                                ];
                                                $color = $colors[$reservacion->estado] ?? 'bg-gray-100 text-gray-800';
                                            @endphp
                                            <span class="rounded-full px-2.5 py-0.5 text-[10px] font-black uppercase {{ $color }}">
                                                {{ $reservacion->estado }}
                                            </span>
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4 text-right">
                                            <div class="flex justify-end items-center gap-3">
                                                <a href="{{ route('reservaciones.show', $reservacion) }}" class="text-[10px] font-black text-gray-400 hover:text-gray-600 uppercase tracking-widest">Detalles</a>
                                                @can('admin')
                                                    <a href="{{ route('reservaciones.edit', $reservacion) }}" class="text-indigo-600 hover:text-indigo-900 font-bold uppercase text-xs">Gestionar</a>
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="py-12 text-center text-gray-500">
                                            No se encontraron reservaciones con los criterios de búsqueda.
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
