<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row items-center justify-between gap-4">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Paquetes de Viaje Disponibles') }}
            </h2>
            @can('admin')
                <a href="{{ route('viajes.create') }}" class="inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-indigo-700">
                    {{ __('Nuevo Paquete') }}
                </a>
            @endcan
        </div>
    </x-slot>

    <div class="py-12" x-data="{ showBookingModal: {{ session('reservacion_id') ? 'true' : 'false' }} }">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            {{-- Filter Bar --}}
            <div class="mb-8 overflow-hidden bg-white shadow-sm sm:rounded-3xl p-6">
                <form action="{{ route('viajes.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                    <div>
                        <x-input-label for="search" :value="__('Buscar Paquete')" />
                        <x-text-input id="search" name="search" type="text" class="mt-1 block w-full" :value="request('search')" placeholder="Nombre o destino..." />
                    </div>
                    <div>
                        <x-input-label for="destino_id" :value="__('Destino')" />
                        <select name="destino_id" id="destino_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Cualquier destino</option>
                            @foreach($destinos as $dest)
                                <option value="{{ $dest->id }}" {{ request('destino_id') == $dest->id ? 'selected' : '' }}>{{ $dest->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <x-input-label for="max_price" :value="__('Precio Máximo')" />
                        <x-text-input id="max_price" name="max_price" type="number" class="mt-1 block w-full" :value="request('max_price')" placeholder="Monto máximo..." />
                    </div>
                    <div class="flex gap-2">
                        <x-primary-button class="flex-1 justify-center">
                            {{ __('Buscar') }}
                        </x-primary-button>
                        @if(request()->anyFilled(['search', 'destino_id', 'max_price']))
                            <a href="{{ route('viajes.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (session('success') && !session('reservacion_id'))
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
                            <div class="flex flex-col overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm transition-all duration-300 hover:shadow-xl group">
                                @php
                                    $imagenes = json_decode($viaje->destino->imagen, true) ?? [];
                                    $primeraImagen = !empty($imagenes) ? asset('storage/' . $imagenes[0]) : 'https://via.placeholder.com/400x250?text=' . urlencode($viaje->destino->nombre);
                                @endphp
                                <div class="relative h-64 overflow-hidden">
                                    <img src="{{ $primeraImagen }}" alt="{{ $viaje->nombre }}" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110">
                                    <div class="absolute top-4 right-4 rounded-full bg-white/95 px-3 py-1 text-[10px] font-black text-gray-900 shadow-sm uppercase">
                                        {{ $viaje->destino->pais }}
                                    </div>
                                    <div class="absolute bottom-4 left-4">
                                        <span class="rounded-lg bg-indigo-600 px-3 py-1.5 text-xs font-bold text-white shadow-lg">
                                            {{ $viaje->transporte->tipo }}
                                        </span>
                                    </div>
                                </div>

                                <div class="flex flex-1 flex-col p-6">
                                    <h3 class="mb-3 text-2xl font-black text-gray-900 leading-tight">{{ $viaje->nombre }}</h3>
                                    
                                    <div class="mb-6 space-y-3 text-sm text-gray-500 font-medium">
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

                                    <div class="mt-auto flex items-center justify-between border-t border-gray-100 pt-5">
                                        <div class="flex flex-col">
                                            <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Total por persona</span>
                                            <span class="text-3xl font-black text-indigo-600">${{ number_format($viaje->precio_total, 0) }}</span>
                                        </div>
                                        
                                        @if($viaje->reservaciones()->count() < $viaje->capacidad)
                                            <form action="{{ route('reservaciones.store') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="viaje_id" value="{{ $viaje->id }}">
                                                <button type="submit" class="rounded-xl bg-gray-900 px-5 py-3 text-xs font-black text-white shadow-xl shadow-gray-200 transition-all hover:bg-black active:scale-95 uppercase tracking-widest">
                                                    Reservar
                                                </button>
                                            </form>
                                        @else
                                            <span class="rounded-xl bg-gray-100 px-5 py-3 text-xs font-black text-gray-400 uppercase tracking-widest">Agotado</span>
                                        @endif
                                    </div>

                                    @can('admin')
                                        <div class="mt-4 flex space-x-3 pt-4 border-t border-gray-50">
                                            <a href="{{ route('viajes.edit', $viaje) }}" class="text-[10px] font-black text-indigo-600 hover:underline uppercase">Editar</a>
                                            <form action="{{ route('viajes.destroy', $viaje) }}" method="POST" onsubmit="return confirm('¿Eliminar este paquete?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-[10px] font-black text-red-600 hover:underline uppercase">Eliminar</button>
                                            </form>
                                        </div>
                                    @endcan
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full py-24 text-center">
                                <p class="text-xl text-gray-500">No se encontraron paquetes que coincidan con tu búsqueda.</p>
                                <a href="{{ route('viajes.index') }}" class="mt-4 inline-block text-indigo-600 font-bold underline text-lg">Ver todos los paquetes</a>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Success Modal -->
        <div 
            x-show="showBookingModal" 
            class="fixed inset-0 z-[100] flex items-center justify-center p-4 overflow-x-hidden overflow-y-auto"
            style="display: none;"
        >
            <div 
                x-show="showBookingModal"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 bg-slate-900/80 backdrop-blur-md transition-opacity"
                @click="showBookingModal = false"
            ></div>

            <div 
                x-show="showBookingModal"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                x-transition:leave-end="opacity-0 scale-95 translate-y-4"
                class="relative w-full max-w-lg bg-white rounded-[2.5rem] shadow-2xl overflow-hidden transform transition-all"
            >
                <div class="p-8 sm:p-12 text-center">
                    <div class="mx-auto flex items-center justify-center h-24 w-24 rounded-full bg-green-100 mb-8 animate-bounce">
                        <svg class="h-12 w-12 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    
                    <h3 class="text-4xl font-black text-gray-900 mb-4 leading-tight">
                        ¡Reserva Realizada!
                    </h3>
                    
                    <p class="text-xl text-gray-600 mb-10 leading-relaxed">
                        {{ session('success') }}
                    </p>

                    <div class="space-y-4">
                        @if(session('reservacion_id'))
                            <a href="{{ route('reservaciones.show', session('reservacion_id')) }}" class="block w-full rounded-2xl bg-indigo-600 px-8 py-5 text-xl font-bold text-white shadow-xl shadow-indigo-200 transition-all hover:bg-indigo-700 active:scale-[0.98]">
                                Ver detalles de mi viaje
                            </a>
                        @endif
                        
                        <button type="button" @click="showBookingModal = false" class="block w-full rounded-2xl bg-gray-100 px-8 py-4 text-lg font-bold text-gray-700 transition-all hover:bg-gray-200">
                            Cerrar
                        </button>
                    </div>
                </div>
                
                <div class="bg-indigo-600 h-2 w-full"></div>
            </div>
        </div>
    </div>
</x-app-layout>
