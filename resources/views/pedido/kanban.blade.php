@extends('layouts.module')

@section('title', 'Tablero Kanban de Pedidos')
@section('page-title', 'Tablero Kanban de Pedidos')

@section('content')

<div class="max-w-7xl mx-auto">

@php
    $etiquetas = [
        'recibido'   => 'Recibido',
        'en_proceso' => 'En proceso',
        'terminado'  => 'Terminado',
        'entregado'  => 'Entregado',
        'cancelado'  => 'Cancelado',
    ];

    // Indicador sobrio por estado (sin bordes arcoíris ni fondos caricaturescos)
    $indicadores = [
        'recibido'   => 'bg-slate-400',
        'en_proceso' => 'bg-brand-800',
        'terminado'  => 'bg-emerald-600',
        'entregado'  => 'bg-brand-600',
        'cancelado'  => 'bg-rose-500',
    ];
@endphp

{{-- Barra superior limpia del Kanban --}}
<div class="bg-white rounded-lg border border-slate-200 shadow-2xs p-4 sm:p-5 mb-6 flex flex-wrap items-center justify-between gap-3">
    <div>
        <h2 class="text-base sm:text-lg font-bold text-brand-900">Flujo de Trabajo del Taller</h2>
        <p class="text-xs sm:text-sm text-slate-500 mt-0.5">
            Arrastra cada pedido entre columnas para actualizar su etapa. Entregados y cancelados muestran los últimos {{ $dias }} días.
        </p>
    </div>
    <div class="flex flex-wrap items-center gap-2.5">
        <a href="{{ route('pedidos.index') }}" class="inline-flex items-center gap-2 px-3.5 py-2 rounded-lg bg-slate-100 hover:bg-slate-200 text-xs font-semibold text-brand-900 transition-colors">
            <span class="w-4 h-4 text-slate-600">@include('layouts.partials.icons', ['icon' => 'file-clock'])</span>
            <span>Historial y Lista de Pedidos</span>
        </a>
        <a href="{{ route('pedidos.nuevo') }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg bg-brand-600 hover:bg-brand-700 text-white text-xs font-semibold transition-colors shadow-2xs">
            <span class="w-4 h-4">@include('layouts.partials.icons', ['icon' => 'plus-circle'])</span>
            <span>Nuevo pedido</span>
        </a>
    </div>
</div>

{{-- Columnas del Tablero Kanban (corte recto, fondo neutro, sin bordes punteados) --}}
<div class="grid grid-cols-1 md:grid-cols-3 xl:grid-cols-5 gap-4">

    @foreach ($estados as $estado)
        @php
            $punto = $indicadores[$estado] ?? 'bg-slate-400';
        @endphp
        <div class="bg-[#ECEEF2] rounded-lg border border-slate-200/90 p-3 flex flex-col">

            {{-- Cabecera de columna sobria --}}
            <div class="flex items-center justify-between px-1 pb-2.5 mb-2 border-b border-slate-200">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full {{ $punto }}"></span>
                    <h3 class="font-bold text-xs uppercase tracking-wider text-brand-900">
                        {{ $etiquetas[$estado] }}
                    </h3>
                </div>
                <span data-contador="{{ $estado }}" class="text-xs font-bold bg-white text-slate-700 border border-slate-200 rounded px-2 py-0.5">
                    {{ ($pedidos_por_estado[$estado] ?? collect())->count() }}
                </span>
            </div>

            @if (in_array($estado, ['entregado', 'cancelado']))
                <p class="text-[11px] text-slate-500 px-1 mb-2">Últimos {{ $dias }} días</p>
            @endif

            {{-- Contenedor de tarjetas --}}
            <div class="kanban-columna space-y-2.5 min-h-48 flex-1 pt-1" data-estado="{{ $estado }}">
                @foreach (($pedidos_por_estado[$estado] ?? []) as $pedido)
                    <div class="kanban-tarjeta bg-white border border-slate-200/90 hover:border-slate-400 rounded-md p-3.5 text-sm cursor-grab active:cursor-grabbing shadow-2xs hover:shadow transition-all"
                        data-id="{{ $pedido->id }}">
                        <div class="flex items-start justify-between gap-2 mb-1.5">
                            <p class="font-bold text-brand-900 text-sm leading-snug">
                                {{ $pedido->cliente->nombre }} {{ $pedido->cliente->apellido ?? '' }}
                            </p>
                            <span class="text-[11px] font-semibold text-slate-400 shrink-0">#{{ $pedido->id }}</span>
                        </div>

                        <p class="text-xs text-slate-600 line-clamp-2 mb-3">
                            {{ $pedido->descripcion ?: 'Sin descripción especificada' }}
                        </p>

                        <div class="flex items-center justify-between pt-2.5 border-t border-slate-100 text-[11px]">
                            <span class="text-slate-500 flex items-center gap-1">
                                <span class="w-3.5 h-3.5 text-slate-400">@include('layouts.partials.icons', ['icon' => 'calendar'])</span>
                                <strong class="text-brand-900 font-semibold">{{ $pedido->fecha_entrega }}</strong>
                            </span>
                            <a href="{{ route('pedidos.edit', $pedido->id) }}"
                                class="text-brand-800 hover:text-brand-600 font-semibold hover:underline">
                                Detalle →
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    @endforeach

</div>
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
