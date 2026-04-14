@extends('layouts.app')

@section('content')
    <div class="w-full max-w-md">
        {{-- Brand --}}
        <div class="text-center mb-8">
            @if(file_exists(public_path('logo/logo_2.png')))
                <img src="{{ asset('logo/logo_2.png') }}" alt="Logo" class="h-12 mx-auto mb-4">
            @endif
            <h1 class="text-2xl font-black tracking-tighter text-primary uppercase">SIGOP</h1>
            <p class="text-xs text-slate-400 uppercase tracking-widest mt-1">Control de Producción</p>
        </div>

        {{-- Card --}}
        <div class="bg-white rounded-xl shadow-xl shadow-blue-900/10 overflow-hidden">
            <div class="p-8">
                <h2 class="text-lg font-bold text-on-surface mb-1">Bienvenido</h2>
                <p class="text-xs text-slate-500 mb-6">Inicia sesión para continuar</p>

                @include('partials.errorsuccess')

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Correo electrónico</label>
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus
                               placeholder="ejemplo@correo.com"
                               class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all @error('email') border-red-400 @enderror">
                        @error('email')
                            <p class="text-[10px] text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Contraseña</label>
                        <input type="password" name="password" required
                               placeholder="Ingresa tu contraseña"
                               class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all @error('password') border-red-400 @enderror">
                        @error('password')
                            <p class="text-[10px] text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="flex items-center gap-2 text-xs text-slate-500 cursor-pointer">
                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}
                                   class="rounded border-slate-300 text-blue-600 focus:ring-blue-500/20">
                            Recordarme
                        </label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-xs font-semibold text-secondary hover:text-primary transition-colors">
                                ¿Olvidaste tu contraseña?
                            </a>
                        @endif
                    </div>

                    <button type="submit"
                            class="w-full py-3 bg-gradient-to-r from-primary to-primary-container text-white rounded-lg text-xs font-bold uppercase tracking-widest shadow-lg shadow-blue-900/20 flex items-center justify-center gap-2 hover:opacity-90 transition-opacity">
                        <span class="material-symbols-outlined text-sm">login</span>
                        Iniciar Sesión
                    </button>
                </form>
            </div>

            <div class="px-8 py-4 bg-slate-50 text-center">
                <p class="text-[10px] text-slate-400">&copy; {{ date('Y') }} <span class="font-semibold">SIGOP</span>. Todos los derechos reservados.</p>
            </div>
        </div>
    </div>
@endsection
