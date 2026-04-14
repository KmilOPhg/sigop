@extends('layouts.app')

@section('content')
    <div class="space-y-8">
        <div class="flex items-end justify-between">
            <div>
                <span class="text-xs font-bold text-primary/40 uppercase tracking-[0.2em]">Panel Editor</span>
                <h2 class="text-3xl font-bold tracking-tight text-on-surface mt-1">Dashboard</h2>
            </div>
            <div class="flex items-center px-3 py-1 bg-surface-container-high rounded-full text-xs font-medium text-secondary">
                <span class="w-2 h-2 rounded-full bg-green-500 mr-2"></span>
                Sesión Activa
            </div>
        </div>

        @if (session('status'))
            <div class="px-4 py-3 bg-green-50 border border-green-200 text-green-700 rounded-lg text-xs font-medium flex items-center gap-2">
                <span class="material-symbols-outlined text-sm">check_circle</span>
                {{ session('status') }}
            </div>
        @endif

        <div class="bg-surface-container-low rounded-xl p-8 text-center">
            <span class="material-symbols-outlined text-5xl text-secondary mb-4">edit_note</span>
            <p class="text-sm text-slate-600">Iniciaste como editor</p>
        </div>
    </div>
@endsection
