@php
    // Livewire sidebar menu view
@endphp

@if($open)
    <div class="fixed inset-0 z-30 bg-slate-900/45 backdrop-blur-sm" wire:click="toggle"></div>
@endif

<aside class="fixed inset-y-0 left-0 z-40 w-72 transform transition-transform duration-300 {{ $open ? 'translate-x-0' : '-translate-x-full' }}" aria-label="Menu lateral">
    <div class="elevated-panel m-3 h-[calc(100%-1.5rem)] rounded-2xl p-5">
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h3 class="font-display text-2xl">Menu</h3>
                <p class="text-xs uppercase tracking-[0.17em] text-slate-500">Navegacion</p>
            </div>
            <button wire:click="toggle" class="outline-button">Cerrar</button>
        </div>

        <nav>
            <ul class="space-y-2">
                <li>
                    <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'accent-button w-full' : 'outline-button w-full' }}">Dashboard</a>
                </li>
                <li>
                    <a href="{{ route('destinos.index') }}" class="{{ request()->routeIs('destinos.*') ? 'accent-button w-full' : 'outline-button w-full' }}">Destinos</a>
                </li>
                <li>
                    <a href="{{ route('hospedajes.index') }}" class="{{ request()->routeIs('hospedajes.*') ? 'accent-button w-full' : 'outline-button w-full' }}">Hospedajes</a>
                </li>
                @can('admin')
                <li>
                    <a href="{{ route('users.index') }}" class="{{ request()->routeIs('users.*') ? 'accent-button w-full' : 'outline-button w-full' }}">Usuarios</a>
                </li>
                @endcan
                <li>
                    <a href="{{ route('viajes.index') }}" class="{{ request()->routeIs('viajes.*') ? 'accent-button w-full' : 'outline-button w-full' }}">Viajes</a>
                </li>
                <li><span class="outline-button w-full justify-start opacity-70">Subtotales (proximamente)</span></li>
            </ul>
        </nav>

        <div class="mt-8 rounded-xl border border-slate-300/60 bg-white/70 p-4 text-sm text-slate-600">
            Tip rapido: crea destinos con fotos para construir tu bitacora visual de viajes.
        </div>
    </div>
</aside>
