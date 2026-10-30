@php
    $colores_estado = [
        'recibido'   => 'bg-amber-100 text-amber-800 border-amber-200',
        'en_proceso' => 'bg-blue-100 text-brand-800 border-blue-200',
        'terminado'  => 'bg-emerald-100 text-emerald-800 border-emerald-200',
        'entregado'  => 'bg-brand-100 text-brand-700 border-brand-200',
        'cancelado'  => 'bg-rose-100 text-rose-700 border-rose-200',
    ];
@endphp

@forelse ($pedidos as $pedido)
    @php
        $badge = $colores_estado[$pedido->estado] ?? 'bg-slate-100 text-slate-700 border-slate-200';
    @endphp
    <tr class="hover:bg-brand-50/70 transition-colors">
        <td class="px-6 py-4">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-full bg-brand-100 text-brand-700 border border-brand-200 flex items-center justify-center text-xs font-bold shrink-0">
                    {{ strtoupper(substr($pedido->cliente->nombre ?? '', 0, 1) . substr($pedido->cliente->apellido ?? '', 0, 1)) }}
                </div>
                <div>
                    <span class="text-brand-900 font-semibold text-sm block">
                        {{ $pedido->cliente->nombre ?? '' }} {{ $pedido->cliente->apellido ?? '' }}
                    </span>
                    <span class="text-[11px] text-brand-900/50">Pedido #{{ $pedido->id }}</span>
                </div>
            </div>
        </td>
        <td class="px-6 py-4 text-sm text-brand-900/75 max-w-xs truncate">
            {{ $pedido->descripcion ?: 'Sin descripción' }}
        </td>
        <td class="px-6 py-4 text-sm text-brand-900/70">{{ $pedido->fecha }}</td>
        <td class="px-6 py-4 text-sm font-semibold text-brand-900">{{ $pedido->fecha_entrega }}</td>
        <td class="px-6 py-4">
            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold border {{ $badge }}">
                {{ ucfirst(str_replace('_', ' ', $pedido->estado)) }}
            </span>
        </td>
        <td class="px-6 py-4">
            <div class="flex items-center justify-end gap-3">
                <a href="{{ route('pedidos.edit', $pedido->id) }}"
                    class="w-5 h-5 text-brand-900/50 hover:text-brand-600 transition-colors" title="Editar pedido">
                    @include('layouts.partials.icons', ['icon' => 'pencil'])
                </a>

                <form action="{{ route('pedidos.destroy', $pedido->id) }}"
                    method="POST"
                    onsubmit="return confirm('¿Eliminar este pedido?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="w-5 h-5 text-brand-900/45 hover:text-rose-600 transition-colors" title="Eliminar pedido">
                        @include('layouts.partials.icons', ['icon' => 'trash'])
                    </button>
                </form>
            </div>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="6" class="px-6 py-12 text-center text-sm text-brand-900/50">
            No hay pedidos que coincidan con la búsqueda.
        </td>
    </tr>
@endforelse
