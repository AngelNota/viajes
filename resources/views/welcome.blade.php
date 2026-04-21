<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Viajes Atelier') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="grain-overlay relative overflow-x-hidden">
    <main class="relative z-10 mx-auto flex min-h-screen max-w-7xl flex-col px-4 py-6 sm:px-6 lg:px-8">
        <header class="elevated-panel reveal-up flex items-center justify-between rounded-2xl px-4 py-3 sm:px-6">
            <a href="{{ url('/') }}" class="flex items-center gap-3">
                <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-[var(--brand-coral)] text-sm font-extrabold text-white shadow-md">VJ</span>
                <div>
                    <p class="font-display text-xl leading-none">Viajes Atelier</p>
                    <p class="text-xs uppercase tracking-[0.2em] text-slate-500">Coleccion Visual</p>
                </div>
            </a>

            <nav class="flex items-center gap-2">
                @auth
                    <a href="{{ route('destinos.index') }}" class="outline-button hidden sm:inline-flex">Destinos</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="accent-button">Cerrar sesion</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="accent-button">Iniciar sesion</a>
                @endauth
            </nav>
        </header>

        <section class="mt-8 grid flex-1 items-center gap-10 lg:grid-cols-[1.12fr_0.88fr]">
            <div class="reveal-up">
                <span class="soft-chip">Diseno intencional</span>
                <h1 class="font-display mt-5 text-5xl leading-tight text-slate-900 sm:text-6xl lg:text-7xl">
                    Tu estudio para documentar destinos extraordinarios.
                </h1>
                <p class="mt-5 max-w-xl text-lg text-slate-700">
                    Convierte datos de viaje en piezas visuales: agrega ciudades, paises e imagenes en una interfaz elegante y expresiva.
                </p>

                <div class="mt-7 flex flex-wrap items-center gap-3">
                    @auth
                        <a href="{{ route('destinos.index') }}" class="accent-button">Ir al panel</a>
                    @else
                        <a href="{{ route('login') }}" class="accent-button">Comenzar ahora</a>
                    @endauth
                    <a href="{{ url('/') }}#detalle" class="outline-button">Explorar diseno</a>
                </div>
            </div>

            <div class="reveal-up" style="animation-delay: 120ms;">
                <div class="elevated-panel rounded-3xl p-5 sm:p-6">
                    <p class="text-xs uppercase tracking-[0.17em] text-slate-500">Vista previa</p>
                    <h2 class="font-display mt-3 text-3xl">Bitacora de Rutas</h2>
                    <div class="mt-5 grid gap-3 sm:grid-cols-2">
                        <article class="rounded-2xl border border-white/80 bg-white/80 p-4 shadow-sm float-slow">
                            <p class="text-xs uppercase tracking-[0.12em] text-slate-500">01</p>
                            <p class="font-display mt-2 text-2xl">Curar destinos</p>
                            <p class="mt-2 text-sm text-slate-600">Organiza cada lugar con contexto y estilo visual.</p>
                        </article>
                        <article class="rounded-2xl border border-white/80 bg-white/80 p-4 shadow-sm sm:translate-y-6">
                            <p class="text-xs uppercase tracking-[0.12em] text-slate-500">02</p>
                            <p class="font-display mt-2 text-2xl">Inspirar decisiones</p>
                            <p class="mt-2 text-sm text-slate-600">Convierte informacion util en colecciones memorables.</p>
                        </article>
                    </div>
                </div>
            </div>
        </section>

        <section id="detalle" class="mt-8 grid gap-4 pb-4 sm:grid-cols-3">
            <article class="elevated-panel reveal-up rounded-2xl p-4" style="animation-delay: 180ms;">
                <p class="soft-chip inline-flex">Tipografia</p>
                <h3 class="font-display mt-3 text-2xl">Editorial y moderna</h3>
                <p class="mt-2 text-sm text-slate-600">Combinacion de display serif y sans contemporanea para una presencia unica.</p>
            </article>
            <article class="elevated-panel reveal-up rounded-2xl p-4" style="animation-delay: 240ms;">
                <p class="soft-chip inline-flex">Color</p>
                <h3 class="font-display mt-3 text-2xl">Paleta calida-marina</h3>
                <p class="mt-2 text-sm text-slate-600">Coral, teal y menta sobre fondos crema para evitar el look generico.</p>
            </article>
            <article class="elevated-panel reveal-up rounded-2xl p-4" style="animation-delay: 300ms;">
                <p class="soft-chip inline-flex">Movimiento</p>
                <h3 class="font-display mt-3 text-2xl">Animacion con proposito</h3>
                <p class="mt-2 text-sm text-slate-600">Reveals escalonados y flotacion suave, respetando reduced motion.</p>
            </article>
        </section>
    </main>

    <div class="pointer-events-none fixed -right-16 top-20 h-64 w-64 rounded-full bg-[var(--brand-mint)]/30 blur-3xl"></div>
    <div class="pointer-events-none fixed -left-16 bottom-8 h-72 w-72 rounded-full bg-[var(--brand-coral)]/30 blur-3xl"></div>
</body>
</html>
