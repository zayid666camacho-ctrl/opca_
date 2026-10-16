@extends('layouts.app')

@section('title', 'Calendario')
@section('page-title', 'Creaciones NayJa: Calendario')


@section('content')

@php
    // Agrupa los pedidos por día del mes (ej. [2 => [pedido1, pedido2], 15 => [pedido3]])
    // para poder consultar rápido "qué pedidos hay en el día X" dentro del bucle de la grilla.
    $pedidos_por_dia = $pedidos->groupBy(function ($pedido) {
        return \Carbon\Carbon::parse($pedido->fecha)->day;
    });

    $dias_en_mes = $primer_dia->daysInMonth;

    // Mes anterior/siguiente, para las flechas de navegación
    $mes_anterior = $primer_dia->copy()->subMonth();
    $mes_siguiente = $primer_dia->copy()->addMonth();

    // Nombre del mes en español, con mayúscula inicial
    $nombre_mes = ucfirst($primer_dia->locale('es')->monthName);

    $hoy = \Carbon\Carbon::now()->startOfDay();
@endphp

<div class="max-w-5xl mx-auto bg-white rounded-xl shadow-xl border border-slate-300 p-6">

    <div class="flex items-center justify-between mb-6">
        <a href="{{ route('calendario.index', ['mes' => $mes_anterior->month, 'anio' => $mes_anterior->year]) }}"
            class="text-2xl text-slate-400 hover:text-primary-600 px-3">
            &lsaquo;
        </a> 

        <h2 class="text-3xl font-bold text-slate-700">{{ $nombre_mes }} {{ $anio }}</h2>

        <a href="{{ route('calendario.index', ['mes' => $mes_siguiente->month, 'anio' => $mes_siguiente->year]) }}"
            class="text-2xl text-slate-700 hover:text-primary-600 px-3">
            &rsaquo;
        </a>
    </div>

    <div class="border border-slate-300 rounded-lg overflow-hidden shadow-sm">
    <div class="grid grid-cols-7 bg-slate-100 border-b border-slate-300 text-center text-xs font-bold text-slate-700 uppercase tracking-wider">
        <div class="py-2.5 border-r border-slate-300">Lunes</div>
        <div class="py-2.5 border-r border-slate-300">Martes</div>
        <div class="py-2.5 border-r border-slate-300">Miércoles</div>
        <div class="py-2.5 border-r border-slate-300">Jueves</div>
        <div class="py-2.5 border-r border-slate-300">Viernes</div>
        <div class="py-2.5 border-r border-slate-300">Sábado</div>
        <div class="py-2.5">Domingo</div>
    </div>
    

    <div class="grid grid-cols-7 border-l border-slate-200">

        {{-- Celdas vacías antes del día 1, según en qué día de la semana cae --}}
        @for ($i = 1; $i < $dia_semana_inicio; $i++)
            <div class="h-24 border-r border-b border-slate-200 bg-slate-50"></div>
        @endfor

        {{-- Un div por cada día real del mes --}}
        @for ($dia = 1; $dia <= $dias_en_mes; $dia++)
            <div class="h-24 border-r border-b border-slate-200 p-1 text-xs relative hover:bg-primary-100">

        <span class="text-slate-400">{{ $dia }}</span>

        <div class="mt-1 space-y-0.5">
            @foreach (($pedidos_por_dia[$dia] ?? []) as $pedido)

            @php
                // Calculamos los días restantes comparando la entrega con hoy
                $fecha_entrega = \Carbon\Carbon::parse($pedido->fecha_entrega)->startOfDay();
                $dias_restantes = $hoy->diffInDays($fecha_entrega, false);

                // Si falta 1 día o menos (o ya pasó), rojo suave. Si no, verde suave.
                if ($dias_restantes <= 1) {
                    $clases_color = 'bg-red-100 text-red-800 hover:bg-red-200 border-l-2 border-red-500';
                } else {
                    $clases_color = 'bg-emerald-100 text-emerald-800 hover:bg-emerald-200 border-l-2 border-emerald-500';
                }
            @endphp

                <div x-data="{ open: false }" class="relative">
                    <button
                        @click="open = !open"
                        @click.outside="open = false"
                        type="button"
                        class="block w-full truncate text-left rounded px-1.5 py-0.5 font-medium transition-colors shadow-sm {{ $clases_color }}">
                            {{ $pedido->cliente->nombre }}
                    </button>

                    <div
                        x-show="open" x-cloak x-transition
                        @click.stop
                        class="absolute z-30 left-0 top-full mt-1 w-52 bg-white border border-slate-200 rounded-lg shadow-lg p-3 text-xs text-slate-600 space-y-1">
                        <p><span class="font-semibold text-slate-700">Entrega:</span> {{ $pedido->fecha_entrega }}</p>
                        <p><span class="font-semibold text-slate-700">Estado:</span> {{ $pedido->estado }}</p>
                        <p><span class="font-semibold text-slate-700">Descripción:</span> {{ $pedido->descripcion }}</p>
                        <p><span class="font-semibold text-slate-700">Precio:</span> ${{ number_format($pedido->precio, 2) }}</p>
                        <a href="{{ route('pedidos.edit', $pedido->id) }}" class="block mt-2 text-primary-600 hover:underline">
                            Editar pedido →
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

                <a href="{{ route('pedidos.create', ['fecha' => $primer_dia->copy()->day($dia)->toDateString()]) }}"
                    class="absolute bottom-1 right-1 text-primary-900 hover:text-primary-600 text-sm font-bold"
                    title="Nuevo pedido este día">
                    +
                </a>
            </div>
        @endfor

        {{-- Celdas vacías al final, para completar la última semana --}}
        @php
            $total_celdas = ($dia_semana_inicio - 1) + $dias_en_mes;
            $celdas_sobrantes = (7 - ($total_celdas % 7)) % 7;
        @endphp
        @for ($i = 0; $i < $celdas_sobrantes; $i++)
            <div class="h-24 border-r border-b border-slate-200 bg-slate-50"></div>
        @endfor

    </div>
</div>

@endsection