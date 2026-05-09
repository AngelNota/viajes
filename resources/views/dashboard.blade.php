<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Viajes Atelier</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="grain-overlay relative overflow-x-hidden">
    <a href="#contenido" class="sr-only focus:not-sr-only focus:absolute focus:left-4 focus:top-4 focus:z-50 focus:rounded-lg focus:bg-white focus:px-4 focus:py-2">Saltar al contenido</a>

    <x-header />

    <main id="contenido" class="relative z-10 mx-auto max-w-7xl px-4 pb-12 sm:px-6 lg:px-8">
        <section class="mb-8 mt-2 rounded-3xl border border-white/70 bg-white/55 px-6 py-8 shadow-[0_14px_40px_rgba(15,111,121,0.15)] backdrop-blur-sm reveal-up">
            <span class="soft-chip">Dashboard</span>
            <h1 class="font-display mt-4 text-4xl leading-tight text-slate-900 sm:text-5xl">Bienvenido, {{ auth()->user()->name }}.</h1>
            <p class="mt-3 max-w-3xl text-slate-700">Este es tu centro de control: revisa actividad, rutas próximas y distribución de destinos en segundos.</p>
        </section>

        <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4" aria-label="Metricas principales">
            <article class="elevated-panel reveal-up rounded-2xl p-5" style="animation-delay: 80ms;">
                <p class="text-xs uppercase tracking-[0.16em] text-slate-500">Destinos</p>
                <p class="font-display mt-2 text-4xl">{{ $totalDestinos }}</p>
                <p class="mt-2 text-sm text-slate-600">Lugares disponibles en la coleccion.</p>
            </article>
            <article class="elevated-panel reveal-up rounded-2xl p-5" style="animation-delay: 130ms;">
                <p class="text-xs uppercase tracking-[0.16em] text-slate-500">Hospedajes</p>
                <p class="font-display mt-2 text-4xl">{{ $totalHospedajes }}</p>
                <p class="mt-2 text-sm text-slate-600">Opciones registradas para tus viajes.</p>
            </article>
            <article class="elevated-panel reveal-up rounded-2xl p-5" style="animation-delay: 180ms;">
                <p class="text-xs uppercase tracking-[0.16em] text-slate-500">Tus viajes</p>
                <p class="font-display mt-2 text-4xl">{{ $totalViajes }}</p>
                <p class="mt-2 text-sm text-slate-600">Viajes creados con tu cuenta.</p>
            </article>
            <article class="elevated-panel reveal-up rounded-2xl p-5" style="animation-delay: 230ms;">
                <p class="text-xs uppercase tracking-[0.16em] text-slate-500">Inversion total</p>
                <p class="font-display mt-2 text-4xl">${{ number_format($gastoTotal, 2) }}</p>
                <p class="mt-2 text-sm text-slate-600">Suma total de tus presupuestos.</p>
            </article>
        </section>

        <section class="mt-8 grid gap-8 lg:grid-cols-[1.05fr_0.95fr]">
            <article class="elevated-panel reveal-up rounded-3xl p-6" style="animation-delay: 290ms;" aria-labelledby="proximos-viajes-titulo">
                <div class="mb-5 flex items-center justify-between gap-3">
                    <h2 id="proximos-viajes-titulo" class="font-display text-3xl">Proximos viajes</h2>
                    <span class="soft-chip">{{ $viajesMes }} este mes</span>
                </div>

                @if ($proximosViajes->isEmpty())
                    <p class="rounded-xl border border-dashed border-slate-300 bg-white/70 p-4 text-sm text-slate-600">No tienes viajes proximos. Reserva uno para verlo aqui.</p>
                @else
                    <ul class="space-y-3">
                        @foreach ($proximosViajes as $reservacion)
                            <li class="rounded-xl border border-white/75 bg-white/80 p-4 shadow-sm">
                                <div class="flex items-center justify-between">
                                    <p class="font-display text-2xl text-slate-900">{{ $reservacion->viaje->nombre }}</p>
                                    <span class="text-xs font-bold uppercase text-slate-400">#{{ $reservacion->folio }}</span>
                                </div>
                                <p class="mt-1 text-sm font-semibold text-[var(--brand-teal)]">{{ $reservacion->viaje->destino->nombre }}</p>
                                <p class="mt-1 text-sm text-slate-600">
                                    {{ \Illuminate\Support\Carbon::parse($reservacion->viaje->fecha_inicio)->translatedFormat('d M Y') }}
                                    -
                                    {{ \Illuminate\Support\Carbon::parse($reservacion->viaje->fecha_fin)->translatedFormat('d M Y') }}
                                </p>
                                <p class="mt-2 text-sm font-bold text-slate-900">Monto pagado: ${{ number_format((float) $reservacion->monto_pagado, 2) }}</p>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </article>

            <article class="elevated-panel reveal-up rounded-3xl p-6" style="animation-delay: 340ms;" aria-labelledby="paises-top-titulo">
                <h2 id="paises-top-titulo" class="font-display text-3xl">Paises con mas destinos</h2>
                <p class="mt-2 text-sm text-slate-600">Distribucion actual de tu catalogo de lugares.</p>

                @if($topPaises->isEmpty())
                    <p class="mt-4 rounded-xl border border-dashed border-slate-300 bg-white/70 p-4 text-sm text-slate-600">Aun no hay datos para mostrar en esta metrica.</p>
                @else
                    @php $maxPais = max(1, (int) $topPaises->max('total')); @endphp
                    <ul class="mt-5 space-y-3">
                        @foreach($topPaises as $pais)
                            @php $ancho = (int) round(($pais->total / $maxPais) * 100); @endphp
                            <li>
                                <div class="mb-1 flex items-center justify-between text-sm">
                                    <span class="font-semibold text-slate-700">{{ $pais->pais }}</span>
                                    <span class="text-slate-500">{{ $pais->total }}</span>
                                </div>
                                <div class="h-3 rounded-full bg-slate-200/90" role="img" aria-label="{{ $pais->pais }} con {{ $pais->total }} destinos">
                                    <div class="h-3 rounded-full bg-gradient-to-r from-[var(--brand-coral)] to-[var(--brand-teal)]" style="width: {{ $ancho }}%;"></div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </article>
        </section>

        <section class="mt-8 grid gap-8 lg:grid-cols-2">
            <article class="elevated-panel reveal-up rounded-3xl p-6" style="animation-delay: 390ms;" aria-labelledby="destinos-recientes-titulo">
                <div class="mb-4 flex items-center justify-between gap-3">
                    <h2 id="destinos-recientes-titulo" class="font-display text-3xl">Destinos recientes</h2>
                    <a href="{{ route('destinos.index') }}" class="outline-button">Ver todos</a>
                </div>

                @if($destinosRecientes->isEmpty())
                    <p class="rounded-xl border border-dashed border-slate-300 bg-white/70 p-4 text-sm text-slate-600">Aun no hay destinos creados.</p>
                @else
                    <div class="grid gap-4 sm:grid-cols-2">
                        @foreach($destinosRecientes->take(4) as $destino)
                            <article class="rounded-2xl border border-white/80 bg-white/85 p-4 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                                <h3 class="font-display text-xl text-slate-900">{{ $destino->nombre }}</h3>
                                <p class="mt-1 text-xs font-semibold text-[var(--brand-teal)]">{{ $destino->ciudad }}, {{ $destino->pais }}</p>
                            </article>
                        @endforeach
                    </div>
                @endif
            </article>

            <article class="elevated-panel reveal-up rounded-3xl p-6" style="animation-delay: 440ms;" aria-labelledby="hospedajes-recientes-titulo">
                <div class="mb-4 flex items-center justify-between gap-3">
                    <h2 id="hospedajes-recientes-titulo" class="font-display text-3xl">Hospedajes recientes</h2>
                    <a href="{{ route('hospedajes.index') }}" class="outline-button">Ver todos</a>
                </div>

                @php
                    $hospedajesRecientes = \App\Models\hospedaje::latest()->limit(4)->get();
                @endphp

                @if($hospedajesRecientes->isEmpty())
                    <p class="rounded-xl border border-dashed border-slate-300 bg-white/70 p-4 text-sm text-slate-600">Aun no hay hospedajes creados.</p>
                @else
                    <div class="grid gap-4 sm:grid-cols-2">
                        @foreach($hospedajesRecientes as $hospedaje)
                            <article class="rounded-2xl border border-white/80 bg-white/85 p-4 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                                <h3 class="font-display text-xl text-slate-900">{{ $hospedaje->nombre }}</h3>
                                <p class="mt-1 text-xs font-semibold text-[var(--brand-teal)]">{{ $hospedaje->tipo }} • {{ $hospedaje->capacidad }} pers.</p>
                            </article>
                        @endforeach
                    </div>
                @endif
            </article>
        </section>
    </main>

    <div class="pointer-events-none fixed -right-16 top-20 h-64 w-64 rounded-full bg-[var(--brand-mint)]/30 blur-3xl"></div>
    <div class="pointer-events-none fixed -left-16 bottom-10 h-72 w-72 rounded-full bg-[var(--brand-coral)]/30 blur-3xl"></div>

    @livewireScripts
</body>
</html>
