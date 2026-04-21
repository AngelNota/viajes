<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Destinos - Viajes</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="grain-overlay relative overflow-x-hidden">
    <x-header />

    <main class="relative z-10 mx-auto max-w-7xl px-4 pb-12 sm:px-6 lg:px-8">
        <section class="mb-8 mt-2 rounded-3xl border border-white/70 bg-white/55 px-6 py-8 shadow-[0_14px_40px_rgba(15,111,121,0.15)] backdrop-blur-sm reveal-up">
            <span class="soft-chip">Panel Curatorial</span>
            <h1 class="font-display mt-4 text-4xl leading-tight text-slate-900 sm:text-5xl">Gestiona destinos con un look de revista de viaje.</h1>
            <p class="mt-3 max-w-3xl text-slate-700">Crea fichas de lugares con imagen, ciudad y direccion, y manten una biblioteca visual para tus siguientes rutas.</p>
        </section>

        <div class="grid gap-8 lg:grid-cols-[1.1fr_0.9fr]">
            <section class="elevated-panel reveal-up rounded-3xl p-6 sm:p-7" style="animation-delay: 80ms;">
                <h2 class="font-display text-3xl">Nuevo destino</h2>
                <p class="mt-2 text-sm text-slate-600">Agrega informacion del lugar y una imagen para identificarlo visualmente.</p>

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

                <form method="POST" action="{{ route('destinos.store') }}" enctype="multipart/form-data" class="mt-6 space-y-4">
                    @csrf

                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <label for="nombre" class="mb-1 block text-sm font-semibold text-slate-700">Nombre del destino</label>
                            <input type="text" id="nombre" name="nombre" required value="{{ old('nombre') }}" class="w-full rounded-xl border border-slate-300 bg-white/90 px-3 py-2.5 focus:border-[var(--brand-teal)] focus:outline-none">
                        </div>
                        <div>
                            <label for="ciudad" class="mb-1 block text-sm font-semibold text-slate-700">Ciudad</label>
                            <input type="text" id="ciudad" name="ciudad" required value="{{ old('ciudad') }}" class="w-full rounded-xl border border-slate-300 bg-white/90 px-3 py-2.5 focus:border-[var(--brand-teal)] focus:outline-none">
                        </div>
                        <div>
                            <label for="pais" class="mb-1 block text-sm font-semibold text-slate-700">Pais</label>
                            <input type="text" id="pais" name="pais" required value="{{ old('pais') }}" class="w-full rounded-xl border border-slate-300 bg-white/90 px-3 py-2.5 focus:border-[var(--brand-teal)] focus:outline-none">
                        </div>
                        <div>
                            <label for="direccion" class="mb-1 block text-sm font-semibold text-slate-700">Direccion</label>
                            <input type="text" id="direccion" name="direccion" value="{{ old('direccion') }}" class="w-full rounded-xl border border-slate-300 bg-white/90 px-3 py-2.5 focus:border-[var(--brand-teal)] focus:outline-none">
                        </div>
                    </div>

                    <div>
                        <label for="imagen" class="mb-1 block text-sm font-semibold text-slate-700">Imagen</label>
                        <input type="file" id="imagen" name="imagen" accept="image/*" class="w-full rounded-xl border border-slate-300 bg-white/90 px-3 py-2.5 text-sm text-slate-600 file:mr-3 file:rounded-lg file:border-0 file:bg-[var(--brand-coral)] file:px-3 file:py-2 file:font-semibold file:text-white hover:file:opacity-90">
                    </div>

                    <button type="submit" class="accent-button w-full sm:w-auto">Agregar destino</button>
                </form>
            </section>

            <section class="reveal-up" style="animation-delay: 140ms;">
                <div class="elevated-panel rounded-3xl p-6">
                    <div class="mb-4 flex items-center justify-between">
                        <h2 class="font-display text-3xl">Biblioteca</h2>
                        <span class="soft-chip">{{ $destinos->count() }} registros</span>
                    </div>

                    @if($destinos->isEmpty())
                        <div class="rounded-2xl border border-dashed border-slate-300/90 bg-white/70 p-6 text-sm text-slate-600">
                            Aun no hay destinos cargados. Agrega el primero para iniciar tu coleccion.
                        </div>
                    @else
                        <div class="grid gap-4 sm:grid-cols-2">
                            @foreach($destinos as $destino)
                                @php
                                    $imagenes = [];
                                    if (!empty($destino->imagen)) {
                                        $decoded = json_decode($destino->imagen, true);
                                        if (is_array($decoded)) {
                                            $imagenes = $decoded;
                                        } else {
                                            $imagenes = [$destino->imagen];
                                        }
                                    }
                                @endphp
                                <article class="rounded-2xl border border-white/70 bg-white/80 p-4 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                                    <h3 class="font-display text-2xl text-slate-900">{{ $destino->nombre }}</h3>
                                    <p class="mt-1 text-sm font-semibold text-[var(--brand-teal)]">{{ $destino->ciudad }}, {{ $destino->pais }}</p>
                                    <p class="mt-2 text-sm text-slate-600">{{ $destino->direccion ?: 'Sin direccion especificada' }}</p>

                                    @if(!empty($imagenes))
                                        <div class="mt-3 grid grid-cols-3 gap-2">
                                            @foreach($imagenes as $imagen)
                                                <img src="{{ asset('storage/' . $imagen) }}" alt="Imagen de {{ $destino->nombre }}" class="h-16 w-full rounded-lg object-cover">
                                            @endforeach
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