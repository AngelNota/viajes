<header class="relative z-20 px-4 py-4 sm:px-6">
	<div class="elevated-panel mx-auto flex max-w-7xl items-center justify-between rounded-2xl px-4 py-3 sm:px-6">
		<div class="flex items-center gap-3">
			<button
				type="button"
				onclick="Livewire.dispatch('toggleSidebar')"
				class="outline-button md:hidden"
				aria-label="Abrir menu lateral"
			>
				Menu
			</button>
			<a href="{{ url('/') }}" class="flex items-center gap-3">
				<span class="flex h-10 w-10 items-center justify-center rounded-xl bg-[var(--brand-coral)] text-sm font-extrabold text-white shadow-md">VJ</span>
				<div>
					<p class="font-display text-xl leading-none">Viajes Atelier</p>
					<p class="text-xs uppercase tracking-[0.18em] text-slate-500">Explorador creativo</p>
				</div>
			</a>
		</div>

		<nav class="hidden items-center gap-2 md:flex">
			<a href="{{ route('dashboard') }}" class="outline-button">Dashboard</a>
			<a href="{{ route('destinos.index') }}" class="outline-button">Destinos</a>
            @can('admin')
                <a href="{{ route('users.index') }}" class="outline-button">Usuarios</a>
            @endcan
			@auth
				<form method="POST" action="{{ route('logout') }}">
					@csrf
					<button type="submit" class="accent-button">Cerrar sesion</button>
				</form>
			@else
				<a href="{{ route('login') }}" class="accent-button">Iniciar sesion</a>
			@endauth
		</nav>
	</div>
</header>

@livewire('sidebar-menu')
