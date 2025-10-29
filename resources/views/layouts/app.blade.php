<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Barra horizontal con pestañas -->

        @if(Auth::check())
            <nav class="navbar navbar-expand-md navbar-dark bg-primary shadow-sm">
                <div class="container">
                    <ul class="navbar-nav mx-auto">
                        <!-- Pestaña 1 -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-white" href="#" id="menuInicio" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Planeación
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="menuInicio">

                            </ul>
                        </li>

                        <!-- Pestaña 2 -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-white" href="#" id="menuProyectos" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Pedidos
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="menuProyectos">

                            </ul>
                        </li>

                        <!-- Pestaña 3 -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-white" href="#" id="menuReportes" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Inventarios
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="menuReportes">

                            </ul>
                        </li>

                        <!-- Pestaña 4 -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-white" href="#" id="menuConfiguracion" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Reportes
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="menuConfiguracion">

                            </ul>
                        </li>

                        <!-- Pestaña 5 -->
                        @role('admin')
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-white" href="#" id="menuAyuda" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Auditoria
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="menuAyuda">
                                <li><a class="dropdown-item" href="#">Crear Usuario</a></li>
                                <li><a class="dropdown-item" href="#">Restablecer contraseña</a></li>
                                <li><a class="dropdown-item" href="#">Roles</a></li>
                                <li><a class="dropdown-item" href="#">Permisos</a></li>
                            </ul>
                        </li>
                        @endrole
                    </ul>
                </div>
            </nav>
        @endif


        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
