{{--
    OPCA — Pantalla Principal del Panel de Administración (Hub Superior + Calendario)
    - Sin sidebar lateral y sin redundancia de botones: cada módulo aparece una sola vez con íconos vectoriales de trazo fino.
    - Abajo: Calendario mensual interactivo de pedidos.
--}}
@extends('layouts.module')

@section('title', 'Panel y Calendario')
@section('page-title', 'Panel Principal')

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
         1. HUB SUPERIOR: "PANEL DE ADMINISTRACIÓN: TU ESPACIO NAYJA"
         (6 módulos únicos con ícono de trazo fino, fiel a la composición guía)
         ===================================================================== --}}
    <section class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-[#2B161C] via-brand-900 to-[#18181D] text-white p-7 sm:p-10 shadow-xl border border-white/10">
        <div class="pointer-events-none absolute -top-24 left-1/3 w-96 h-96 rounded-full bg-brand-600/20 blur-3xl"></div>

        <div class="relative z-10">
            <div>
                <h2 class="text-2xl sm:text-4xl font-extrabold tracking-tight text-white">
                    Panel de Administración: Tu Espacio NAyJA
                </h2>
                <p class="mt-2 text-xs sm:text-sm text-slate-300 max-w-3xl leading-relaxed">
                    ¡Bienvenida a tu panel, <strong class="font-bold text-white">{{ auth()->user()->name ?? 'Administradora NAyJA' }}</strong>! Aquí puedes gestionar tus proyectos, revisar tus módulos y mantener el control del taller. La perfección está a un clic.
                </p>
            </div>

            {{-- Cuadrícula de 6 módulos únicos (sin botones repetidos ni emojis) --}}
            <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-6">

                {{-- 1. Pedidos Activos (Kanban) --}}
                <a href="{{ route('pedidos.kanban') }}" class="group flex items-start gap-4 p-3.5 rounded-xl bg-white/[0.03] hover:bg-white/[0.08] border border-white/10 hover:border-brand-500/60 transition-all">
                    <div class="w-10 h-10 rounded-lg border border-brand-500/80 text-brand-500 flex items-center justify-center shrink-0 group-hover:bg-brand-600 group-hover:border-brand-600 group-hover:text-white transition-all">
                        <span class="w-5 h-5">@include('layouts.partials.icons', ['icon' => 'clipboard-check'])</span>
                    </div>
                    <div>
                        <h3 class="text-base font-extrabold text-white group-hover:text-brand-200 transition-colors">
                            Pedidos Activos (Kanban)
                        </h3>
                        <p class="mt-1 text-xs text-slate-300 leading-relaxed">
                            Gestiona el flujo de entregas y el historial de encargos en confección y arreglo.
                        </p>
                    </div>
                </a>

                {{-- 2. Estado de Cuenta (Finanzas) --}}
                <a href="{{ route('finanzas.index') }}" class="group flex items-start gap-4 p-3.5 rounded-xl bg-white/[0.03] hover:bg-white/[0.08] border border-white/10 hover:border-brand-500/60 transition-all">
                    <div class="w-10 h-10 rounded-lg border border-brand-500/80 text-brand-500 flex items-center justify-center shrink-0 group-hover:bg-brand-600 group-hover:border-brand-600 group-hover:text-white transition-all">
                        <span class="w-5 h-5">@include('layouts.partials.icons', ['icon' => 'file-dollar'])</span>
                    </div>
                    <div>
                        <h3 class="text-base font-extrabold text-white group-hover:text-brand-200 transition-colors">
                            Estado de Cuenta y Finanzas
                        </h3>
                        <p class="mt-1 text-xs text-slate-300 leading-relaxed">
                            Revisa ingresos mensuales, abonos, saldos pendientes por cobrar y reportes Excel.
                        </p>
                    </div>
                </a>

                {{-- 3. Inventario de Materiales --}}
                <a href="{{ route('inventario.index') }}" class="group flex items-start gap-4 p-3.5 rounded-xl bg-white/[0.03] hover:bg-white/[0.08] border border-white/10 hover:border-brand-500/60 transition-all">
                    <div class="w-10 h-10 rounded-lg border border-brand-500/80 text-brand-500 flex items-center justify-center shrink-0 group-hover:bg-brand-600 group-hover:border-brand-600 group-hover:text-white transition-all">
                        <span class="w-5 h-5">@include('layouts.partials.icons', ['icon' => 'box'])</span>
                    </div>
                    <div>
                        <h3 class="text-base font-extrabold text-white group-hover:text-brand-200 transition-colors">
                            Inventario de Materiales
                        </h3>
                        <p class="mt-1 text-xs text-slate-300 leading-relaxed">
                            Controla telas, hilos e insumos con alertas automáticas de stock mínimo.
                        </p>
                    </div>
                </a>

                {{-- 4. Galería de Trabajos --}}
                <a href="{{ route('galeria.index') }}" class="group flex items-start gap-4 p-3.5 rounded-xl bg-white/[0.03] hover:bg-white/[0.08] border border-white/10 hover:border-brand-500/60 transition-all">
                    <div class="w-10 h-10 rounded-lg border border-brand-500/80 text-brand-500 flex items-center justify-center shrink-0 group-hover:bg-brand-600 group-hover:border-brand-600 group-hover:text-white transition-all">
                        <span class="w-5 h-5">@include('layouts.partials.icons', ['icon' => 'photo'])</span>
                    </div>
                    <div>
                        <h3 class="text-base font-extrabold text-white group-hover:text-brand-200 transition-colors">
                            Galería de Trabajos
                        </h3>
                        <p class="mt-1 text-xs text-slate-300 leading-relaxed">
                            Publica y administra el portafolio fotográfico de prendas terminadas en la web.
                        </p>
                    </div>
                </a>

                {{-- 5. Directorio de Clientes y Medidas --}}
                <a href="{{ route('clientes.index') }}" class="group flex items-start gap-4 p-3.5 rounded-xl bg-white/[0.03] hover:bg-white/[0.08] border border-white/10 hover:border-brand-500/60 transition-all">
                    <div class="w-10 h-10 rounded-lg border border-brand-500/80 text-brand-500 flex items-center justify-center shrink-0 group-hover:bg-brand-600 group-hover:border-brand-600 group-hover:text-white transition-all">
                        <span class="w-5 h-5">@include('layouts.partials.icons', ['icon' => 'users'])</span>
                    </div>
                    <div>
                        <h3 class="text-base font-extrabold text-white group-hover:text-brand-200 transition-colors">
                            Clientes y Medidas
                        </h3>
                        <p class="mt-1 text-xs text-slate-300 leading-relaxed">
                            Consulta fichas de contacto y medidas corporales en CM reutilizables en cada pedido.
                        </p>
                    </div>
                </a>

                {{-- 6. Catálogo de Precios Base --}}
                <a href="{{ route('precio_bases.index') }}" class="group flex items-start gap-4 p-3.5 rounded-xl bg-white/[0.03] hover:bg-white/[0.08] border border-white/10 hover:border-brand-500/60 transition-all">
                    <div class="w-10 h-10 rounded-lg border border-brand-500/80 text-brand-500 flex items-center justify-center shrink-0 group-hover:bg-brand-600 group-hover:border-brand-600 group-hover:text-white transition-all">
                        <span class="w-5 h-5">@include('layouts.partials.icons', ['icon' => 'tag'])</span>
                    </div>
                    <div>
                        <h3 class="text-base font-extrabold text-white group-hover:text-brand-200 transition-colors">
                            Precios Base y Tarifas
                        </h3>
                        <p class="mt-1 text-xs text-slate-300 leading-relaxed">
                            Define las prendas y tarifas de referencia según su nivel de complejidad.
                        </p>
                    </div>
                </a>

            </div>
        </div>
    </section>

    {{-- =====================================================================
         2. CALENDARIO MENSUAL DE PEDIDOS (A ANCHO COMPLETO)
         ===================================================================== --}}
    <section class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 sm:p-8">

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
        <div class="border border-slate-200 rounded-lg">
            <div class="grid grid-cols-7 bg-slate-50 border-b border-slate-200 rounded-t-lg text-center text-xs font-bold text-brand-900 uppercase tracking-wider">
                <div class="py-2.5 border-r border-slate-200">Lunes</div>
                <div class="py-2.5 border-r border-slate-200">Martes</div>
                <div class="py-2.5 border-r border-slate-200">Miércoles</div>
                <div class="py-2.5 border-r border-slate-200">Jueves</div>
                <div class="py-2.5 border-r border-slate-200">Viernes</div>
                <div class="py-2.5 border-r border-slate-200">Sábado</div>
                <div class="py-2.5">Domingo</div>
            </div>

            <div class="grid grid-cols-7 border-l border-slate-100">

                {{-- Celdas vacías antes del día 1 --}}
                @for ($i = 1; $i < $dia_semana_inicio; $i++)
                    <div class="h-28 border-r border-b border-slate-100 bg-slate-50/50"></div>
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
                    <div class="h-28 border-r border-b border-slate-100 p-1.5 text-xs relative hover:bg-slate-50/80 transition-colors {{ $es_hoy ? 'bg-brand-50/50 ring-2 ring-inset ring-brand-600' : 'bg-white' }}">

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

                        <a href="{{ route('pedidos.nuevo', ['fecha' => $primer_dia->copy()->day($dia)->toDateString()]) }}"
                            class="absolute bottom-1 right-1 w-5 h-5 rounded flex items-center justify-center text-brand-600 hover:bg-brand-600 hover:text-white text-sm font-bold transition-colors"
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
                    <div class="h-28 border-r border-b border-slate-100 bg-slate-50/50"></div>
                @endfor

            </div>
        </div>
    </section>

</div>

@endsection
