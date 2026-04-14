<div class="bg-surface-container-low rounded-xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
            <tr class="bg-surface-container-high/50">
                <th class="px-6 py-4 text-[10px] font-black uppercase text-slate-500 tracking-tighter">Código</th>
                <th class="px-6 py-4 text-[10px] font-black uppercase text-slate-500 tracking-tighter">Descripción</th>
                <th class="px-6 py-4 text-[10px] font-black uppercase text-slate-500 tracking-tighter">Estado</th>
                <th class="px-6 py-4 text-[10px] font-black uppercase text-slate-500 tracking-tighter text-right">Acciones</th>
            </tr>
            </thead>
            <tbody class="divide-y divide-slate-200/40">
            @forelse ($bodegas as $bodega)
                <tr class="hover:bg-surface-container-lowest transition-colors {{ $bodega->estado === 'inactivo' ? 'opacity-50' : '' }}">
                    <td class="px-6 py-5">
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-secondary text-sm">warehouse</span>
                            <span class="text-xs font-bold text-primary">{{ $bodega->referencia }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-5">
                        <span class="text-xs font-semibold">{{ $bodega->descripcion }}</span>
                    </td>
                    <td class="px-6 py-5">
                        <button class="toggleEstadoBtn px-2 py-1 text-[10px] font-bold rounded
                            {{ $bodega->estado === 'activo' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}"
                            data-id="{{ $bodega->id }}"
                            data-estado="{{ $bodega->estado === 'activo' ? 'inactivo' : 'activo' }}">
                            {{ ucfirst($bodega->estado) }}
                        </button>
                    </td>
                    <td class="px-6 py-5 text-right">
                        <a href="{{ route('admin.bodegas.editar', $bodega->id) }}"
                           class="inline-flex items-center gap-1 px-3 py-1.5 bg-surface-container-high text-primary text-[10px] font-bold uppercase tracking-widest rounded hover:bg-blue-50 transition-colors">
                            <span class="material-symbols-outlined text-sm">edit</span>
                            Editar
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="px-6 py-12 text-center text-slate-400">
                        <span class="material-symbols-outlined text-3xl mb-2 block">inbox</span>
                        No hay bodegas registradas.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    @if($bodegas->hasPages())
        <div class="px-6 py-4 border-t border-slate-200/40">
            {{ $bodegas->links() }}
        </div>
    @endif
</div>