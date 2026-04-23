<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $hospedaje->nombre }} - Detalles</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="grain-overlay relative overflow-x-hidden">
    <x-header />

    <main class="relative z-10 mx-auto max-w-5xl px-4 pb-12 sm:px-6 lg:px-8">
        <div class="mb-6 mt-4">
            <a href="{{ route('hospedajes.index') }}" class="inline-flex items-center text-sm font-semibold text-slate-600 hover:text-[var(--brand-teal)]">
                <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Volver al listado
            </a>
        </div>

        <article class="elevated-panel reveal-up rounded-3xl overflow-hidden shadow-2xl">
            @if($hospedaje->imagen && is_array($hospedaje->imagen))
                <div class="grid grid-cols-1 md:grid-cols-2 gap-1 bg-slate-100">
                    @foreach(array_slice($hospedaje->imagen, 0, 4) as $index => $img)
                        <div class="{{ $loop->first && count($hospedaje->imagen) > 1 ? 'md:row-span-2' : '' }} h-64 md:h-auto overflow-hidden">
                            <img src="{{ asset('storage/' . $img) }}" alt="Imagen {{ $index + 1 }}" class="h-full w-full object-cover transition duration-500 hover:scale-105">
                        </div>
                    @endforeach
                </div>
            @elseif($hospedaje->imagen)
                <div class="h-96 overflow-hidden">
                    <img src="{{ asset('storage/' . $hospedaje->imagen) }}" alt="{{ $hospedaje->nombre }}" class="h-full w-full object-cover">
                </div>
            @endif

            <div class="p-8 sm:p-10">
                <div class="flex flex-wrap items-start justify-between gap-4">
                    <div>
                        <span class="soft-chip mb-3">{{ $hospedaje->tipo }}</span>
                        <h1 class="font-display text-4xl text-slate-900 sm:text-5xl">{{ $hospedaje->nombre }}</h1>
                        <p class="mt-4 flex items-center text-lg text-slate-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-5 w-5 text-[var(--brand-teal)]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            {{ $hospedaje->direccion }}
                        </p>
                    </div>
                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-5 text-center">
                        <p class="text-sm uppercase tracking-widest text-slate-500">Capacidad</p>
                        <p class="font-display text-4xl text-[var(--brand-coral)]">{{ $hospedaje->capacidad }}</p>
                        <p class="text-sm text-slate-600 font-semibold">personas</p>
                    </div>
                </div>

                <div class="mt-10 grid gap-8 md:grid-cols-3 border-t border-slate-100 pt-10">
                    <div class="md:col-span-2">
                        <h2 class="font-display text-2xl mb-4">Sobre este alojamiento</h2>
                        <p class="text-slate-700 leading-relaxed">
                            Este {{ strtolower($hospedaje->tipo) }} ofrece una estancia confortable en {{ $hospedaje->direccion }}. 
                            Ideal para grupos de hasta {{ $hospedaje->capacidad }} personas que buscan calidad y diseño en su viaje.
                        </p>
                    </div>
                    <div>
                        <h2 class="font-display text-2xl mb-4">Acciones</h2>
                        <div class="flex flex-col gap-3">
                            <a href="{{ route('hospedajes.edit', $hospedaje->id) }}" class="outline-button w-full justify-center">
                                Editar información
                            </a>
                            <form action="{{ route('hospedajes.destroy', $hospedaje->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este hospedaje?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full rounded-xl border border-red-200 bg-red-50 px-4 py-2.5 font-semibold text-red-600 transition hover:bg-red-100">
                                    Eliminar registro
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </article>
    </main>

    @livewireScripts
</body>
</html>
