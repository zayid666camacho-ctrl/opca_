{{--
    OPCA — Pantalla Principal del Panel de Administración (Hub de Módulos)
    - Vista dedicada al ingresar al sistema.
    - Cuadrícula de 6 módulos únicos encabezada por el Calendario de Pedidos.
--}}
@extends('layouts.module')

@section('title', 'Panel Principal')
@section('page-title', 'Panel Principal')

@section('content')

<div class="max-w-7xl mx-auto">

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

            {{-- Cuadrícula de 6 módulos únicos --}}
            <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-6">

                {{-- 1. Calendario de Pedidos --}}
                <a href="{{ route('calendario.index') }}" class="group flex items-start gap-4 p-3.5 rounded-xl bg-white/[0.03] hover:bg-white/[0.08] border border-white/10 hover:border-brand-500/60 transition-all">
                    <div class="w-10 h-10 rounded-lg border border-brand-500/80 text-brand-500 flex items-center justify-center shrink-0 group-hover:bg-brand-600 group-hover:border-brand-600 group-hover:text-white transition-all">
                        <span class="w-5 h-5">@include('layouts.partials.icons', ['icon' => 'calendar'])</span>
                    </div>
                    <div>
                        <h3 class="text-base font-extrabold text-white group-hover:text-brand-200 transition-colors">
                            Calendario de Pedidos
                        </h3>
                        <p class="mt-1 text-xs text-slate-300 leading-relaxed">
                            Agenda mensual interactiva de entregas, urgencias y creación rápida de encargos por fecha.
                        </p>
                    </div>
                </a>

                {{-- 2. Pedidos Activos (Kanban) --}}
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

                {{-- 3. Estado de Cuenta (Finanzas) --}}
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

</div>

@endsection
