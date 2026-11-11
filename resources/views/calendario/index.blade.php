{{--
    OPCA — Vista Dedicada del Calendario Mensual de Pedidos
--}}
@extends('layouts.module')

@section('title', 'Calendario de Pedidos')
@section('page-title', 'Calendario de Pedidos')

@section('header-actions')
    <a href="{{ route('pedidos.nuevo') }}"
        class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg bg-brand-600 hover:bg-brand-700 text-white text-xs font-semibold shadow-xs transition-colors">
        <span class="w-4 h-4">@include('layouts.partials.icons', ['icon' => 'plus-circle'])</span>
        <span>Nuevo Pedido</span>
    </a>
@endsection

@section('content')

@php
    // Pedidos registrados en este mes (agrupados por día de recepción)
    $pedidos_por_dia = $pedidos->filter(function ($pedido) use ($mes, $anio) {
        $f = \Carbon\Carbon::parse($pedido->fecha);
        return $f->month == $mes && $f->year == $anio;
    })->groupBy(function ($pedido) {
        return \Carbon\Carbon::parse($pedido->fecha)->day;
    });

    // Marcas de agua de entregas programadas en este mes (cuando fecha_entrega es distinta a fecha de recepción)
    $entregas_por_dia = $pedidos->filter(function ($pedido) use ($mes, $anio) {
        if (empty($pedido->fecha_entrega) || $pedido->estado === 'cancelado') {
            return false;
        }
        $fe = \Carbon\Carbon::parse($pedido->fecha_entrega);
        return $fe->month == $mes && $fe->year == $anio && $pedido->fecha_entrega !== $pedido->fecha;
    })->groupBy(function ($pedido) {
        return \Carbon\Carbon::parse($pedido->fecha_entrega)->day;
    });

    $dias_en_mes = $primer_dia->daysInMonth;

    $mes_anterior = $primer_dia->copy()->subMonth();
    $mes_siguiente = $primer_dia->copy()->addMonth();

    $nombre_mes = ucfirst($primer_dia->locale('es')->monthName);

    $hoy = \Carbon\Carbon::now()->startOfDay();
@endphp

