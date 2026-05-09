<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Viajes Atelier') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="grain-overlay relative overflow-x-hidden bg-slate-50">
    <x-header />

    @if (isset($header))
        <header class="bg-white shadow-sm border-b border-slate-100 mb-6">
            <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
    @endif

    <main id="contenido" class="relative z-10 mx-auto max-w-7xl px-4 pb-12 sm:px-6 lg:px-8">
        {{ $slot }}
    </main>

    <div class="pointer-events-none fixed -right-16 top-20 h-64 w-64 rounded-full bg-[var(--brand-mint)]/30 blur-3xl"></div>
    <div class="pointer-events-none fixed -left-16 bottom-10 h-72 w-72 rounded-full bg-[var(--brand-coral)]/30 blur-3xl"></div>

    @livewireScripts
</body>
</html>
