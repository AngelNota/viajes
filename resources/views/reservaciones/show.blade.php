<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Detalles de la Reservación') }} #{{ $reservacion->folio }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-4xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-xl sm:rounded-3xl">
                <div class="p-8">
                    <div class="mb-8 flex flex-col justify-between border-b border-gray-100 pb-8 md:flex-row">
                        <div>
                            <span class="text-xs font-bold uppercase tracking-widest text-indigo-500">Comprobante de Viaje</span>
                            <h1 class="font-display text-4xl font-black text-gray-900">{{ $reservacion->viaje->nombre }}</h1>
                            <p class="mt-2 text-lg text-gray-600">{{ $reservacion->viaje->destino->nombre }}, {{ $reservacion->viaje->destino->pais }}</p>
                        </div>
                        <div class="mt-6 text-left md:mt-0 md:text-right">
                            <div class="text-xs font-bold uppercase tracking-widest text-gray-400">Folio de Reserva</div>
                            <div class="text-3xl font-black text-indigo-600">{{ $reservacion->folio }}</div>
                            <div class="mt-2 inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-bold uppercase text-green-800">
                                {{ $reservacion->estado }}
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-12 md:grid-cols-2">
                        <div class="space-y-6">
                            <div>
                                <h3 class="text-sm font-bold uppercase tracking-wider text-gray-900">Información del Viajero</h3>
                                <div class="mt-2 space-y-1">
                                    <p class="text-lg font-semibold text-gray-800">{{ $reservacion->user->name }}</p>
                                    <p class="text-sm text-gray-600">{{ $reservacion->user->email }}</p>
                                    <p class="text-sm text-gray-600">{{ $reservacion->user->phone ?? 'Sin teléfono' }}</p>
                                </div>
                            </div>

                            <div>
                                <h3 class="text-sm font-bold uppercase tracking-wider text-gray-900">Detalles del Paquete</h3>
                                <div class="mt-2 grid grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-xs font-bold text-gray-400">FECHA SALIDA</p>
                                        <p class="text-sm font-semibold">{{ \Carbon\Carbon::parse($reservacion->viaje->fecha_inicio)->format('d/m/Y') }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-gray-400">FECHA REGRESO</p>
                                        <p class="text-sm font-semibold">{{ \Carbon\Carbon::parse($reservacion->viaje->fecha_fin)->format('d/m/Y') }}</p>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <h3 class="text-sm font-bold uppercase tracking-wider text-gray-900">Alojamiento</h3>
                                <div class="mt-2">
                                    <p class="font-semibold text-gray-800">{{ $reservacion->viaje->hospedaje->nombre }}</p>
                                    <p class="text-sm text-gray-600">{{ $reservacion->viaje->hospedaje->categoria }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col justify-between rounded-3xl bg-gray-50 p-6">
                            <div class="space-y-4">
                                <h3 class="text-sm font-bold uppercase tracking-wider text-gray-900">Resumen de Pago</h3>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Paquete de viaje</span>
                                    <span class="font-semibold">${{ number_format($reservacion->monto_pagado, 2) }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Impuestos (incl.)</span>
                                    <span class="font-semibold text-green-600">GRATIS</span>
                                </div>
                                <div class="border-t border-gray-200 pt-4">
                                    <div class="flex justify-between">
                                        <span class="text-lg font-bold text-gray-900">Total Pagado</span>
                                        <span class="text-2xl font-black text-indigo-600">${{ number_format($reservacion->monto_pagado, 2) }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-8 space-y-3">
                                <a href="{{ route('reservaciones.pdf', $reservacion) }}" class="flex w-full items-center justify-center rounded-xl bg-indigo-600 px-6 py-3 text-sm font-bold text-white transition hover:bg-indigo-700 shadow-lg shadow-indigo-100">
                                    <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                    DESCARGAR TICKET (PDF)
                                </a>
                                <button onclick="window.print()" class="flex w-full items-center justify-center rounded-xl bg-gray-900 px-6 py-3 text-sm font-bold text-white transition hover:bg-black">
                                    <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                    IMPRIMIR RÁPIDO
                                </button>
                                <a href="{{ route('reservaciones.index') }}" class="flex w-full items-center justify-center rounded-xl border border-gray-200 bg-white px-6 py-3 text-sm font-bold text-gray-700 transition hover:bg-gray-50">
                                    VOLVER AL LISTADO
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="mt-12 rounded-2xl bg-indigo-50 p-6 text-center">
                        <p class="text-xs font-medium text-indigo-700">
                            Este PDF es tu comprobante oficial. Preséntalo al abordar o en el check-in del hotel.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        @media print {
            nav, .py-12 > div > div > div > div:last-child .mt-8 { display: none !important; }
            .py-12 { padding-top: 0 !important; }
            .shadow-xl { shadow: none !important; }
            body { background: white !important; }
        }
    </style>
</x-app-layout>
