<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Detalles del Destino') }}: {{ $destino->nombre }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('destinos.index') }}" class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-700 shadow-sm transition duration-150 ease-in-out hover:bg-gray-50">
                    {{ __('Volver al catálogo') }}
                </a>
                @can('admin')
                    <a href="{{ route('destinos.edit', $destino) }}" class="inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-indigo-700">
                        {{ __('Editar') }}
                    </a>
                @endcan
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <article class="overflow-hidden bg-white shadow-xl sm:rounded-[2.5rem]">
                @php $imagenes = json_decode($destino->imagen, true) ?? []; @endphp
                
                @if(!empty($imagenes))
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2 bg-gray-100 h-[30rem]">
                        <div class="h-full overflow-hidden">
                            <img src="{{ asset('storage/' . $imagenes[0]) }}" alt="{{ $destino->nombre }}" class="h-full w-full object-cover">
                        </div>
                        @if(count($imagenes) > 1)
                            <div class="grid grid-cols-2 grid-rows-2 gap-2 h-full">
                                @foreach(array_slice($imagenes, 1, 4) as $img)
                                    <div class="overflow-hidden">
                                        <img src="{{ asset('storage/' . $img) }}" alt="Vista del destino" class="h-full w-full object-cover">
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endif

                <div class="p-8 sm:p-12">
                    <div class="flex flex-col lg:flex-row gap-12">
                        <div class="lg:w-2/3">
                            <div class="mb-6">
                                <span class="soft-chip mb-4">{{ $destino->pais }}</span>
                                <h1 class="font-display text-5xl font-black text-gray-900 leading-tight">
                                    {{ $destino->nombre }}
                                </h1>
                            </div>

                            <div class="prose prose-indigo max-w-none text-gray-600 leading-relaxed text-lg">
                                {{ $destino->descripcion ?? 'Este destino aún no cuenta con una descripción detallada, pero te aseguramos que es una experiencia inolvidable.' }}
                            </div>

                            <div class="mt-12 grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div class="rounded-3xl border border-gray-100 bg-gray-50 p-6">
                                    <h4 class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-2">Estado del Destino</h4>
                                    @if($destino->activo)
                                        <span class="inline-flex items-center text-green-600 font-bold">
                                            <svg class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" /></svg>
                                            DISPONIBLE PARA VIAJES
                                        </span>
                                    @else
                                        <span class="inline-flex items-center text-red-600 font-bold">
                                            <svg class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12" /></svg>
                                            TEMPORALMENTE INACTIVO
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="lg:w-1/3">
                            <div class="sticky top-8 rounded-[2rem] bg-indigo-600 p-8 text-white shadow-2xl shadow-indigo-200 text-center">
                                <p class="text-sm font-bold uppercase tracking-widest opacity-80 mb-2">Precio Base</p>
                                <div class="flex items-center justify-center gap-1">
                                    <span class="text-2xl font-bold">$</span>
                                    <span class="text-6xl font-black">{{ number_format($destino->precio_base, 0) }}</span>
                                </div>
                                <p class="mt-4 text-xs font-medium italic opacity-70">
                                    *Este es el costo base por persona, sujeto a cambios según el paquete seleccionado.
                                </p>
                                
                                <div class="mt-8">
                                    <a href="{{ route('viajes.index', ['search' => $destino->nombre]) }}" class="block w-full rounded-2xl bg-white px-6 py-4 text-lg font-bold text-indigo-600 transition-all hover:bg-gray-100 active:scale-95">
                                        Explorar Paquetes
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </article>
        </div>
    </div>
</article>
</x-app-layout>
