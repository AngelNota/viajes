<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Crear Cuenta - Viajes Atelier</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="grain-overlay relative overflow-x-hidden">
    <main class="relative z-10 mx-auto flex min-h-screen max-w-6xl items-center px-4 py-8 sm:px-6">
        <section class="grid w-full gap-8 lg:grid-cols-[1.15fr_0.85fr]">
            <div class="reveal-up">
                <span class="soft-chip">Bienvenido a Viajes Atelier</span>
                <h1 class="font-display mt-5 text-5xl leading-tight text-slate-900 sm:text-6xl">
                    Crea tu cuenta y comienza a explorar.
                </h1>
                <p class="mt-5 max-w-xl text-lg text-slate-700">
                    Únete a nuestra comunidad de viajeros y gestiona tus próximas aventuras con un solo clic.
                </p>

                <div class="mt-7 grid max-w-lg gap-3 sm:grid-cols-2">
                    <article class="elevated-panel float-slow rounded-2xl p-4">
                        <p class="text-xs uppercase tracking-[0.17em] text-slate-500">Privacidad</p>
                        <p class="font-display mt-2 text-2xl">Datos Protegidos</p>
                    </article>
                    <article class="elevated-panel rounded-2xl p-4 sm:translate-y-6">
                        <p class="text-xs uppercase tracking-[0.17em] text-slate-500">Rapidez</p>
                        <p class="font-display mt-2 text-2xl">Registro Simple</p>
                    </article>
                </div>
            </div>

            <div class="elevated-panel reveal-up rounded-3xl p-6 sm:p-8" style="animation-delay: 120ms;">
                <h2 class="font-display text-4xl">Registrarse</h2>
                <p class="mt-2 text-sm text-slate-600">Ingresa tus datos para crear una nueva cuenta.</p>

                @if ($errors->any())
                    <div class="mt-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700" role="alert">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('register.store') }}" class="mt-6 space-y-4">
                    @csrf

                    <div>
                        <label for="name" class="mb-1 block text-sm font-semibold text-slate-700">Nombre Completo</label>
                        <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus class="w-full rounded-xl border border-slate-300 bg-white/90 px-3 py-2.5 focus:border-[var(--brand-teal)] focus:outline-none">
                    </div>

                    <div>
                        <label for="email" class="mb-1 block text-sm font-semibold text-slate-700">Correo Electrónico</label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" required class="w-full rounded-xl border border-slate-300 bg-white/90 px-3 py-2.5 focus:border-[var(--brand-teal)] focus:outline-none">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="password" class="mb-1 block text-sm font-semibold text-slate-700">Contraseña</label>
                            <input id="password" name="password" type="password" required class="w-full rounded-xl border border-slate-300 bg-white/90 px-3 py-2.5 focus:border-[var(--brand-teal)] focus:outline-none">
                        </div>
                        <div>
                            <label for="password_confirmation" class="mb-1 block text-sm font-semibold text-slate-700">Confirmar</label>
                            <input id="password_confirmation" name="password_confirmation" type="password" required class="w-full rounded-xl border border-slate-300 bg-white/90 px-3 py-2.5 focus:border-[var(--brand-teal)] focus:outline-none">
                        </div>
                    </div>

                    <button type="submit" class="accent-button w-full">
                        Crear Cuenta
                    </button>
                </form>

                <p class="mt-6 text-center text-sm text-slate-600">
                    ¿Ya tienes cuenta? <a href="{{ route('login') }}" class="font-bold text-indigo-600 hover:underline">Inicia sesión</a>
                </p>
                <a href="{{ url('/') }}" class="outline-button mt-4 w-full">Volver al inicio</a>
            </div>
        </section>
    </main>

    <div class="pointer-events-none fixed -right-16 top-20 h-64 w-64 rounded-full bg-[var(--brand-mint)]/30 blur-3xl"></div>
    <div class="pointer-events-none fixed -left-16 bottom-10 h-64 w-64 rounded-full bg-[var(--brand-coral)]/30 blur-3xl"></div>
</body>
</html>
