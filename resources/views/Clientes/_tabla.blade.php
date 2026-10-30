@forelse ($clientes as $cliente)
    <tr class="hover:bg-brand-50/70 transition-colors">
        <td class="px-6 py-4">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-full bg-brand-100 text-brand-700 border border-brand-200 flex items-center justify-center text-xs font-bold shrink-0">
                    {{ strtoupper(substr($cliente->nombre ?? '', 0, 1) . substr($cliente->apellido ?? '', 0, 1)) }}
                </div>
                <span class="text-brand-900 font-semibold text-sm">
                    {{ $cliente->nombre }} {{ $cliente->apellido }}
                </span>
            </div>
        </td>
        <td class="px-6 py-4 text-sm text-brand-900/75">{{ $cliente->correo ?: '—' }}</td>
        <td class="px-6 py-4 text-sm text-brand-900/75">{{ $cliente->telefono ?: '—' }}</td>
        <td class="px-6 py-4 text-sm text-brand-900/65">{{ $cliente->fecha_registro }}</td>
        <td class="px-6 py-4">
            <div class="flex items-center justify-end gap-3">
                <a href="{{ route('clientes.show', $cliente->id) }}"
                    class="w-5 h-5 text-brand-900/50 hover:text-brand-800 transition-colors" title="Ver detalles y medidas">
                    @include('layouts.partials.icons', ['icon' => 'eye'])
                </a>
                <a href="{{ route('clientes.edit', $cliente->id) }}"
                    class="w-5 h-5 text-brand-900/50 hover:text-brand-600 transition-colors" title="Editar cliente">
                    @include('layouts.partials.icons', ['icon' => 'pencil'])
                </a>
                <form action="{{ route('clientes.destroy', $cliente->id) }}"
                    method="POST"
                    onsubmit="return confirm('¿Eliminar este cliente?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="w-5 h-5 text-brand-900/45 hover:text-rose-600 transition-colors" title="Eliminar cliente">
                        @include('layouts.partials.icons', ['icon' => 'trash'])
                    </button>
                </form>
            </div>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="5" class="px-6 py-12 text-center text-sm text-brand-900/50">
            No hay clientes registrados que coincidan.
        </td>
    </tr>
@endforelse
