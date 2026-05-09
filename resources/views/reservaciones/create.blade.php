<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Nueva Reservación Manual') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-3xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('reservaciones.store') }}" class="space-y-6">
                        @csrf

                        <div>
                            <x-input-label for="viaje_id" :value="__('Seleccionar Paquete de Viaje')" />
                            <select id="viaje_id" name="viaje_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                <option value="">Selecciona un paquete</option>
                                @foreach($viajes as $viaje)
                                    <option value="{{ $viaje->id }}" {{ old('viaje_id') == $viaje->id ? 'selected' : '' }}>
                                        {{ $viaje->nombre }} - ${{ number_format($viaje->precio_total, 2) }} ({{ $viaje->capacidad - $viaje->reservaciones()->count() }} disp.)
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('viaje_id')" />
                        </div>

                        <div class="flex items-center justify-end space-x-3">
                            <a href="{{ route('reservaciones.index') }}" class="text-sm text-gray-600 hover:text-gray-900">{{ __('Cancelar') }}</a>
                            <x-primary-button>
                                {{ __('Confirmar Reservación') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
