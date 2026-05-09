<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Catálogo de Paquetes de Viaje') }}
            </h2>
            @can('admin')
                <a href="{{ route('viajes.create') }}" class="inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-indigo-700 focus:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 active:bg-indigo-900">
                    {{ __('Nuevo Paquete') }}
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
                    @if (session('error'))
                        <div class="mb-4 rounded-lg bg-red-100 p-4 text-sm text-red-700" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
                        @forelse($viajes as $viaje)
                            <div class="flex flex-col overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm transition-all duration-300 hover:shadow-xl">
                                @php
                                    $imagenes = json_decode($viaje->destino->imagen, true) ?? [];
                                    $primeraImagen = !empty($imagenes) ? asset('storage/' . $imagenes[0]) : 'https://via.placeholder.com/400x250?text=' . urlencode($viaje->destino->nombre);
                                @endphp
                                <div class="relative">
                                    <img src="{{ $primeraImagen }}" alt="{{ $viaje->nombre }}" class="h-56 w-full object-cover">
                                    <div class="absolute top-4 right-4 rounded-full bg-white/90 px-3 py-1 text-xs font-bold text-gray-900 shadow-sm backdrop-blur-md">
                                        {{ $viaje->destino->pais }}
                                    </div>
                                </div>

                                <div class="flex flex-1 flex-col p-6">
                                    <h3 class="mb-2 text-xl font-bold text-gray-900">{{ $viaje->nombre }}</h3>
                                    
                                    <div class="mb-4 space-y-2 text-sm text-gray-600">
                                        <div class="flex items-center">
                                            <svg class="mr-2 h-4 w-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                            {{ $viaje->hospedaje->nombre }} ({{ $viaje->hospedaje->categoria }})
                                        </div>
                                        <div class="flex items-center">
                                            <svg class="mr-2 h-4 w-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            {{ \Carbon\Carbon::parse($viaje->fecha_inicio)->format('d M') }} - {{ \Carbon\Carbon::parse($viaje->fecha_fin)->format('d M, Y') }}
                                        </div>
                                        <div class="flex items-center">
                                            <svg class="mr-2 h-4 w-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                            {{ $viaje->capacidad - $viaje->reservaciones()->count() }} lugares disponibles
                                        </div>
                                    </div>

                                    <div class="mt-auto flex items-center justify-between border-t border-gray-100 pt-4">
                                        <div class="flex flex-col">
                                            <span class="text-xs font-medium text-gray-400 uppercase tracking-wider">Precio total</span>
                                            <span class="text-2xl font-black text-gray-900">${{ number_format($viaje->precio_total, 2) }}</span>
                                        </div>
                                        
                                        @if($viaje->reservaciones()->count() < $viaje->capacidad)
                                            <form action="{{ route('reservaciones.store') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="viaje_id" value="{{ $viaje->id }}">
                                                <button type="submit" class="rounded-xl bg-indigo-600 px-4 py-2 text-sm font-bold text-white shadow-lg shadow-indigo-200 transition-all hover:bg-indigo-700 active:scale-95">
                                                    Comprar
                                                </button>
                                            </form>
                                        @else
                                            <span class="rounded-xl bg-gray-100 px-4 py-2 text-sm font-bold text-gray-400">Agotado</span>
                                        @endif
                                    </div>

                                    @can('admin')
                                        <div class="mt-4 flex space-x-3 pt-4 border-t border-gray-50">
                                            <a href="{{ route('viajes.edit', $viaje) }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-900">EDITAR</a>
                                            <form action="{{ route('viajes.destroy', $viaje) }}" method="POST" onsubmit="return confirm('¿Eliminar este paquete?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-xs font-bold text-red-600 hover:text-red-900">ELIMINAR</button>
                                            </form>
                                        </div>
                                    @endcan
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full py-24 text-center">
                                <p class="text-xl text-gray-500">No hay paquetes de viaje disponibles en este momento.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
