<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Usuario - Viajes Atelier</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="grain-overlay relative overflow-x-hidden">
    <a href="#contenido" class="sr-only focus:not-sr-only focus:absolute focus:left-4 focus:top-4 focus:z-50 focus:rounded-lg focus:bg-white focus:px-4 focus:py-2">Saltar al contenido</a>

    <x-header />

    <main id="contenido" class="relative z-10 mx-auto max-w-3xl px-4 pb-12 pt-8 sm:px-6">
        <section class="elevated-panel reveal-up rounded-3xl p-8" style="animation-delay: 80ms;">
            <div class="mb-8">
                <span class="soft-chip mb-4">Administracion</span>
                <h1 class="font-display text-4xl text-slate-900">Agregar nuevo usuario</h1>
                <p class="mt-2 text-slate-600">Completa los datos para registrar un nuevo integrante en la plataforma.</p>
            </div>

            <form action="{{ route('users.store') }}" method="POST" class="space-y-6">
                @csrf
                
                <div class="grid gap-6 sm:grid-cols-2">
                    <div class="space-y-2">
                        <label for="name" class="block text-sm font-semibold text-slate-700">Nombre completo</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
                            class="w-full rounded-xl border border-slate-200 bg-white/70 px-4 py-3 text-slate-900 shadow-sm transition focus:border-[var(--brand-teal)] focus:ring-2 focus:ring-[var(--brand-teal)]/20">
                        @error('name') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-2">
                        <label for="email" class="block text-sm font-semibold text-slate-700">Correo electronico</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required
                            class="w-full rounded-xl border border-slate-200 bg-white/70 px-4 py-3 text-slate-900 shadow-sm transition focus:border-[var(--brand-teal)] focus:ring-2 focus:ring-[var(--brand-teal)]/20">
                        @error('email') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid gap-6 sm:grid-cols-2">
                    <div class="space-y-2">
                        <label for="password" class="block text-sm font-semibold text-slate-700">Contraseña</label>
                        <input type="password" name="password" id="password" required
                            class="w-full rounded-xl border border-slate-200 bg-white/70 px-4 py-3 text-slate-900 shadow-sm transition focus:border-[var(--brand-teal)] focus:ring-2 focus:ring-[var(--brand-teal)]/20">
                        @error('password') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-2">
                        <label for="password_confirmation" class="block text-sm font-semibold text-slate-700">Confirmar contraseña</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" required
                            class="w-full rounded-xl border border-slate-200 bg-white/70 px-4 py-3 text-slate-900 shadow-sm transition focus:border-[var(--brand-teal)] focus:ring-2 focus:ring-[var(--brand-teal)]/20">
                    </div>
                </div>

                <div class="space-y-2">
                    <label for="role" class="block text-sm font-semibold text-slate-700">Rol del usuario</label>
                    <div class="grid grid-cols-2 gap-4">
                        <label class="relative flex cursor-pointer items-center justify-center rounded-xl border border-slate-200 bg-white/70 px-4 py-3 text-slate-900 shadow-sm transition hover:border-[var(--brand-teal)] has-[:checked]:border-[var(--brand-teal)] has-[:checked]:bg-[var(--brand-teal)]/5">
                            <input type="radio" name="role" value="user" {{ old('role', 'user') === 'user' ? 'checked' : '' }} class="sr-only">
                            <span class="text-sm font-medium">Usuario</span>
                        </label>
                        <label class="relative flex cursor-pointer items-center justify-center rounded-xl border border-slate-200 bg-white/70 px-4 py-3 text-slate-900 shadow-sm transition hover:border-[var(--brand-teal)] has-[:checked]:border-[var(--brand-teal)] has-[:checked]:bg-[var(--brand-teal)]/5">
                            <input type="radio" name="role" value="admin" {{ old('role') === 'admin' ? 'checked' : '' }} class="sr-only">
                            <span class="text-sm font-medium">Administrador</span>
                        </label>
                    </div>
                    @error('role') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                <div class="flex items-center justify-end gap-4 pt-6">
                    <a href="{{ route('dashboard') }}" class="outline-button px-8">Cancelar</a>
                    <button type="submit" class="accent-button px-8">Registrar Usuario</button>
                </div>
            </form>
        </section>
    </main>

    <div class="pointer-events-none fixed -right-16 top-20 h-64 w-64 rounded-full bg-[var(--brand-mint)]/30 blur-3xl"></div>
    <div class="pointer-events-none fixed -left-16 bottom-10 h-72 w-72 rounded-full bg-[var(--brand-coral)]/30 blur-3xl"></div>

    @livewireScripts
</body>
</html>
