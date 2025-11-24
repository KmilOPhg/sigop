<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SIGOP') }}</title>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
<div id="app">
    <!-- ENCABEZADO PRINCIPAL -->
    <nav class="navbar navbar-expand-md navbar-light flex-column p-0 shadow-sm">

        <!-- Sección superior (blanca) -->
        <div class="container-fluid py-2 px-4 bg-white d-flex justify-content-between align-items-center border-bottom">
            @guest()
            <a class="navbar-brand d-flex align-items-center text-decoration-none" href="{{ route('login') }}">
                <img src="{{ asset('logo/logo_2.png') }}" alt="Logo" class="me-2" style="height:50px;">
                <span class="fw-bold fs-4 text-dark">SIGOP</span>
            </a>
            @endguest
            @role('admin')
                <a class="navbar-brand d-flex align-items-center text-decoration-none" href="{{ route('admin.dashboard') }}">
                    <img src="{{ asset('logo/logo_2.png') }}" alt="Logo" class="me-2" style="height:50px;">
                    <span class="fw-bold fs-4 text-dark">SIGOP</span>
                </a>
            @endrole
            @role('editor')
                <a class="navbar-brand d-flex align-items-center text-decoration-none" href="{{ route('editor.dashboard') }}">
                    <img src="{{ asset('logo/logo_2.png') }}" alt="Logo" class="me-2" style="height:50px;">
                    <span class="fw-bold fs-4 text-dark">SIGOP</span>
                </a>
            @endrole


            <!-- Usuario (solo visible cuando hay sesión iniciada) -->
            @if(Auth::check())
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle fw-semibold text-dark" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle me-1 text-primary"></i>{{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                            <li>
                                <a class="dropdown-item fw-semibold text-dark" href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="bi bi-box-arrow-right me-1 text-danger"></i>Cerrar sesión
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            @endif
        </div>

        <!-- Barra de navegación principal -->
        @if(Auth::check())
            <div class="w-100 border-top border-2" style="background-color:#2271B4;">
                <div class="container-fluid px-2">
                    <ul class="navbar-nav d-flex justify-content-start align-items-center text-center">
                        @php
                            $menuItems = [
                                [
                                    'icon' => 'bi-diagram-3',
                                    'label' => 'Planeación',
                                    'items' => [
                                        ['label' => 'Control de fases', 'href' => '#'],
                                        ['label' => 'Asignación de materiales', 'href' => '#']
                                    ]
                                ],
                                [
                                    'icon' => 'bi-box-seam',
                                    'label' => 'Pedidos',
                                    'items' => [
                                        ['label' => 'Importar Órdenes', 'href' => '#'],
                                        ['label' => 'Importar Inventarios', 'href' => '#'],
                                        ['label' => 'Consultar Estado', 'href' => '#'],
                                        ['label' => 'Reasignación de Pedidos', 'href' => '#']
                                    ]
                                ],
                                [
                                    'icon' => 'bi-archive',
                                    'label' => 'Inventarios',
                                    'items' => [
                                        ['label' => 'Stock mínimo', 'href' => '#'],
                                        ['label' => 'Alertas de bajo stock', 'href' => '#'],
                                        ['label' => 'Materiales', 'href' => route('admin.materiales.listar')],
                                        ['label' => 'Bodegas', 'href' => route('admin.bodegas.listar')]
                                    ]
                                ],
                                [
                                    'icon' => 'bi-graph-up',
                                    'label' => 'Reportes',
                                    'items' => [
                                        ['label' => 'Inventarios', 'href' => '#'],
                                        ['label' => 'Producción', 'href' => '#'],
                                        ['label' => 'Pedidos', 'href' => '#']
                                    ]
                                ],
                                [
                                    'icon' => 'bi-patch-question',
                                    'label' => 'Ayuda',
                                    'items' => [
                                        ['label' => 'Acerca de SIGOP', 'href' => '#'],
                                        ['label' => 'Manual de Usuario', 'href' => '#'],
                                        ['label' => 'Preguntas Frecuentes (FAQ)', 'href' => '#'],
                                        ['label' => 'Centro de Soporte', 'href' => '#']
                                    ]
                                ]
                            ];
                        @endphp

                        @foreach($menuItems as $menu)
                            <li class="nav-item dropdown position-relative mx-1">
                                <a class="nav-link dropdown-toggle text-white fw-semibold px-3 py-3 d-flex align-items-center justify-content-center"
                                   href="#" id="menu{{ $menu['label'] }}" role="button" data-bs-toggle="dropdown"
                                   aria-expanded="false"
                                   style="transition: all 0.3s ease; border-radius: 0.4rem;"
                                   onmouseover="this.style.backgroundColor='#4AA0E6'; this.style.boxShadow='0 2px 8px rgba(0,0,0,0.15)';"
                                   onmouseout="this.style.backgroundColor='#2271B4'; this.style.boxShadow='none';">
                                    <i class="bi {{ $menu['icon'] }} me-2 fs-5"></i>{{ $menu['label'] }}
                                </a>
                                <ul class="dropdown-menu shadow border-0 rounded-3 mt-1" style="min-width:200px;">
                                    @foreach($menu['items'] as $item)
                                        <li>
                                            <a class="dropdown-item fw-semibold py-2"
                                               href="{{ $item['href'] }}"
                                               style="transition: all 0.2s ease;"
                                               onmouseover="this.style.backgroundColor='#F7A61D'; this.style.color='white';"
                                               onmouseout="this.style.backgroundColor='transparent'; this.style.color='';">
                                                {{ $item['label'] }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @endforeach

                        <!-- Gestión SIGOP (solo admin) -->
                        @role('admin')
                        <li class="nav-item dropdown position-relative mx-1">
                            <a class="nav-link dropdown-toggle text-white fw-semibold px-3 py-3 d-flex align-items-center justify-content-center"
                               href="#" id="menuAdmin" role="button" data-bs-toggle="dropdown"
                               aria-expanded="false"
                               style="transition: all 0.3s ease; border-radius: 0.4rem;"
                               onmouseover="this.style.backgroundColor='#1E9D52'; this.style.boxShadow='0 2px 8px rgba(0,0,0,0.15)';"
                               onmouseout="this.style.backgroundColor='#2271B4'; this.style.boxShadow='none';">
                                <i class="bi bi-people-fill me-2 fs-5"></i>Usuarios
                            </a>
                            <ul class="dropdown-menu shadow border-0 rounded-3 mt-1" style="min-width:200px;">
                                <li><a class="dropdown-item fw-semibold py-2" href="{{ route('admin.users.listar') }}">Gestion de Usuarios</a></li>
                                <li><a class="dropdown-item fw-semibold py-2" href="#">Roles</a></li>
                                <li><a class="dropdown-item fw-semibold py-2" href="#">Permisos</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown position-relative mx-1">
                            <a class="nav-link dropdown-toggle text-white fw-semibold px-3 py-3 d-flex align-items-center justify-content-center"
                               href="#" id="menuAdmin" role="button" data-bs-toggle="dropdown"
                               aria-expanded="false"
                               style="transition: all 0.3s ease; border-radius: 0.4rem;"
                               onmouseover="this.style.backgroundColor='#1E9D52'; this.style.boxShadow='0 2px 8px rgba(0,0,0,0.15)';"
                               onmouseout="this.style.backgroundColor='#2271B4'; this.style.boxShadow='none';">
                                <i class="bi bi-gear-fill me-2 fs-5"></i>Ajustes
                            </a>
                            <ul class="dropdown-menu shadow border-0 rounded-3 mt-1" style="min-width:200px;">
                                <li><a class="dropdown-item fw-semibold py-2" href="#">Configuración General del Sistema</a></li>
                                <li><a class="dropdown-item fw-semibold py-2" href="#">Parametros de Producción y Planeación</a></li>
                                <li><a class="dropdown-item fw-semibold py-2" href="#">Gestión de Plantillas de Reportes e Importación</a></li>
                                <li><a class="dropdown-item fw-semibold py-2" href="#">Seguridad</a></li>
                            </ul>
                        </li>
                        @endrole
                    </ul>
                </div>
            </div>
        @endif
    </nav>

    <!-- CONTENIDO PRINCIPAL -->
    <main class="py-4 bg-light min-vh-100">
        @yield('content')
    </main>
</div>
</body>
</html>
