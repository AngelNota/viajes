<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospedajes - Viajes</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="grain-overlay relative overflow-x-hidden">
    <x-header />

    <main class="relative z-10 mx-auto max-w-7xl px-4 pb-12 sm:px-6 lg:px-8">
        <section class="mb-8 mt-2 rounded-3xl border border-white/70 bg-white/55 px-6 py-8 shadow-[0_14px_40px_rgba(15,111,121,0.15)] backdrop-blur-sm reveal-up">
            <span class="soft-chip">Panel de Alojamiento</span>
            <h1 class="font-display mt-4 text-4xl leading-tight text-slate-900 sm:text-5xl">Gestiona tus hospedajes con estilo.</h1>
            <p class="mt-3 max-w-3xl text-slate-700">Registra hoteles, hostales, departamentos y más para tener siempre el lugar ideal donde descansar.</p>
        </section>

        <div class="grid gap-8 lg:grid-cols-[1.1fr_0.9fr]">
            <section class="elevated-panel reveal-up rounded-3xl p-6 sm:p-7" style="animation-delay: 80ms;">
                <h2 class="font-display text-3xl">Nuevo hospedaje</h2>
                <p class="mt-2 text-sm text-slate-600">Completa la información del alojamiento y sube fotos de referencia.</p>

                @if ($errors->any())
                    <div class="mt-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700" role="alert">
                        {{ $errors->first() }}
                    </div>
                @endif

                @if (session('success'))
                    <div class="mt-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700" role="status">
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('hospedajes.store') }}" enctype="multipart/form-data" class="mt-6 space-y-4">
                    @csrf

                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <label for="nombre" class="mb-1 block text-sm font-semibold text-slate-700">Nombre del hospedaje</label>
                            <input type="text" id="nombre" name="nombre" required value="{{ old('nombre') }}" class="w-full rounded-xl border border-slate-300 bg-white/90 px-3 py-2.5 focus:border-[var(--brand-teal)] focus:outline-none">
                        </div>
                        <div>
                            <label for="direccion" class="mb-1 block text-sm font-semibold text-slate-700">Dirección</label>
                            <input type="text" id="direccion" name="direccion" required value="{{ old('direccion') }}" class="w-full rounded-xl border border-slate-300 bg-white/90 px-3 py-2.5 focus:border-[var(--brand-teal)] focus:outline-none">
                        </div>
                        <div>
                            <label for="capacidad" class="mb-1 block text-sm font-semibold text-slate-700">Capacidad (personas)</label>
                            <input type="number" id="capacidad" name="capacidad" required min="1" value="{{ old('capacidad') }}" class="w-full rounded-xl border border-slate-300 bg-white/90 px-3 py-2.5 focus:border-[var(--brand-teal)] focus:outline-none">
                        </div>
                        <div>
                            <label for="tipo" class="mb-1 block text-sm font-semibold text-slate-700">Tipo (Hotel, Depto, etc.)</label>
                            <input type="text" id="tipo" name="tipo" required value="{{ old('tipo') }}" class="w-full rounded-xl border border-slate-300 bg-white/90 px-3 py-2.5 focus:border-[var(--brand-teal)] focus:outline-none">
                        </div>
                    </div>

                    <div>
                        <label for="imagen" class="mb-1 block text-sm font-semibold text-slate-700">Imágenes</label>
                        <input type="file" id="imagen" name="imagen[]" multiple accept="image/*" class="w-full rounded-xl border border-slate-300 bg-white/90 px-3 py-2.5 text-sm text-slate-600 file:mr-3 file:rounded-lg file:border-0 file:bg-[var(--brand-coral)] file:px-3 file:py-2 file:font-semibold file:text-white hover:file:opacity-90">
                    </div>

                    <button type="submit" class="accent-button w-full sm:w-auto">Agregar hospedaje</button>
                </form>
            </section>

            <section class="reveal-up" style="animation-delay: 140ms;">
                <div class="elevated-panel rounded-3xl p-6">
                    <div class="mb-4 flex items-center justify-between">
                        <h2 class="font-display text-3xl">Listado</h2>
                        <span class="soft-chip">{{ $hospedajes->count() }} registros</span>
                    </div>

                    @if($hospedajes->isEmpty())
                        <div class="rounded-2xl border border-dashed border-slate-300/90 bg-white/70 p-6 text-sm text-slate-600">
                            Aún no hay hospedajes registrados. Agrega el primero para comenzar.
                        </div>
                    @else
                        <div class="grid gap-4">
                            @foreach($hospedajes as $hospedaje)
                                <article class="flex flex-col gap-4 rounded-2xl border border-white/70 bg-white/80 p-4 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                                    <div class="flex gap-4">
                                        <div class="flex-1">
                                            <div class="flex items-start justify-between">
                                                <div>
                                                    <h3 class="font-display text-2xl text-slate-900">{{ $hospedaje->nombre }}</h3>
                                                    <p class="text-sm font-semibold text-[var(--brand-teal)]">{{ $hospedaje->tipo }} • {{ $hospedaje->capacidad }} pers.</p>
                                                </div>
                                                <div class="flex gap-2">
                                                    <a href="{{ route('hospedajes.show', $hospedaje->id) }}" class="rounded-lg bg-blue-50 p-2 text-blue-600 hover:bg-blue-100" title="Ver detalles">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                                        </svg>
                                                    </a>
                                                    <a href="{{ route('hospedajes.edit', $hospedaje->id) }}" class="rounded-lg bg-slate-100 p-2 text-slate-600 hover:bg-slate-200">

                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                                        </svg>
                                                    </a>
                                                    <form action="{{ route('hospedajes.destroy', $hospedaje->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este hospedaje?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="rounded-lg bg-red-50 p-2 text-red-600 hover:bg-red-100">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                            <p class="mt-2 text-sm text-slate-600">{{ $hospedaje->direccion }}</p>
                                        </div>
                                    </div>

                                    @if($hospedaje->imagen && is_array($hospedaje->imagen))
                                        <div class="grid grid-cols-4 gap-2">
                                            @foreach($hospedaje->imagen as $img)
                                                <div class="h-20 overflow-hidden rounded-lg">
                                                    <img src="{{ asset('storage/' . $img) }}" alt="{{ $hospedaje->nombre }}" class="h-full w-full object-cover">
                                                </div>
                                            @endforeach
                                        </div>
                                    @elseif($hospedaje->imagen)
                                        <div class="h-20 w-20 overflow-hidden rounded-lg">
                                            <img src="{{ asset('storage/' . $hospedaje->imagen) }}" alt="{{ $hospedaje->nombre }}" class="h-full w-full object-cover">
                                        </div>
                                    @endif
                                </article>
                            @endforeach
                        </div>
                    @endif
                </div>
            </section>
        </div>
    </main>

    @livewireScripts
</body>
</html>