<div class="max-w-7xl mx-auto space-y-8">

    {{-- =====================================================================
         CALENDARIO MENSUAL DE PEDIDOS (A ANCHO COMPLETO)
         ===================================================================== --}}
    <section class="bg-white rounded-2xl shadow-lg border-2 border-brand-900 border-t-4 border-t-brand-600 p-6 sm:p-8">

        {{-- Navegación de Mes y Año --}}
        <div class="flex items-center justify-between mb-6">
            <a href="{{ route('calendario.index', ['mes' => $mes_anterior->month, 'anio' => $mes_anterior->year]) }}"
                class="w-10 h-10 rounded-lg border border-slate-200 flex items-center justify-center text-2xl text-brand-900 hover:bg-brand-600 hover:text-white hover:border-brand-600 transition-colors"
                title="Mes anterior">
                &lsaquo;
            </a> 

            <div class="text-center">
                <span class="text-[11px] font-bold uppercase tracking-widest text-brand-600 block">Agenda del Taller</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-brand-900 tracking-tight">{{ $nombre_mes }} {{ $anio }}</h2>
            </div>

            <a href="{{ route('calendario.index', ['mes' => $mes_siguiente->month, 'anio' => $mes_siguiente->year]) }}"
                class="w-10 h-10 rounded-lg border border-slate-200 flex items-center justify-center text-2xl text-brand-900 hover:bg-brand-600 hover:text-white hover:border-brand-600 transition-colors"
                title="Mes siguiente">
                &rsaquo;
            </a>
        </div>

        {{-- Leyenda de estados y urgencia --}}
        <div class="flex flex-wrap items-center justify-between gap-4 mb-4 text-xs font-semibold text-brand-900/75">
            <span class="text-brand-900/60">
                Haz clic en el botón <strong class="text-brand-600">+</strong> de cualquier día para crear un nuevo pedido en esa fecha.
            </span>

            <div class="flex flex-wrap items-center gap-4">
                <span class="flex items-center gap-1.5">
                    <span class="w-2.5 h-2.5 rounded-full bg-brand-800 inline-block"></span>
                    Terminado / Entregado
                </span>
                <span class="flex items-center gap-1.5">
                    <span class="w-2.5 h-2.5 rounded-full bg-red-500 inline-block"></span>
                    Urgente (Hoy / Mañana / Atrasado)
                </span>
                <span class="flex items-center gap-1.5">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 inline-block"></span>
                    Con margen (2+ días)
                </span>
                <span class="flex items-center gap-1.5">
                    <span class="w-2.5 h-2.5 rounded-full bg-slate-400 inline-block"></span>
                    Cancelado
                </span>
                <span class="flex items-center gap-1.5 text-slate-500">
                    <span class="w-3.5 h-2.5 rounded-xs border border-dashed border-slate-400 bg-slate-50 inline-block"></span>
                    Marca de entrega
                </span>
            </div>
        </div>

        {{-- Grilla del Calendario (sin overflow-hidden para que los detalles flotantes nunca se recorten) --}}
        <div class="border-2 border-brand-900 rounded-lg shadow-sm">
            <div class="grid grid-cols-7 bg-brand-900 rounded-t-md text-center text-xs font-bold text-white uppercase tracking-wider">
                <div class="py-3 border-r border-white/15">Lunes</div>
                <div class="py-3 border-r border-white/15">Martes</div>
                <div class="py-3 border-r border-white/15">Miércoles</div>
                <div class="py-3 border-r border-white/15">Jueves</div>
                <div class="py-3 border-r border-white/15">Viernes</div>
                <div class="py-3 border-r border-white/15">Sábado</div>
                <div class="py-3">Domingo</div>
            </div>

            <div class="grid grid-cols-7">

                {{-- Celdas vacías antes del día 1 --}}
                @for ($i = 1; $i < $dia_semana_inicio; $i++)
                    <div class="h-28 border-r border-b border-slate-200 bg-slate-50/70"></div>
                @endfor

                {{-- Un div por cada día real del mes --}}
                @for ($dia = 1; $dia <= $dias_en_mes; $dia++)
                    @php
                        $fecha_celda = $primer_dia->copy()->day($dia)->startOfDay();
                        $es_hoy = $fecha_celda->equalTo($hoy);
                        $posicion_columna = (($dia_semana_inicio - 1 + $dia - 1) % 7) + 1;
                        $clases_popover_pos = ($dia > 20 ? 'bottom-full mb-1.5 ' : 'top-full mt-1.5 ')
                                            . ($posicion_columna >= 6 ? 'right-0' : 'left-0');
                    @endphp
                    <div class="h-28 border-r border-b border-slate-200 p-1.5 text-xs relative hover:bg-slate-50/80 transition-colors {{ $es_hoy ? 'bg-brand-50 ring-2 ring-inset ring-brand-600' : 'bg-white' }}">

                        {{-- Cabecera del día: número a la izquierda y botón "+" a la derecha en la misma línea --}}
                        <div class="flex items-center justify-between">
                            <span class="{{ $es_hoy ? 'inline-flex items-center justify-center w-5 h-5 rounded-full bg-brand-600 text-white font-bold' : 'text-brand-900/60 font-semibold' }}">
                                {{ $dia }}
                            </span>

                            <div class="relative group">
                                <a href="{{ route('pedidos.nuevo', ['fecha' => $primer_dia->copy()->day($dia)->toDateString()]) }}"
                                    class="w-5 h-5 rounded flex items-center justify-center text-brand-600 hover:bg-brand-600 hover:text-white text-sm font-bold leading-none transition-colors"
                                    aria-label="Nuevo pedido">
                                    +
                                </a>
                                <span class="pointer-events-none absolute right-full top-1/2 -translate-y-1/2 mr-1.5 whitespace-nowrap rounded bg-brand-900 px-2 py-1 text-[10px] font-semibold text-white opacity-0 group-hover:opacity-100 transition-opacity z-50 shadow-lg">
                                    Nuevo pedido
                                </span>
                            </div>
                        </div>

                        <div class="mt-1 space-y-0.5">
                            @foreach (($pedidos_por_dia[$dia] ?? []) as $pedido)

                            @php
                                $fecha_entrega = \Carbon\Carbon::parse($pedido->fecha_entrega)->startOfDay();
                                $dias_restantes = $hoy->diffInDays($fecha_entrega, false);
                                
                                if (in_array($pedido->estado, ['terminado', 'entregado'])) {
                                    $clases_color = 'bg-accent-100 text-brand-800 hover:bg-accent-200 border-l-2 border-brand-800';
                                }               
                                elseif ($pedido->estado === 'cancelado') {
                                    $clases_color = 'bg-slate-100 text-slate-400 hover:bg-slate-200 border-l-2 border-slate-300 line-through';
                                }               
                                elseif ($dias_restantes < 0) {
                                    $clases_color = 'bg-red-100 text-red-900 hover:bg-red-200 border-l-2 border-red-600';
                                }                
                                elseif ($dias_restantes <= 1) {
                                    $clases_color = 'bg-red-100 text-red-800 hover:bg-red-200 border-l-2 border-red-500';
                                } 
                                else {
                                    $clases_color = 'bg-emerald-100 text-emerald-800 hover:bg-emerald-200 border-l-2 border-emerald-500';
                                }
                            @endphp

                                <div x-data="{ open: false }" class="relative">
                                    <button
                                        @click="open = !open"
                                        @click.outside="open = false"
                                        type="button"
                                        class="flex items-center justify-between gap-1 w-full text-left rounded px-1.5 py-0.5 font-medium transition-colors shadow-2xs cursor-pointer {{ $clases_color }}">
                                        <span class="truncate">{{ $pedido->cliente->nombre }}</span>
                                        <span class="text-[9px] opacity-65 font-semibold shrink-0">→ {{ $fecha_entrega->format('d/m') }}</span>
                                    </button>

                                    <div
                                        x-show="open" x-cloak x-transition
                                        @click.stop
                                        class="absolute z-40 {{ $clases_popover_pos }} w-60 bg-white border border-slate-200 rounded-lg shadow-xl p-3.5 text-xs text-brand-900/80 space-y-1">
                                        <p><span class="font-bold text-brand-900">Recibido:</span> {{ $pedido->fecha }}</p>
                                        <p><span class="font-bold text-brand-900">Entrega:</span> {{ $pedido->fecha_entrega }}</p>
                                        <p><span class="font-bold text-brand-900">Estado:</span> {{ ucfirst(str_replace('_', ' ', $pedido->estado)) }}</p>
                                        @if ($pedido->descripcion)
                                            <p><span class="font-bold text-brand-900">Descripción:</span> {{ $pedido->descripcion }}</p>
                                        @endif
                                        <p><span class="font-bold text-brand-900">Precio:</span> ${{ number_format($pedido->precio, 0, ',', '.') }}</p>
                                        <a href="{{ route('pedidos.edit', $pedido->id) }}" class="inline-block mt-2 font-bold text-brand-600 hover:text-brand-700 hover:underline">
                                            Editar pedido &rarr;
                                        </a>
                                    </div>
                                </div>
                            @endforeach

                            {{-- Marcas de agua de entregas programadas para este día --}}
                            @foreach (($entregas_por_dia[$dia] ?? []) as $entrega)
                                <div x-data="{ open: false }" class="relative">
                                    <button
                                        @click="open = !open"
                                        @click.outside="open = false"
                                        type="button"
                                        title="Entrega programada del pedido #{{ $entrega->id }} (recibido el {{ $entrega->fecha }})"
                                        class="block w-full truncate text-left rounded px-1.5 py-0.5 text-[10px] font-medium border border-dashed border-slate-300 bg-slate-50/70 text-slate-500 opacity-65 hover:opacity-100 hover:border-brand-600 hover:text-brand-900 transition-all cursor-pointer">
                                        ↳ Entrega: {{ $entrega->cliente->nombre }}
                                    </button>

                                    <div
                                        x-show="open" x-cloak x-transition
                                        @click.stop
                                        class="absolute z-40 {{ $clases_popover_pos }} w-60 bg-white border border-slate-200 rounded-lg shadow-xl p-3.5 text-xs text-brand-900/80 space-y-1">
                                        <p class="text-[10px] font-bold uppercase tracking-wider text-brand-600">Fecha de entrega programada</p>
                                        <p><span class="font-bold text-brand-900">Cliente:</span> {{ $entrega->cliente->nombre }} {{ $entrega->cliente->apellido ?? '' }}</p>
                                        <p><span class="font-bold text-brand-900">Recibido el:</span> {{ $entrega->fecha }}</p>
                                        <p><span class="font-bold text-brand-900">Estado:</span> {{ ucfirst(str_replace('_', ' ', $entrega->estado)) }}</p>
                                        @if ($entrega->descripcion)
                                            <p><span class="font-bold text-brand-900">Descripción:</span> {{ $entrega->descripcion }}</p>
                                        @endif
                                        <p><span class="font-bold text-brand-900">Precio:</span> ${{ number_format($entrega->precio, 0, ',', '.') }}</p>
                                        <a href="{{ route('pedidos.edit', $entrega->id) }}" class="inline-block mt-2 font-bold text-brand-600 hover:text-brand-700 hover:underline">
                                            Editar pedido &rarr;
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endfor

                {{-- Celdas vacías al final --}}
                @php
                    $total_celdas = ($dia_semana_inicio - 1) + $dias_en_mes;
                    $celdas_sobrantes = (7 - ($total_celdas % 7)) % 7;
                @endphp
                @for ($i = 0; $i < $celdas_sobrantes; $i++)
                    <div class="h-28 border-r border-b border-slate-200 bg-slate-50/70"></div>
                @endfor

            </div>
        </div>
    </section>

</div>

@endsection
