<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Editar Estado de Reservación') }} #{{ $reservacion->folio }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-3xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <h3 class="text-lg font-bold">Detalles de la Compra</h3>
                        <p class="text-sm text-gray-600">Usuario: {{ $reservacion->user->name }} ({{ $reservacion->user->email }})</p>
                        <p class="text-sm text-gray-600">Paquete: {{ $reservacion->viaje->nombre }}</p>
                    </div>

                    <form method="POST" action="{{ route('reservaciones.update', $reservacion) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <x-input-label for="estado" :value="__('Estado de la Reservación')" />
                            <select id="estado" name="estado" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                <option value="pendiente" {{ old('estado', $reservacion->estado) == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                <option value="confirmado" {{ old('estado', $reservacion->estado) == 'confirmado' ? 'selected' : '' }}>Confirmado</option>
                                <option value="completado" {{ old('estado', $reservacion->estado) == 'completado' ? 'selected' : '' }}>Completado</option>
                                <option value="cancelado" {{ old('estado', $reservacion->estado) == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('estado')" />
                            <p class="mt-2 text-xs text-gray-500 italic">Nota: Cambiar a 'cancelado' devolverá automáticamente los lugares al inventario.</p>
                        </div>

                        <div class="flex items-center justify-end space-x-3">
                            <a href="{{ route('reservaciones.index') }}" class="text-sm text-gray-600 hover:text-gray-900">{{ __('Cancelar') }}</a>
                            <x-primary-button>
                                {{ __('Actualizar Estado') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
