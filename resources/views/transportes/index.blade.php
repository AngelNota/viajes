<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Gestión de Transportes') }}
            </h2>
            @can('admin')
                <a href="{{ route('transportes.create') }}" class="inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-indigo-700 focus:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 active:bg-indigo-900">
                    {{ __('Nuevo Transporte') }}
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

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-gray-500">
                            <thead class="bg-gray-50 text-xs font-semibold uppercase text-gray-700">
                                <tr>
                                    <th class="px-6 py-3">Tipo</th>
                                    <th class="px-6 py-3">Origen</th>
                                    <th class="px-6 py-3">Destino</th>
                                    <th class="px-6 py-3">Capacidad</th>
                                    <th class="px-6 py-3">Precio</th>
                                    <th class="px-6 py-3">Fecha Salida</th>
                                    @can('admin')
                                        <th class="px-6 py-3 text-right">Acciones</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                @forelse($transportes as $transporte)
                                    <tr class="hover:bg-gray-50">
                                        <td class="whitespace-nowrap px-6 py-4">
                                            <span class="rounded-full bg-gray-100 px-2 py-1 text-xs font-semibold text-gray-800 uppercase">
                                                {{ $transporte->tipo }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">{{ $transporte->origen }}</td>
                                        <td class="px-6 py-4">{{ $transporte->destino }}</td>
                                        <td class="px-6 py-4">{{ $transporte->capacidad }} plazas</td>
                                        <td class="px-6 py-4">${{ number_format($transporte->precio, 2) }}</td>
                                        <td class="px-6 py-4 text-xs">{{ \Carbon\Carbon::parse($transporte->fecha_salida)->format('d/m/Y H:i') }}</td>
                                        @can('admin')
                                            <td class="whitespace-nowrap px-6 py-4 text-right">
                                                <div class="flex justify-end space-x-2">
                                                    <a href="{{ route('transportes.edit', $transporte) }}" class="text-indigo-600 hover:text-indigo-900">Editar</a>
                                                    <form action="{{ route('transportes.destroy', $transporte) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este transporte?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-900">Eliminar</button>
                                                    </form>
                                                </div>
                                            </td>
                                        @endcan
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="py-12 text-center text-gray-500">
                                            No hay transportes registrados aún.
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
