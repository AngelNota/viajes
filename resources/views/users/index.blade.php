<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios - Viajes Atelier</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="grain-overlay relative overflow-x-hidden">
    <a href="#contenido" class="sr-only focus:not-sr-only focus:absolute focus:left-4 focus:top-4 focus:z-50 focus:rounded-lg focus:bg-white focus:px-4 focus:py-2">Saltar al contenido</a>

    <x-header />

    <main id="contenido" class="relative z-10 mx-auto max-w-7xl px-4 pb-12 sm:px-6 lg:px-8">
        <section class="mb-8 mt-2 flex flex-col items-start justify-between gap-6 rounded-3xl border border-white/70 bg-white/55 px-6 py-8 shadow-[0_14px_40px_rgba(15,111,121,0.15)] backdrop-blur-sm reveal-up sm:flex-row sm:items-center">
            <div>
                <span class="soft-chip">Administracion</span>
                <h1 class="font-display mt-4 text-4xl leading-tight text-slate-900 sm:text-5xl">Gestion de Usuarios</h1>
                <p class="mt-2 text-slate-700">Visualiza, registra, importa y exporta los integrantes de la plataforma.</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('users.export') }}" class="outline-button flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-spreadsheet"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/><path d="M8 13h2"/><path d="M14 13h2"/><path d="M8 17h2"/><path d="M14 17h2"/></svg>
                    Excel
                </a>
                <a href="{{ route('users.export.pdf') }}" class="outline-button flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-text"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/><path d="M9 15h6"/><path d="M9 11h6"/><path d="M9 19h1"/></svg>
                    PDF
                </a>
                <a href="{{ route('users.create') }}" class="accent-button flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-plus"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" x2="19" y1="8" y2="14"/><line x1="22" x2="16" y1="11" y2="11"/></svg>
                    Nuevo Usuario
                </a>
            </div>
        </section>

        @if(session('success'))
            <div class="mb-6 rounded-2xl border border-green-200 bg-green-50 p-4 text-green-700 shadow-sm reveal-up">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-4 text-red-700 shadow-sm reveal-up">
                <ul class="list-inside list-disc">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid gap-8 lg:grid-cols-[1fr_350px]">
            <section class="elevated-panel reveal-up overflow-hidden rounded-3xl shadow-xl" style="animation-delay: 150ms;">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-slate-200 bg-slate-50/50">
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">Usuario</th>
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">Email</th>
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">Rol</th>
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">Registro</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($users as $user)
                                <tr class="transition-colors hover:bg-white/40">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-[var(--brand-mint)]/20 text-sm font-bold text-[var(--brand-teal)]">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                            <span class="font-semibold text-slate-900">{{ $user->name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-slate-600">{{ $user->email }}</td>
                                    <td class="px-6 py-4">
                                        @if($user->role === 'admin')
                                            <span class="inline-flex rounded-full bg-orange-100 px-2.5 py-0.5 text-xs font-medium text-orange-700">Administrador</span>
                                        @else
                                            <span class="inline-flex rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-medium text-slate-700">Usuario</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm text-slate-500">
                                        {{ $user->created_at->translatedFormat('d M Y') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                @if($users->isEmpty())
                    <div class="py-12 text-center">
                        <p class="text-slate-500">No hay usuarios registrados aparte de ti.</p>
                    </div>
                @endif
            </section>

            <aside class="space-y-6">
                <section class="elevated-panel reveal-up rounded-3xl p-6" style="animation-delay: 200ms;">
                    <h2 class="font-display text-2xl mb-4">Importar Usuarios</h2>
                    <p class="text-sm text-slate-600 mb-6">Sube un archivo Excel (.xlsx, .xls) o CSV con las siguientes columnas en la primera fila:</p>
                    
                    <div class="bg-slate-50 rounded-xl p-4 mb-6 border border-slate-200">
                        <p class="text-xs font-mono text-slate-700">nombre | email | rol | password</p>
                    </div>

                    <form action="{{ route('users.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="space-y-4">
                            <label class="block">
                                <span class="sr-only">Seleccionar archivo</span>
                                <input type="file" name="file" accept=".xlsx, .xls, .csv" required
                                    class="block w-full text-sm text-slate-500
                                    file:mr-4 file:py-2 file:px-4
                                    file:rounded-full file:border-0
                                    file:text-sm file:font-semibold
                                    file:bg-[var(--brand-teal)]/10 file:text-[var(--brand-teal)]
                                    hover:file:bg-[var(--brand-teal)]/20 transition-all cursor-pointer">
                            </label>
                            <button type="submit" class="accent-button w-full">Procesar Importación</button>
                        </div>
                    </form>
                </section>

                <div class="elevated-panel rounded-3xl p-6 bg-[var(--brand-mint)]/5 border-none">
                    <h3 class="font-bold text-slate-900 mb-2">💡 Nota de Seguridad</h3>
                    <p class="text-sm text-slate-600">Si dejas la columna "password" vacía, se asignará <span class="font-mono bg-white px-1 border border-slate-200 rounded">12345678</span> por defecto. El rol por defecto es <span class="font-mono bg-white px-1 border border-slate-200 rounded">user</span>.</p>
                </div>
            </aside>
        </div>
    </main>

    <div class="pointer-events-none fixed -right-16 top-20 h-64 w-64 rounded-full bg-[var(--brand-mint)]/30 blur-3xl"></div>
    <div class="pointer-events-none fixed -left-16 bottom-10 h-72 w-72 rounded-full bg-[var(--brand-coral)]/30 blur-3xl"></div>

    @livewireScripts
</body>
</html>
