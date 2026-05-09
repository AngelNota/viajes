<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Detalles del Hospedaje') }}: {{ $hospedaje->nombre }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('hospedajes.index') }}" class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-700 shadow-sm transition duration-150 ease-in-out hover:bg-gray-50">
                    {{ __('Volver') }}
                </a>
                @can('admin')
                    <a href="{{ route('hospedajes.edit', $hospedaje) }}" class="inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-indigo-700">
                        {{ __('Editar') }}
                    </a>
                @endcan
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-xl sm:rounded-3xl">
                @php $imagenes = json_decode($hospedaje->imagen, true) ?? []; @endphp
                @if(!empty($imagenes))
                    <div class="h-96 w-full overflow-hidden">
                        <img src="{{ asset('storage/' . $imagenes[0]) }}" alt="{{ $hospedaje->nombre }}" class="h-full w-full object-cover">
                    </div>
                @endif

                <div class="p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <h3 class="text-3xl font-black text-gray-900">{{ $hospedaje->nombre }}</h3>
                            <p class="mt-2 text-lg text-indigo-600 font-bold">{{ $hospedaje->destino->nombre }}, {{ $hospedaje->destino->pais }}</p>
                            
                            <div class="mt-6 space-y-4">
                                <div class="flex items-center">
                                    <span class="rounded-full bg-blue-100 px-3 py-1 text-sm font-bold text-blue-800">
                                        {{ $hospedaje->categoria }}
                                    </span>
                                </div>
                                
                                <p class="text-gray-600 leading-relaxed">
                                    Este alojamiento de categoría {{ strtolower($hospedaje->categoria) }} se encuentra ubicado en el hermoso destino de {{ $hospedaje->destino->nombre }}.
                                </p>
                            </div>
                        </div>

                        <div class="rounded-3xl bg-gray-50 p-8 shadow-inner">
                            <h4 class="text-sm font-bold uppercase tracking-widest text-gray-400 mb-6">Detalles de Estancia</h4>
                            
                            <div class="space-y-6">
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-600">Precio por noche</span>
                                    <span class="text-3xl font-black text-gray-900">${{ number_format($hospedaje->precio_noche, 2) }}</span>
                                </div>
                                
                                <div class="flex items-center justify-between border-t border-gray-200 pt-6">
                                    <span class="text-gray-600">Habitaciones disponibles</span>
                                    <span class="text-2xl font-bold text-indigo-600">{{ $hospedaje->habitaciones_disp }}</span>
                                </div>
                            </div>

                            <div class="mt-10">
                                @if($hospedaje->habitaciones_disp > 0)
                                    <div class="rounded-xl bg-green-100 p-4 text-center">
                                        <p class="text-sm font-bold text-green-800">DISPONIBILIDAD INMEDIATA</p>
                                    </div>
                                @else
                                    <div class="rounded-xl bg-red-100 p-4 text-center">
                                        <p class="text-sm font-bold text-red-800">AGOTADO</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    @if(count($imagenes) > 1)
                        <div class="mt-12">
                            <h4 class="text-sm font-bold uppercase tracking-widest text-gray-400 mb-6">Galería de Fotos</h4>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                @foreach(array_slice($imagenes, 1) as $img)
                                    <div class="h-48 rounded-2xl overflow-hidden shadow-md">
                                        <img src="{{ asset('storage/' . $img) }}" alt="Foto" class="h-full w-full object-cover">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
