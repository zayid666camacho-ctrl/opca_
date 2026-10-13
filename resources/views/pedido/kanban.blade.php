@extends('layouts.module')

@section('title', 'Kanban de pedidos')
@section('page-title', 'Kanban de pedidos')

@section('content')

@php
    $etiquetas = [
        'recibido'   => 'Recibido',
        'en_proceso' => 'En proceso',
        'terminado'  => 'Terminado',
        'entregado'  => 'Entregado',
        'cancelado'  => 'Cancelado',
    ];
@endphp

<div class="grid grid-cols-1 md:grid-cols-3 xl:grid-cols-5 gap-4">

    @foreach ($estados as $estado)
        <div class="bg-white rounded-lg shadow p-3">

            <h3 class="font-semibold text-slate-700 mb-3 flex items-center justify-between">
                {{ $etiquetas[$estado] }}
                <span data-contador="{{ $estado }}" class="text-xs bg-slate-100 text-slate-500 rounded-full px-2 py-0.5">
                    {{ ($pedidos_por_estado[$estado] ?? collect())->count() }}
                </span>
            </h3>

            @if (in_array($estado, ['entregado', 'cancelado']))
                <p class="text-xs text-slate-400 mb-2">Últimos {{ $dias }} días</p>
            @endif

            <div class="kanban-columna space-y-2 min-h-24" data-estado="{{ $estado }}">
                @foreach (($pedidos_por_estado[$estado] ?? []) as $pedido)
                    <div class="kanban-tarjeta bg-primary-50 border border-primary-100 rounded p-2 text-sm cursor-grab"
                        data-id="{{ $pedido->id }}">
                        <p class="font-semibold text-slate-700">{{ $pedido->cliente->nombre }}</p>
                        <p class="text-slate-500 truncate">{{ $pedido->descripcion }}</p>
                        <p class="text-xs text-slate-400 mt-1">Entrega: {{ $pedido->fecha_entrega }}</p>
                    </div>
                @endforeach
            </div>

        </div>
    @endforeach

</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
<script>
    const token_csrf = '{{ csrf_token() }}';
    const url_estado = "{{ route('pedidos.estado', ['id' => ':id']) }}";

    function actualizar_contadores() {
        document.querySelectorAll('.kanban-columna').forEach(function (columna) {
            const contador = document.querySelector('[data-contador="' + columna.dataset.estado + '"]');
            contador.textContent = columna.children.length;
        });
    }

    function devolver_tarjeta(evento) {
        evento.from.insertBefore(evento.item, evento.from.children[evento.oldIndex] || null);
        actualizar_contadores();
    }

    document.querySelectorAll('.kanban-columna').forEach(function (columna) {
        new Sortable(columna, {
            group: {
                name: 'pedidos',
                pull: columna.dataset.estado !== 'cancelado',
            },
            animation: 150,
            onEnd: function (evento) {
                if (evento.from === evento.to) return;

                const id = evento.item.dataset.id;
                const nuevo_estado = evento.to.dataset.estado;

                if (nuevo_estado === 'cancelado') {
                    const confirmado = confirm('¿Seguro que quieres cancelar este pedido? Un pedido cancelado no se puede volver a mover.');
                    if (!confirmado) {
                        devolver_tarjeta(evento);
                        return;
                    }
                }

                fetch(url_estado.replace(':id', id), {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': token_csrf,
                    },
                    body: JSON.stringify({ estado: nuevo_estado }),
                })
                .then(function (respuesta) {
                    if (!respuesta.ok) {
                        return respuesta.json().then(function (datos) {
                            throw new Error(datos.mensaje || 'No se pudo cambiar el estado.');
                        });
                    }
                    actualizar_contadores();
                })
                .catch(function (error) {
                    alert(error.message);
                    devolver_tarjeta(evento);
                });
            },
        });
    });
</script>
@endpush