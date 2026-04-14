<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SIGOP') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;300;400;500;600;700;800;900&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    @stack('styles')
</head>
<body class="font-sans text-on-surface antialiased bg-surface">

@guest
    {{-- Login/Register: sin sidebar --}}
    <main class="min-h-screen flex items-center justify-center bg-surface">
        @yield('content')
    </main>
@else
    {{-- App autenticada: sidebar + topbar --}}

    {{-- Sidebar --}}
    <aside class="fixed left-0 top-0 h-full z-40 flex flex-col overflow-y-auto w-64 border-r-0 bg-slate-900/95 backdrop-blur-xl shadow-2xl shadow-blue-900/20 text-sm">
        {{-- Brand --}}
        <div class="px-6 py-8 flex flex-col gap-1">
            <div class="flex items-center gap-3">
                @if(file_exists(public_path('logo/logo_2.png')))
                    <img src="{{ asset('logo/logo_2.png') }}" alt="Logo" class="h-8">
                @endif
                <h1 class="text-xl font-black tracking-tighter text-white uppercase">SIGOP</h1>
            </div>
            <p class="text-slate-400 text-xs font-medium uppercase tracking-widest">Control de Producción</p>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 px-3 space-y-1">
            @php
                $currentRoute = Route::currentRouteName() ?? '';
            @endphp

            {{-- Dashboard --}}
            @role('admin')
            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center px-3 py-3 rounded-lg transition-colors duration-200
                      {{ str_contains($currentRoute, 'dashboard') ? 'text-white font-semibold bg-gradient-to-r from-blue-900 to-transparent' : 'text-slate-400 hover:text-slate-200 hover:bg-white/5' }}">
                <span class="material-symbols-outlined mr-3">dashboard</span>
                <span>Dashboard</span>
            </a>
            @endrole

            {{-- Planeación --}}
            <div x-data="{ open: {{ str_contains($currentRoute, 'planeacion') ? 'true' : 'false' }} }" class="group">
                <button @click="open = !open"
                        class="w-full flex items-center px-3 py-3 text-slate-400 hover:text-slate-200 hover:bg-white/5 transition-colors duration-200 rounded-lg">
                    <span class="material-symbols-outlined mr-3">precision_manufacturing</span>
                    <span>Planeación</span>
                    <span class="material-symbols-outlined ml-auto text-xs transition-transform" :class="open ? 'rotate-180' : ''">expand_more</span>
                </button>
                <div x-show="open" x-collapse class="mt-1 ml-9 space-y-1 border-l border-slate-700/50">
                    <a href="#" class="block px-4 py-2 text-slate-400 hover:text-slate-200 hover:bg-white/5 transition-colors text-xs">Control de fases</a>
                    <a href="#" class="block px-4 py-2 text-slate-400 hover:text-slate-200 hover:bg-white/5 transition-colors text-xs">Asignación de materiales</a>
                </div>
            </div>

            {{-- Pedidos --}}
            <div x-data="{ open: false }" class="group">
                <button @click="open = !open"
                        class="w-full flex items-center px-3 py-3 text-slate-400 hover:text-slate-200 hover:bg-white/5 transition-colors duration-200 rounded-lg">
                    <span class="material-symbols-outlined mr-3">assignment</span>
                    <span>Pedidos</span>
                    <span class="material-symbols-outlined ml-auto text-xs transition-transform" :class="open ? 'rotate-180' : ''">expand_more</span>
                </button>
                <div x-show="open" x-collapse class="mt-1 ml-9 space-y-1 border-l border-slate-700/50">
                    <a href="#" class="block px-4 py-2 text-slate-400 hover:text-slate-200 hover:bg-white/5 transition-colors text-xs">Importar Órdenes</a>
                    <a href="#" class="block px-4 py-2 text-slate-400 hover:text-slate-200 hover:bg-white/5 transition-colors text-xs">Importar Inventarios</a>
                    <a href="#" class="block px-4 py-2 text-slate-400 hover:text-slate-200 hover:bg-white/5 transition-colors text-xs">Consultar Estado</a>
                    <a href="#" class="block px-4 py-2 text-slate-400 hover:text-slate-200 hover:bg-white/5 transition-colors text-xs">Reasignación de Pedidos</a>
                </div>
            </div>

            {{-- Inventarios --}}
            <div x-data="{ open: {{ str_contains($currentRoute, 'materiales') || str_contains($currentRoute, 'bodegas') ? 'true' : 'false' }} }" class="group">
                <button @click="open = !open"
                        class="w-full flex items-center px-3 py-3 transition-colors duration-200 rounded-lg
                               {{ str_contains($currentRoute, 'materiales') || str_contains($currentRoute, 'bodegas') ? 'text-white font-semibold bg-gradient-to-r from-blue-900 to-transparent' : 'text-slate-400 hover:text-slate-200 hover:bg-white/5' }}">
                    <span class="material-symbols-outlined mr-3">inventory_2</span>
                    <span>Inventarios</span>
                    <span class="material-symbols-outlined ml-auto text-xs transition-transform" :class="open ? 'rotate-180' : ''">expand_more</span>
                </button>
                <div x-show="open" x-collapse class="mt-1 ml-9 space-y-1 border-l border-slate-700/50">
                    <a href="#" class="block px-4 py-2 text-slate-400 hover:text-slate-200 hover:bg-white/5 transition-colors text-xs">Stock mínimo</a>
                    <a href="#" class="block px-4 py-2 text-slate-400 hover:text-slate-200 hover:bg-white/5 transition-colors text-xs">Alertas de bajo stock</a>
                    <a href="{{ route('admin.materiales.listar') }}"
                       class="block px-4 py-2 transition-colors text-xs {{ str_contains($currentRoute, 'materiales') ? 'text-white font-semibold' : 'text-slate-400 hover:text-slate-200 hover:bg-white/5' }}">Materiales</a>
                    <a href="{{ route('admin.bodegas.listar') }}"
                       class="block px-4 py-2 transition-colors text-xs {{ str_contains($currentRoute, 'bodegas') ? 'text-white font-semibold' : 'text-slate-400 hover:text-slate-200 hover:bg-white/5' }}">Bodegas</a>
                </div>
            </div>

            {{-- Reportes --}}
            <div x-data="{ open: false }" class="group">
                <button @click="open = !open"
                        class="w-full flex items-center px-3 py-3 text-slate-400 hover:text-slate-200 hover:bg-white/5 transition-colors duration-200 rounded-lg">
                    <span class="material-symbols-outlined mr-3">analytics</span>
                    <span>Reportes</span>
                    <span class="material-symbols-outlined ml-auto text-xs transition-transform" :class="open ? 'rotate-180' : ''">expand_more</span>
                </button>
                <div x-show="open" x-collapse class="mt-1 ml-9 space-y-1 border-l border-slate-700/50">
                    <a href="#" class="block px-4 py-2 text-slate-400 hover:text-slate-200 hover:bg-white/5 transition-colors text-xs">Inventarios</a>
                    <a href="#" class="block px-4 py-2 text-slate-400 hover:text-slate-200 hover:bg-white/5 transition-colors text-xs">Producción</a>
                    <a href="#" class="block px-4 py-2 text-slate-400 hover:text-slate-200 hover:bg-white/5 transition-colors text-xs">Pedidos</a>
                </div>
            </div>

            {{-- Admin section --}}
            @role('admin')
            <div class="pt-4 mt-4 border-t border-slate-700/50">
                <p class="px-3 mb-2 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Administración</p>

                <a href="{{ route('admin.users.listar') }}"
                   class="flex items-center px-3 py-3 rounded-lg transition-colors duration-200
                          {{ str_contains($currentRoute, 'users') ? 'text-white font-semibold bg-gradient-to-r from-blue-900 to-transparent' : 'text-slate-400 hover:text-slate-200 hover:bg-white/5' }}">
                    <span class="material-symbols-outlined mr-3">admin_panel_settings</span>
                    <span>Usuarios</span>
                </a>

                <a href="#"
                   class="flex items-center px-3 py-3 text-slate-400 hover:text-slate-200 hover:bg-white/5 transition-colors duration-200 rounded-lg">
                    <span class="material-symbols-outlined mr-3">settings</span>
                    <span>Ajustes</span>
                </a>
            </div>
            @endrole
        </nav>

        {{-- Footer --}}
        <div class="mt-auto border-t border-slate-800 p-3 space-y-1">
            <a href="#" class="flex items-center px-3 py-2 text-slate-400 hover:text-slate-200 text-xs transition-colors">
                <span class="material-symbols-outlined mr-3 text-sm">help</span>
                <span>Ayuda</span>
            </a>
        </div>
    </aside>

    {{-- Main Content --}}
    <main class="ml-64 min-h-screen flex flex-col">
        {{-- Topbar --}}
        <header class="sticky top-0 right-0 w-full z-30 flex items-center justify-between px-8 py-4 bg-white/80 backdrop-blur-md border-b border-slate-200/50 text-sm font-medium">
            <div class="flex items-center gap-6 flex-1">
                <div class="relative w-96 group">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-blue-600">search</span>
                    <input type="text"
                           class="w-full pl-10 pr-4 py-2 bg-slate-100 border-none rounded-lg focus:ring-2 focus:ring-blue-500/20 text-xs transition-all"
                           placeholder="Buscar..."/>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <button class="p-2 text-slate-500 hover:bg-slate-100 rounded-md transition-colors">
                    <span class="material-symbols-outlined">notifications</span>
                </button>
                <div class="h-6 w-px bg-slate-300 mx-2"></div>
                <div class="flex items-center gap-3">
                    <div class="h-9 w-9 rounded-full bg-primary text-white flex items-center justify-center text-sm font-bold">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div class="flex flex-col">
                        <span class="text-xs font-semibold text-slate-700">{{ Auth::user()->name }}</span>
                        <span class="text-[10px] text-slate-400">{{ Auth::user()->getRoleNames()->first() ? ucfirst(Auth::user()->getRoleNames()->first()) : 'Usuario' }}</span>
                    </div>
                </div>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="p-2 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-md transition-colors" title="Cerrar sesión">
                        <span class="material-symbols-outlined text-xl">logout</span>
                    </button>
                </form>
            </div>
        </header>

        {{-- Page Content --}}
        <div class="p-8 max-w-7xl mx-auto w-full overflow-y-auto flex-1">
            @yield('content')
        </div>
    </main>
@endguest

<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@stack('scripts')
</body>
</html>