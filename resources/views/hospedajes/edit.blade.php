<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Hospedaje - Viajes</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="grain-overlay relative overflow-x-hidden">
    <x-header />

    <main class="relative z-10 mx-auto max-w-3xl px-4 pb-12 sm:px-6 lg:px-8">
        <section class="mb-8 mt-2 rounded-3xl border border-white/70 bg-white/55 px-6 py-8 shadow-[0_14px_40px_rgba(15,111,121,0.15)] backdrop-blur-sm reveal-up">
            <span class="soft-chip">Edición</span>
            <h1 class="font-display mt-4 text-4xl leading-tight text-slate-900 sm:text-5xl">Actualizar hospedaje</h1>
            <p class="mt-3 text-slate-700">Modifica los detalles de <strong>{{ $hospedaje->nombre }}</strong>.</p>
        </section>

        <section class="elevated-panel reveal-up rounded-3xl p-6 sm:p-7" style="animation-delay: 80ms;">
            @if ($errors->any())
                <div class="mb-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700" role="alert">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('hospedajes.update', $hospedaje->id) }}" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label for="nombre" class="mb-1 block text-sm font-semibold text-slate-700">Nombre del hospedaje</label>
                        <input type="text" id="nombre" name="nombre" required value="{{ old('nombre', $hospedaje->nombre) }}" class="w-full rounded-xl border border-slate-300 bg-white/90 px-3 py-2.5 focus:border-[var(--brand-teal)] focus:outline-none">
                    </div>
                    <div>
                        <label for="direccion" class="mb-1 block text-sm font-semibold text-slate-700">Dirección</label>
                        <input type="text" id="direccion" name="direccion" required value="{{ old('direccion', $hospedaje->direccion) }}" class="w-full rounded-xl border border-slate-300 bg-white/90 px-3 py-2.5 focus:border-[var(--brand-teal)] focus:outline-none">
                    </div>
                    <div>
                        <label for="capacidad" class="mb-1 block text-sm font-semibold text-slate-700">Capacidad (personas)</label>
                        <input type="number" id="capacidad" name="capacidad" required min="1" value="{{ old('capacidad', $hospedaje->capacidad) }}" class="w-full rounded-xl border border-slate-300 bg-white/90 px-3 py-2.5 focus:border-[var(--brand-teal)] focus:outline-none">
                    </div>
                    <div>
                        <label for="tipo" class="mb-1 block text-sm font-semibold text-slate-700">Tipo (Hotel, Depto, etc.)</label>
                        <input type="text" id="tipo" name="tipo" required value="{{ old('tipo', $hospedaje->tipo) }}" class="w-full rounded-xl border border-slate-300 bg-white/90 px-3 py-2.5 focus:border-[var(--brand-teal)] focus:outline-none">
                    </div>
                </div>

                <div>
                    <label for="imagen" class="mb-1 block text-sm font-semibold text-slate-700">Imágenes (dejar vacío para mantener las actuales)</label>
                    @if($hospedaje->imagen)
                        <div class="mb-4 grid grid-cols-5 gap-2">
                            @if(is_array($hospedaje->imagen))
                                @foreach($hospedaje->imagen as $img)
                                    <img src="{{ asset('storage/' . $img) }}" alt="Actual" class="h-16 w-16 rounded-lg object-cover">
                                @endforeach
                            @else
                                <img src="{{ asset('storage/' . $hospedaje->imagen) }}" alt="Actual" class="h-16 w-16 rounded-lg object-cover">
                            @endif
                        </div>
                    @endif
                    <input type="file" id="imagen" name="imagen[]" multiple accept="image/*" class="w-full rounded-xl border border-slate-300 bg-white/90 px-3 py-2.5 text-sm text-slate-600 file:mr-3 file:rounded-lg file:border-0 file:bg-[var(--brand-coral)] file:px-3 file:py-2 file:font-semibold file:text-white hover:file:opacity-90">
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="submit" class="accent-button flex-1">Actualizar cambios</button>
                    <a href="{{ route('hospedajes.index') }}" class="flex-1 rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-center font-semibold text-slate-700 transition hover:bg-slate-50">Cancelar</a>
                </div>
            </form>
        </section>
    </main>

    @livewireScripts
</body>
</html>
