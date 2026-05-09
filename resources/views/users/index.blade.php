<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col items-start justify-between gap-6 sm:flex-row sm:items-center">
            <div>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    {{ __('Gestión de Usuarios') }}
                </h2>
                <p class="mt-1 text-sm text-gray-600">Visualiza, registra, importa y exporta los integrantes de la plataforma.</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('users.export') }}" class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-700 shadow-sm transition duration-150 ease-in-out hover:bg-gray-50">
                    Excel
                </a>
                <a href="{{ route('users.export.pdf') }}" class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-700 shadow-sm transition duration-150 ease-in-out hover:bg-gray-50">
                    PDF
                </a>
                <a href="{{ route('users.create') }}" class="inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-indigo-700">
                    {{ __('Nuevo Usuario') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        @if(session('success'))
            <div class="mb-6 rounded-lg bg-green-100 p-4 text-sm text-green-700">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid gap-8 lg:grid-cols-[1fr_350px]">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-gray-500">
                            <thead class="bg-gray-50 text-xs font-semibold uppercase text-gray-700">
                                <tr>
                                    <th class="px-6 py-3">Usuario</th>
                                    <th class="px-6 py-3">Email</th>
                                    <th class="px-6 py-3">Rol</th>
                                    <th class="px-6 py-3">Registro</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($users as $user)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 font-medium text-gray-900">{{ $user->name }}</td>
                                        <td class="px-6 py-4">{{ $user->email }}</td>
                                        <td class="px-6 py-4">
                                            @if($user->role === 'admin')
                                                <span class="rounded-full bg-orange-100 px-2 py-1 text-xs font-bold text-orange-800">ADMIN</span>
                                            @else
                                                <span class="rounded-full bg-blue-100 px-2 py-1 text-xs font-bold text-blue-800">USUARIO</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">{{ $user->created_at->format('d/m/Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <aside class="space-y-6">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Importar Usuarios</h3>
                        <form action="{{ route('users.import') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="space-y-4">
                                <input type="file" name="file" accept=".xlsx, .xls, .csv" required class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                <x-primary-button class="w-full justify-center">
                                    Procesar Importación
                                </x-primary-button>
                            </div>
                        </form>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</x-app-layout>
