@forelse ($pedidos as $pedido)
    <tr class="hover:bg-slate-50">
        <td class="px-6 py-4">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-full bg-primary-100 text-primary-700 flex items-center justify-center text-sm font-semibold shrink-0">
                    {{ strtoupper(substr($pedido->cliente->nombre, 0, 1) . substr($pedido->cliente->apellido, 0, 1)) }}
                </div>
                <span class="text-slate-700 font-medium">
                    {{ $pedido->cliente->nombre }} {{ $pedido->cliente->apellido }}
                </span>
            </div>
        </td>
        <td class="px-6 py-4 text-slate-500">{{ $pedido->descripcion }}</td>
        <td class="px-6 py-4 text-slate-500">{{ $pedido->fecha }}</td>
        <td class="px-6 py-4 text-slate-500">{{ $pedido->fecha_entrega }}</td>
        <td class="px-6 py-4 text-slate-500">{{ ucfirst(str_replace('_', ' ', $pedido->estado)) }}</td>
        <td class="px-6 py-4">
            <div class="flex items-center justify-end gap-3">
                <a href="{{ route('pedidos.edit', $pedido->id) }}"
                    class="w-5 h-5 text-slate-400 hover:text-primary-600" title="Editar">
                    @include('layouts.partials.icons', ['icon' => 'pencil'])
                </a>

                <form action="{{ route('pedidos.destroy', $pedido->id) }}"
                    method="POST"
                    onsubmit="return confirm('¿Eliminar este pedido?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="w-5 h-5 text-slate-400 hover:text-red-600" title="Eliminar">
                        @include('layouts.partials.icons', ['icon' => 'trash'])
                    </button>
                </form>
            </div>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="6" class="px-6 py-10 text-center text-slate-400">
            No hay pedidos que coincidan.
        </td>
    </tr>
@endforelse