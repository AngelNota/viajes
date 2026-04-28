<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Viaje - Viajes Atelier</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="grain-overlay relative overflow-x-hidden">
    <x-header />

    <main class="relative z-10 mx-auto max-w-3xl px-4 pb-12 sm:px-6 lg:px-8">
        <section class="mb-8 mt-2 rounded-3xl border border-white/70 bg-white/55 px-6 py-8 shadow-xl backdrop-blur-sm reveal-up">
            <div class="mb-8">
                <span class="soft-chip">Planificación</span>
                <h1 class="font-display mt-4 text-4xl text-slate-900">Programar Nuevo Viaje</h1>
                <p class="mt-2 text-slate-700">Completa los detalles para la próxima aventura.</p>
            </div>

            <form action="{{ route('viajes.store') }}" method="POST" class="space-y-6">
                @csrf
                
                <div class="grid gap-6 sm:grid-cols-2">
                    <div class="space-y-2">
                        <label for="user_id" class="text-sm font-semibold text-slate-700">Viajero / Cliente</label>
                        <select name="user_id" id="user_id" required class="w-full rounded-2xl border-slate-200 bg-white/50 px-4 py-3 focus:border-[var(--brand-teal)] focus:ring-[var(--brand-teal)]">
                            <option value="">Selecciona un usuario</option>
                            @foreach($usuarios as $usuario)
                                <option value="{{ $usuario->id }}" {{ old('user_id') == $usuario->id ? 'selected' : '' }}>
                                    {{ $usuario->name }} ({{ $usuario->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('user_id') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-2">
                        <label for="tipo_viaje" class="text-sm font-semibold text-slate-700">Tipo de Viaje</label>
                        <select name="tipo_viaje" id="tipo_viaje" required class="w-full rounded-2xl border-slate-200 bg-white/50 px-4 py-3 focus:border-[var(--brand-teal)] focus:ring-[var(--brand-teal)]">
                            <option value="Turismo" {{ old('tipo_viaje') == 'Turismo' ? 'selected' : '' }}>Turismo</option>
                            <option value="Negocios" {{ old('tipo_viaje') == 'Negocios' ? 'selected' : '' }}>Negocios</option>
                            <option value="Aventura" {{ old('tipo_viaje') == 'Aventura' ? 'selected' : '' }}>Aventura</option>
                            <option value="Relajación" {{ old('tipo_viaje') == 'Relajación' ? 'selected' : '' }}>Relajación</option>
                        </select>
                    </div>
                </div>

                <div class="grid gap-6 sm:grid-cols-2">
                    <div class="space-y-2">
                        <label for="destino_id" class="text-sm font-semibold text-slate-700">Destino</label>
                        <select name="destino_id" id="destino_id" required class="w-full rounded-2xl border-slate-200 bg-white/50 px-4 py-3 focus:border-[var(--brand-teal)] focus:ring-[var(--brand-teal)]">
                            <option value="">Selecciona un destino</option>
                            @foreach($destinos as $destino)
                                <option value="{{ $destino->id }}" {{ old('destino_id') == $destino->id ? 'selected' : '' }}>
                                    {{ $destino->nombre }} - {{ $destino->ciudad }}
                                </option>
                            @endforeach
                        </select>
                        @error('destino_id') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-2">
                        <label for="hospedaje_id" class="text-sm font-semibold text-slate-700">Hospedaje</label>
                        <select name="hospedaje_id" id="hospedaje_id" required class="w-full rounded-2xl border-slate-200 bg-white/50 px-4 py-3 focus:border-[var(--brand-teal)] focus:ring-[var(--brand-teal)]">
                            <option value="">Selecciona un hospedaje</option>
                            @foreach($hospedajes as $hospedaje)
                                <option value="{{ $hospedaje->id }}" {{ old('hospedaje_id') == $hospedaje->id ? 'selected' : '' }}>
                                    {{ $hospedaje->nombre }} (Cap: {{ $hospedaje->capacidad }})
                                </option>
                            @endforeach
                        </select>
                        @error('hospedaje_id') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid gap-6 sm:grid-cols-3">
                    <div class="space-y-2">
                        <label for="fecha_inicio" class="text-sm font-semibold text-slate-700">Fecha Inicio</label>
                        <input type="date" name="fecha_inicio" id="fecha_inicio" required value="{{ old('fecha_inicio') }}" class="w-full rounded-2xl border-slate-200 bg-white/50 px-4 py-3">
                        @error('fecha_inicio') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-2">
                        <label for="fecha_fin" class="text-sm font-semibold text-slate-700">Fecha Fin</label>
                        <input type="date" name="fecha_fin" id="fecha_fin" required value="{{ old('fecha_fin') }}" class="w-full rounded-2xl border-slate-200 bg-white/50 px-4 py-3">
                        @error('fecha_fin') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-2">
                        <label for="num_personas" class="text-sm font-semibold text-slate-700">Nº Personas</label>
                        <input type="number" name="num_personas" id="num_personas" min="1" required value="{{ old('num_personas', 1) }}" class="w-full rounded-2xl border-slate-200 bg-white/50 px-4 py-3">
                        @error('num_personas') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="space-y-2">
                    <label for="total" class="text-sm font-semibold text-slate-700">Costo Total (MXN)</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 font-bold text-slate-400">$</span>
                        <input type="number" step="0.01" name="total" id="total" required value="{{ old('total') }}" placeholder="0.00" class="w-full rounded-2xl border-slate-200 bg-white/50 pl-8 pr-4 py-3 text-lg font-bold text-[var(--brand-teal)]">
                    </div>
                    @error('total') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                <div class="flex gap-3 pt-4">
                    <a href="{{ route('viajes.index') }}" class="flex-1 rounded-2xl border border-slate-200 py-4 text-center font-bold text-slate-600 transition-colors hover:bg-white/50">
                        Cancelar
                    </a>
                    <button type="submit" class="accent-button flex-1 py-4 text-lg">
                        Guardar Viaje
                    </button>
                </div>
            </form>
        </section>
    </main>

    <div class="pointer-events-none fixed -right-16 top-20 h-64 w-64 rounded-full bg-[var(--brand-mint)]/30 blur-3xl"></div>
    <div class="pointer-events-none fixed -left-16 bottom-10 h-72 w-72 rounded-full bg-[var(--brand-coral)]/30 blur-3xl"></div>
</body>
</html>
