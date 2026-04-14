{{-- Popup de Permisos Agrupados por Modulo --}}
<template x-teleport="body">
<div x-show="showPermisos" x-transition.opacity class="fixed inset-0 z-[999]" style="display:none">
    <div class="fixed inset-0 bg-black/60" @click="showPermisos = false"></div>
    <div class="fixed inset-0 overflow-y-auto">
        <div class="flex min-h-full items-center justify-center p-8">
            <div class="relative bg-white rounded-xl shadow-2xl w-full max-w-lg" x-transition.scale.95>
                {{-- Header --}}
                <div class="bg-gradient-to-r from-primary to-primary-container px-6 py-4 rounded-t-xl flex items-center justify-between">
                    <div>
                        <h3 class="text-base font-bold text-white">Seleccionar Permisos</h3>
                        <p class="text-[10px] text-white/70">Permisos agrupados por modulo del sistema</p>
                    </div>
                    <button type="button" @click="showPermisos = false" class="p-1 text-white/70 hover:text-white transition-colors">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>

                {{-- Body --}}
                <div class="p-5 space-y-3 max-h-[60vh] overflow-y-auto">
                    @php
                        $grupoConfig = [
                            'Dashboard' => [
                                'icono' => 'dashboard',
                                'bg' => 'bg-blue-50',
                                'iconColor' => 'text-blue-500',
                                'titleColor' => 'text-blue-700',
                                'countColor' => 'text-blue-400',
                                'btnActive' => 'bg-blue-200 text-blue-700',
                                'btnInactive' => 'bg-blue-100 text-blue-500 hover:bg-blue-200',
                                'checkbox' => 'text-blue-600 focus:ring-blue-500/20',
                            ],
                            'Usuarios' => [
                                'icono' => 'group',
                                'bg' => 'bg-violet-50',
                                'iconColor' => 'text-violet-500',
                                'titleColor' => 'text-violet-700',
                                'countColor' => 'text-violet-400',
                                'btnActive' => 'bg-violet-200 text-violet-700',
                                'btnInactive' => 'bg-violet-100 text-violet-500 hover:bg-violet-200',
                                'checkbox' => 'text-violet-600 focus:ring-violet-500/20',
                            ],
                            'Materiales' => [
                                'icono' => 'inventory_2',
                                'bg' => 'bg-amber-50',
                                'iconColor' => 'text-amber-500',
                                'titleColor' => 'text-amber-700',
                                'countColor' => 'text-amber-400',
                                'btnActive' => 'bg-amber-200 text-amber-700',
                                'btnInactive' => 'bg-amber-100 text-amber-500 hover:bg-amber-200',
                                'checkbox' => 'text-amber-600 focus:ring-amber-500/20',
                            ],
                            'Bodegas' => [
                                'icono' => 'warehouse',
                                'bg' => 'bg-emerald-50',
                                'iconColor' => 'text-emerald-500',
                                'titleColor' => 'text-emerald-700',
                                'countColor' => 'text-emerald-400',
                                'btnActive' => 'bg-emerald-200 text-emerald-700',
                                'btnInactive' => 'bg-emerald-100 text-emerald-500 hover:bg-emerald-200',
                                'checkbox' => 'text-emerald-600 focus:ring-emerald-500/20',
                            ],
                            'Otros' => [
                                'icono' => 'more_horiz',
                                'bg' => 'bg-slate-50',
                                'iconColor' => 'text-slate-500',
                                'titleColor' => 'text-slate-700',
                                'countColor' => 'text-slate-400',
                                'btnActive' => 'bg-slate-200 text-slate-700',
                                'btnInactive' => 'bg-slate-100 text-slate-500 hover:bg-slate-200',
                                'checkbox' => 'text-slate-600 focus:ring-slate-500/20',
                            ],
                        ];
                    @endphp

                    @foreach($permisosAgrupados as $grupo => $permisos)
                        @php
                            $cfg = $grupoConfig[$grupo] ?? $grupoConfig['Otros'];
                            $permisosJson = $permisos->map(fn($p) => ['name' => $p->name])->values()->toJson();
                        @endphp
                        <div class="border border-slate-200 rounded-lg overflow-hidden" x-data="{ open: true }">
                            {{-- Header del grupo --}}
                            <div class="flex items-center justify-between px-4 py-2.5 {{ $cfg['bg'] }} cursor-pointer select-none"
                                 @click="open = !open">
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined {{ $cfg['iconColor'] }} text-base">{{ $cfg['icono'] }}</span>
                                    <span class="text-xs font-bold {{ $cfg['titleColor'] }} uppercase tracking-wider">{{ $grupo }}</span>
                                    <span class="text-[10px] {{ $cfg['countColor'] }} font-medium">({{ $permisos->count() }})</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <button type="button"
                                            @click.stop="toggleGrupo({{ $permisosJson }})"
                                            class="text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded transition-colors"
                                            :class="grupoSeleccionado({{ $permisosJson }})
                                                ? '{{ $cfg['btnActive'] }}'
                                                : '{{ $cfg['btnInactive'] }}'"
                                            x-text="grupoSeleccionado({{ $permisosJson }}) ? 'Quitar todos' : 'Seleccionar todos'">
                                    </button>
                                    <span class="material-symbols-outlined text-slate-400 text-sm transition-transform"
                                          :class="open ? 'rotate-180' : ''">expand_more</span>
                                </div>
                            </div>
                            {{-- Permisos del grupo --}}
                            <div x-show="open" x-transition class="px-4 py-2 space-y-1 bg-white">
                                @foreach($permisos as $permiso)
                                    <label class="flex items-center gap-2.5 px-2 py-1.5 rounded-lg cursor-pointer hover:bg-slate-50 transition-colors"
                                           @click.stop>
                                        <input type="checkbox"
                                               :checked="selectedPermisos.includes('{{ $permiso->name }}')"
                                               @change="togglePermiso('{{ $permiso->name }}')"
                                               class="rounded border-slate-300 {{ $cfg['checkbox'] }}">
                                        <span class="text-xs text-slate-700">{{ ucfirst($permiso->name) }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Footer --}}
                <div class="px-5 py-3 border-t border-slate-200/50 flex items-center justify-between bg-slate-50 rounded-b-xl">
                    <span class="text-[10px] text-slate-400" x-text="selectedPermisos.length + ' permiso(s) seleccionado(s)'"></span>
                    <div class="flex gap-2">
                        <button type="button" @click="selectedPermisos = []"
                                class="px-4 py-1.5 text-xs font-bold text-slate-500 hover:text-slate-700 transition-colors">
                            Limpiar
                        </button>
                        <button type="button" @click="showPermisos = false"
                                class="px-5 py-1.5 bg-gradient-to-r from-primary to-primary-container text-white rounded-lg text-xs font-bold uppercase tracking-widest shadow-lg shadow-blue-900/20">
                            Confirmar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>
