{{--
    OPCA — Pantalla Principal del Panel de Administración (Opción 2: Hub Superior + Calendario)
    - Sin sidebar lateral: aprovecha el 100% del ancho.
    - Arriba: Bloque oscuro cálido "Panel de Administración: Tu Espacio NAyJA" con los módulos clave.
    - Abajo: Calendario mensual interactivo de pedidos.
--}}
@extends('layouts.module')

@section('title', 'Panel y Calendario')
@section('page-title', 'Panel Principal')

@section('content')

@php
    // Agrupa los pedidos por día del mes (ej. [2 => [pedido1, pedido2], 15 => [pedido3]])
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

<div class="max-w-7xl mx-auto space-y-8">

    {{-- =====================================================================
         1. HUB SUPERIOR: "PANEL DE ADMINISTRACIÓN: TU ESPACIO NAYJA"
         ===================================================================== --}}
    <section class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-[#2B161C] via-brand-900 to-[#18181D] text-white p-6 sm:p-10 shadow-xl border border-brand-200/20">
        {{-- Destello cálido decorativo --}}
        <div class="pointer-events-none absolute -top-24 left-1/3 w-96 h-96 rounded-full bg-brand-600/20 blur-3xl"></div>

        <div class="relative z-10">
            <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-4">
                <div>
                    <h2 class="text-2xl sm:text-4xl font-extrabold tracking-tight text-white">
                        Panel de Administración: Tu Espacio NAyJA
                    </h2>
                    <p class="mt-2 text-xs sm:text-sm text-slate-300 max-w-3xl leading-relaxed">
                        ¡Bienvenida a tu panel, <strong class="font-bold text-white">{{ auth()->user()->name ?? 'Administradora NAyJA' }}</strong>! Accede en un clic a los módulos principales del taller o agenda directamente un pedido en el calendario de abajo.
                    </p>
                </div>

                {{-- Píldoras de consulta rápida (Clientes, Historial, Precios Base, Ajustes) --}}
                <div class="flex flex-wrap items-center gap-2 shrink-0">
                    <a href="{{ route('clientes.index') }}" class="px-3.5 py-2 rounded-xl bg-white/10 hover:bg-white/20 border border-white/10 text-xs font-semibold text-white transition">
                        👥 Clientes y Medidas
                    </a>
                    <a href="{{ route('pedidos.index') }}" class="px-3.5 py-2 rounded-xl bg-white/10 hover:bg-white/20 border border-white/10 text-xs font-semibold text-white transition">
                        📋 Lista de Pedidos
                    </a>
                    <a href="{{ route('precio_bases.index') }}" class="px-3.5 py-2 rounded-xl bg-white/10 hover:bg-white/20 border border-white/10 text-xs font-semibold text-white transition">
                        🏷️ Precios Base
                    </a>
                    <a href="{{ route('configuracion.index') }}" class="px-3 py-2 rounded-xl bg-white/5 hover:bg-white/15 border border-white/10 text-xs font-medium text-slate-300 transition" title="Más opciones y seguridad">
                        ⚙️
                    </a>
                </div>
            </div>

            {{-- 4 Bloques Principales Operativos (con ícono delineado en rosa coral como la imagen guía) --}}
            <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">

                {{-- 1. Tablero Kanban (Pedidos Activos) --}}
                <a href="{{ route('pedidos.kanban') }}" class="group flex items-start gap-3.5 p-4 rounded-2xl bg-white/5 hover:bg-white/10 border border-white/10 hover:border-brand-500/50 transition-all">
                    <div class="w-11 h-11 rounded-xl border-2 border-brand-500 text-brand-500 flex items-center justify-center shrink-0 group-hover:bg-brand-600 group-hover:border-brand-600 group-hover:text-white transition-all">
                        <span class="w-5 h-5">@include('layouts.partials.icons', ['icon' => 'chart'])</span>
                    </div>
                    <div>
                        <h3 class="text-base font-extrabold text-white group-hover:text-brand-200 transition-colors">
                            Pedidos Activos (Kanban)
                        </h3>
                        <p class="mt-1 text-xs text-slate-300 leading-relaxed">
                            Mueve tus pedidos entre Recibido, En Proceso, Terminado y Entregado.
                        </p>
                    </div>
                </a>

                {{-- 2. Estado de Cuenta (Finanzas) --}}
                <a href="{{ route('finanzas.index') }}" class="group flex items-start gap-3.5 p-4 rounded-2xl bg-white/5 hover:bg-white/10 border border-white/10 hover:border-brand-500/50 transition-all">
                    <div class="w-11 h-11 rounded-xl border-2 border-brand-500 text-brand-500 flex items-center justify-center shrink-0 group-hover:bg-brand-600 group-hover:border-brand-600 group-hover:text-white transition-all font-extrabold text-base">
                        $
                    </div>
                    <div>
                        <h3 class="text-base font-extrabold text-white group-hover:text-brand-200 transition-colors">
                            Finanzas
                        </h3>
                        <p class="mt-1 text-xs text-slate-300 leading-relaxed">
                            Registra abonos, consulta saldos pendientes y exporta a Excel.
                        </p>
                    </div>
                </a>

                {{-- 3. Inventario de Materiales --}}
                <a href="{{ route('inventario.index') }}" class="group flex items-start gap-3.5 p-4 rounded-2xl bg-white/5 hover:bg-white/10 border border-white/10 hover:border-brand-500/50 transition-all">
                    <div class="w-11 h-11 rounded-xl border-2 border-brand-500 text-brand-500 flex items-center justify-center shrink-0 group-hover:bg-brand-600 group-hover:border-brand-600 group-hover:text-white transition-all">
                        <span class="w-5 h-5">@include('layouts.partials.icons', ['icon' => 'box'])</span>
                    </div>
                    <div>
                        <h3 class="text-base font-extrabold text-white group-hover:text-brand-200 transition-colors">
                            Inventario y Alertas
                        </h3>
                        <p class="mt-1 text-xs text-slate-300 leading-relaxed">
                            Controla telas, hilos e insumos con avisos de stock mínimo.
                        </p>
                    </div>
                </a>

                {{-- 4. Galería de Trabajos --}}
                <a href="{{ route('galeria.index') }}" class="group flex items-start gap-3.5 p-4 rounded-2xl bg-white/5 hover:bg-white/10 border border-white/10 hover:border-brand-500/50 transition-all">
                    <div class="w-11 h-11 rounded-xl border-2 border-brand-500 text-brand-500 flex items-center justify-center shrink-0 group-hover:bg-brand-600 group-hover:border-brand-600 group-hover:text-white transition-all">
                        <span class="w-5 h-5">@include('layouts.partials.icons', ['icon' => 'eye'])</span>
                    </div>
                    <div>
                        <h3 class="text-base font-extrabold text-white group-hover:text-brand-200 transition-colors">
                            Galería Pública
                        </h3>
                        <p class="mt-1 text-xs text-slate-300 leading-relaxed">
                            Publica y organiza las fotos de trabajos terminados en la web.
                        </p>
                    </div>
                </a>

            </div>
        </div>
    </section>

    {{-- =====================================================================
         2. CALENDARIO MENSUAL DE PEDIDOS (A ANCHO COMPLETO)
         ===================================================================== --}}
    <section class="bg-white rounded-3xl shadow-lg border border-brand-200/80 p-6 sm:p-8">

        {{-- Navegación de Mes y Año --}}
        <div class="flex items-center justify-between mb-6">
            <a href="{{ route('calendario.index', ['mes' => $mes_anterior->month, 'anio' => $mes_anterior->year]) }}"
                class="w-10 h-10 rounded-xl border border-brand-200 flex items-center justify-center text-2xl text-brand-900 hover:bg-brand-600 hover:text-white hover:border-brand-600 transition-colors"
                title="Mes anterior">
                &lsaquo;
            </a> 

            <div class="text-center">
                <span class="text-[11px] font-bold uppercase tracking-widest text-brand-600 block">Agenda del Taller</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-brand-900 tracking-tight">{{ $nombre_mes }} {{ $anio }}</h2>
            </div>

            <a href="{{ route('calendario.index', ['mes' => $mes_siguiente->month, 'anio' => $mes_siguiente->year]) }}"
                class="w-10 h-10 rounded-xl border border-brand-200 flex items-center justify-center text-2xl text-brand-900 hover:bg-brand-600 hover:text-white hover:border-brand-600 transition-colors"
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
                    <span class="w-3 h-3 rounded-full bg-brand-800 inline-block"></span>
                    Terminado / Entregado
                </span>
                <span class="flex items-center gap-1.5">
                    <span class="w-3 h-3 rounded-full bg-red-500 inline-block"></span>
                    Urgente (Hoy / Mañana / Atrasado)
                </span>
                <span class="flex items-center gap-1.5">
                    <span class="w-3 h-3 rounded-full bg-emerald-500 inline-block"></span>
                    Con margen (2+ días)
                </span>
                <span class="flex items-center gap-1.5">
                    <span class="w-3 h-3 rounded-full bg-slate-400 inline-block"></span>
                    Cancelado
                </span>
            </div>
        </div>

        {{-- Grilla del Calendario --}}
        <div class="border border-brand-200 rounded-xl overflow-hidden shadow-sm">
            <div class="grid grid-cols-7 bg-brand-100 border-b border-brand-200 text-center text-xs font-extrabold text-brand-900 uppercase tracking-wider">
                <div class="py-2.5 border-r border-brand-200">Lunes</div>
                <div class="py-2.5 border-r border-brand-200">Martes</div>
                <div class="py-2.5 border-r border-brand-200">Miércoles</div>
                <div class="py-2.5 border-r border-brand-200">Jueves</div>
                <div class="py-2.5 border-r border-brand-200">Viernes</div>
                <div class="py-2.5 border-r border-brand-200">Sábado</div>
                <div class="py-2.5">Domingo</div>
            </div>

            <div class="grid grid-cols-7 border-l border-brand-100">

                {{-- Celdas vacías antes del día 1 --}}
                @for ($i = 1; $i < $dia_semana_inicio; $i++)
                    <div class="h-28 border-r border-b border-brand-100 bg-brand-50/60"></div>
                @endfor

                {{-- Un div por cada día real del mes --}}
                @for ($dia = 1; $dia <= $dias_en_mes; $dia++)
                    @php
                        $fecha_celda = $primer_dia->copy()->day($dia)->startOfDay();
                        $es_hoy = $fecha_celda->equalTo($hoy);
                    @endphp
                    <div class="h-28 border-r border-b border-brand-100 p-1.5 text-xs relative hover:bg-brand-50 transition-colors {{ $es_hoy ? 'bg-brand-100/40 ring-2 ring-inset ring-brand-600' : 'bg-white' }}">

                        <span class="{{ $es_hoy ? 'inline-flex items-center justify-center w-5 h-5 rounded-full bg-brand-600 text-white font-bold' : 'text-brand-900/50 font-semibold' }}">
                            {{ $dia }}
                        </span>

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
                                        class="block w-full truncate text-left rounded px-1.5 py-0.5 font-medium transition-colors shadow-sm cursor-pointer {{ $clases_color }}">
                                            {{ $pedido->cliente->nombre }}
                                    </button>

                                    <div
                                        x-show="open" x-cloak x-transition
                                        @click.stop
                                        class="absolute z-30 left-0 top-full mt-1 w-56 bg-white border border-brand-200 rounded-xl shadow-xl p-3.5 text-xs text-brand-900/80 space-y-1">
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
                        </div>

                        <a href="{{ route('pedidos.nuevo', ['fecha' => $primer_dia->copy()->day($dia)->toDateString()]) }}"
                            class="absolute bottom-1 right-1 w-5 h-5 rounded-full flex items-center justify-center text-brand-600 hover:bg-brand-600 hover:text-white text-sm font-bold transition-colors"
                            title="Nuevo pedido este día">
                            +
                        </a>
                    </div>
                @endfor

                {{-- Celdas vacías al final --}}
                @php
                    $total_celdas = ($dia_semana_inicio - 1) + $dias_en_mes;
                    $celdas_sobrantes = (7 - ($total_celdas % 7)) % 7;
                @endphp
                @for ($i = 0; $i < $celdas_sobrantes; $i++)
                    <div class="h-28 border-r border-b border-brand-100 bg-brand-50/60"></div>
                @endfor

            </div>
        </div>
    </section>

</div>

@endsection
