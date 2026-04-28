<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Viajes - Viajes Atelier</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="grain-overlay relative overflow-x-hidden">
    <x-header />

    <main class="relative z-10 mx-auto max-w-7xl px-4 pb-12 sm:px-6 lg:px-8">
        <section class="mb-8 mt-2 flex flex-col items-start justify-between gap-6 rounded-3xl border border-white/70 bg-white/55 px-6 py-8 shadow-[0_14px_40px_rgba(15,111,121,0.15)] backdrop-blur-sm reveal-up sm:flex-row sm:items-center">
            <div>
                <span class="soft-chip">Exploración</span>
                <h1 class="font-display mt-4 text-4xl leading-tight text-slate-900 sm:text-5xl">Gestión de Viajes</h1>
                <p class="mt-2 text-slate-700">Administra las expediciones y aventuras programadas.</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('viajes.create') }}" class="accent-button flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus-circle"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="16"/><line x1="8" x2="16" y1="12" y2="12"/></svg>
                    Nuevo Viaje
                </a>
            </div>
        </section>

        @if(session('success'))
            <div class="mb-6 rounded-2xl border border-green-200 bg-green-50 p-4 text-green-700 shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @forelse($viajes as $viaje)
                <article class="elevated-panel reveal-up group overflow-hidden rounded-3xl transition-all hover:shadow-2xl">
                    <div class="relative h-48 w-full overflow-hidden bg-slate-200">
                        @php $imagen = is_array($viaje->destino->imagen) ? $viaje->destino->imagen[0] : null; @endphp
                        @if($imagen)
                            <img src="{{ asset('storage/' . $imagen) }}" alt="{{ $viaje->destino->nombre }}" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110">
                        @else
                            <div class="flex h-full w-full items-center justify-center bg-slate-100 text-slate-400">
                                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map-pin"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                            </div>
                        @endif
                        <div class="absolute right-4 top-4">
                            <span class="rounded-full bg-white/90 px-3 py-1 text-xs font-bold text-[var(--brand-teal)] backdrop-blur-md">
                                {{ $viaje->tipo_viaje }}
                            </span>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="mb-4 flex items-center justify-between">
                            <h2 class="font-display text-2xl text-slate-900">{{ $viaje->destino->nombre }}</h2>
                            <span class="text-lg font-bold text-[var(--brand-teal)]">${{ number_format($viaje->total, 2) }}</span>
                        </div>
                        
                        <div class="mb-6 space-y-2 text-sm text-slate-600">
                            <p class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                {{ $viaje->user->name }}
                            </p>
                            <p class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                                {{ \Carbon\Carbon::parse($viaje->fecha_inicio)->translatedFormat('d M') }} - {{ \Carbon\Carbon::parse($viaje->fecha_fin)->translatedFormat('d M Y') }}
                            </p>
                            <p class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                                {{ $viaje->num_personas }} personas
                            </p>
                        </div>

                        <div class="flex gap-2">
                            <a href="{{ route('viajes.edit', $viaje) }}" class="flex-1 rounded-xl border border-slate-200 py-2 text-center text-sm font-semibold text-slate-600 transition-colors hover:bg-slate-50">
                                Editar
                            </a>
                            <form action="{{ route('viajes.destroy', $viaje) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('¿Estás seguro?')" class="rounded-xl border border-red-100 bg-red-50 px-3 py-2 text-red-600 transition-colors hover:bg-red-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash-2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </article>
            @empty
                <div class="col-span-full py-20 text-center">
                    <p class="text-slate-500">No hay viajes registrados aún.</p>
                </div>
            @endforelse
        </div>
    </main>

    <div class="pointer-events-none fixed -right-16 top-20 h-64 w-64 rounded-full bg-[var(--brand-mint)]/30 blur-3xl"></div>
    <div class="pointer-events-none fixed -left-16 bottom-10 h-72 w-72 rounded-full bg-[var(--brand-coral)]/30 blur-3xl"></div>
</body>
</html>
