<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Detalles del Transporte') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('transportes.index') }}" class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-700 shadow-sm transition duration-150 ease-in-out hover:bg-gray-50">
                    {{ __('Volver') }}
                </a>
                @can('admin')
                    <a href="{{ route('transportes.edit', $transporte) }}" class="inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-indigo-700">
                        {{ __('Editar') }}
                    </a>
                @endcan
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-4xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-xl sm:rounded-3xl">
                <div class="p-8">
                    <div class="mb-8 border-b border-gray-100 pb-8">
                        <span class="inline-flex rounded-full bg-indigo-100 px-3 py-1 text-sm font-bold uppercase text-indigo-700">
                            {{ $transporte->tipo }}
                        </span>
                        <h1 class="font-display mt-4 text-4xl font-black text-gray-900">
                            {{ $transporte->origen }} &rarr; {{ $transporte->destino }}
                        </h1>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-6">
                            <div>
                                <h3 class="text-sm font-bold uppercase tracking-wider text-gray-400">Capacidad Total</h3>
                                <p class="text-2xl font-bold text-gray-800">{{ $transporte->capacidad }} Plazas</p>
                            </div>

                            <div>
                                <h3 class="text-sm font-bold uppercase tracking-wider text-gray-400">Fecha y Hora de Salida</h3>
                                <p class="text-2xl font-bold text-gray-800">
                                    {{ \Carbon\Carbon::parse($transporte->fecha_salida)->format('d/m/Y H:i') }}
                                </p>
                            </div>
                        </div>

                        <div class="rounded-3xl bg-indigo-50 p-8 text-center shadow-inner">
                            <h3 class="text-sm font-bold uppercase tracking-wider text-indigo-400 mb-2">Precio por Persona</h3>
                            <p class="text-5xl font-black text-indigo-600">${{ number_format($transporte->price ?? $transporte->precio, 2) }}</p>
                            <p class="mt-4 text-xs text-indigo-500 font-medium italic">Sujeto a cambios según disponibilidad.</p>
                        </div>
                    </div>

                    @can('admin')
                        <div class="mt-12 border-t border-gray-100 pt-8">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">Acciones de Administración</h3>
                            <form action="{{ route('transportes.destroy', $transporte) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este registro de transporte?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center rounded-xl bg-red-100 px-4 py-2 text-sm font-bold text-red-600 transition hover:bg-red-200">
                                    ELIMINAR REGISTRO
                                </button>
                            </form>
                        </div>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
