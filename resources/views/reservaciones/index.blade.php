<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Mis Reservaciones') }}
        </h2>
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
                                    <th class="px-6 py-3">Fecha</th>
                                    <th class="px-6 py-3 text-right">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                @forelse($reservaciones as $reservacion)
                                    <tr class="hover:bg-gray-50">
                                        <td class="whitespace-nowrap px-6 py-4 font-bold text-indigo-600">{{ $reservacion->folio }}</td>
                                        @if(Auth::user()->isAdmin())
                                            <td class="px-6 py-4">{{ $reservacion->user->name }}</td>
                                        @endif
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $reservacion->viaje->nombre }}</div>
                                            <div class="text-xs text-gray-500">{{ $reservacion->viaje->destino->nombre }}</div>
                                        </td>
                                        <td class="px-6 py-4 font-semibold text-gray-900">${{ number_format($reservacion->monto_pagado, 2) }}</td>
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
                                            <span class="rounded-full px-2 py-1 text-xs font-bold uppercase {{ $color }}">
                                                {{ $reservacion->estado }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-xs text-gray-500">{{ $reservacion->created_at->format('d/m/Y') }}</td>
                                        <td class="whitespace-nowrap px-6 py-4 text-right">
                                            <a href="{{ route('reservaciones.show', $reservacion) }}" class="inline-flex items-center rounded-lg bg-gray-100 px-3 py-1 text-xs font-bold text-gray-700 transition hover:bg-gray-200">
                                                DETALLES
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="py-12 text-center text-gray-500">
                                            Aún no tienes reservaciones. ¡Explora nuestros destinos!
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
