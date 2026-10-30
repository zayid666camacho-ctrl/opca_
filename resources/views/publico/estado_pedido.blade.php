@extends('layouts.publico')

@section('title', 'Consultar Estado de Pedido — ' . $taller['nombre'])

@section('content')

<section class="py-12 sm:py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

        {{-- Buscador por correo --}}
        <div class="bg-white rounded-3xl border border-brand-200/80 shadow-sm p-6 sm:p-10 text-center">
            <span class="inline-block px-3.5 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-brand-100 text-brand-700 mb-3">
                Seguimiento en línea
            </span>
            <h1 class="text-2xl sm:text-4xl font-extrabold text-brand-900 tracking-tight">
                Consulta el estado de tu pedido
            </h1>
            <p class="mt-2 text-sm sm:text-base text-brand-900/70 max-w-xl mx-auto">
                Ingresa el correo electrónico con el que registraste tu encargo en <strong>{{ $taller['nombre'] }}</strong> para ver en qué etapa se encuentra tu prenda.
            </p>

            <form action="{{ route('sitio.estado_pedido') }}" method="GET" class="mt-6 max-w-lg mx-auto flex flex-col sm:flex-row gap-3">
                <input
                    type="email"
                    name="correo"
                    value="{{ old('correo', $correo) }}"
                    required
                    placeholder="ejemplo@correo.com"
                    class="flex-1 px-4 py-3 rounded-xl bg-brand-50/60 border border-brand-200 text-sm text-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-500"
                >
                <button
                    type="submit"
                    class="px-6 py-3 rounded-xl bg-brand-600 hover:bg-brand-700 text-white text-sm font-semibold shadow-sm transition-colors shrink-0">
                    Consultar estado
                </button>
            </form>

            @error('correo')
                <p class="text-xs text-rose-600 font-semibold mt-2">{{ $message }}</p>
            @enderror
        </div>

        {{-- Resultados cuando el cliente ya buscó un correo --}}
        @if ($correo !== null && trim($correo) !== '')

            @if ($pedidos->isEmpty())
                <div class="bg-white rounded-2xl border border-brand-200/80 p-8 text-center shadow-xs">
                    <h3 class="text-base font-bold text-brand-900">No encontramos pedidos asociados a este correo</h3>
                    <p class="text-sm text-brand-900/65 mt-1">
                        Verifica que el correo <strong>{{ $correo }}</strong> esté bien escrito o comunícate con el taller al {{ $taller['telefono'] }}.
                    </p>
                </div>
            @else
                <div class="space-y-6">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-bold text-brand-900">
                            Hola, {{ $pedidos->first()->cliente->nombre }} {{ $pedidos->first()->cliente->apellido }}
                        </h2>
                        <span class="text-xs font-semibold text-brand-900/60">
                            {{ $pedidos->count() }} {{ $pedidos->count() === 1 ? 'pedido encontrado' : 'pedidos encontrados' }}
                        </span>
                    </div>

                    @php
                        $pasos = [
                            'recibido'   => ['orden' => 1, 'titulo' => 'Recibido'],
                            'en_proceso' => ['orden' => 2, 'titulo' => 'En confección / arreglo'],
                            'terminado'  => ['orden' => 3, 'titulo' => 'Listo para entrega'],
                            'entregado'  => ['orden' => 4, 'titulo' => 'Entregado'],
                        ];
                    @endphp

                    @foreach ($pedidos as $pedido)
                        @php
                            $orden_actual = $pasos[$pedido->estado]['orden'] ?? 0;
                            $abono_pagado = max(0, $pedido->precio - $pedido->saldo_pendiente);
                        @endphp

                        <div class="bg-white rounded-2xl border border-brand-200/80 shadow-xs p-6 space-y-5">
                            <div class="flex flex-wrap items-center justify-between gap-3 pb-4 border-b border-brand-100">
                                <div>
                                    <span class="text-xs font-bold text-brand-600 uppercase tracking-wider">Pedido #{{ $pedido->id }}</span>
                                    <h3 class="text-base font-bold text-brand-900 mt-0.5">
                                        {{ $pedido->descripcion ?: 'Encargo de costura' }}
                                    </h3>
                                </div>
                                <div class="text-right text-xs text-brand-900/70">
                                    <p>Recibido: <strong>{{ $pedido->fecha }}</strong></p>
                                    <p class="mt-0.5">Entrega estimada: <strong class="text-brand-900">{{ $pedido->fecha_entrega }}</strong></p>
                                </div>
                            </div>

                            {{-- Barra de progreso del estado --}}
                            @if ($pedido->estado === 'cancelado')
                                <div class="rounded-xl bg-rose-50 border border-rose-200 p-3.5 text-xs font-semibold text-rose-700 text-center">
                                    Este pedido se encuentra cancelado.
                                </div>
                            @else
                                <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5">
                                    @foreach ($pasos as $clave => $paso)
                                        @php
                                            $completado = $orden_actual >= $paso['orden'];
                                            $es_actual  = $pedido->estado === $clave;
                                        @endphp
                                        <div class="rounded-xl p-3 border text-center transition-all {{ $es_actual ? 'bg-brand-600 text-white border-brand-600 shadow-xs' : ($completado ? 'bg-emerald-50 text-emerald-800 border-emerald-200' : 'bg-brand-50/50 text-brand-900/40 border-brand-100') }}">
                                            <span class="block text-[11px] font-bold uppercase tracking-wider">
                                                Paso {{ $paso['orden'] }}
                                            </span>
                                            <span class="block text-xs font-semibold mt-0.5">
                                                {{ $paso['titulo'] }}
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            {{-- Prendas incluidas --}}
                            @if ($pedido->servicios->isNotEmpty())
                                <div class="bg-brand-50/50 rounded-xl p-4 border border-brand-100">
                                    <h4 class="text-xs font-bold uppercase tracking-wider text-brand-900/60 mb-2">Prendas del pedido</h4>
                                    <ul class="divide-y divide-brand-100 text-xs sm:text-sm">
                                        @foreach ($pedido->servicios as $servicio)
                                            <li class="py-2 flex items-center justify-between gap-2">
                                                <div>
                                                    <span class="font-semibold text-brand-900">{{ $servicio->precio_base->nombre_prenda ?? 'Prenda' }}</span>
                                                    <span class="text-brand-900/60">· {{ $servicio->tipo_servicio->nombre ?? ucfirst($servicio->tipo_servicio->servicio ?? '') }}</span>
                                                    @if ($servicio->descripcion)
                                                        <p class="text-xs text-brand-900/60">{{ $servicio->descripcion }}</p>
                                                    @endif
                                                </div>
                                                <span class="font-semibold text-brand-900">${{ number_format($servicio->precio, 2) }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            {{-- Resumen económico del pedido --}}
                            <div class="flex flex-wrap items-center justify-end gap-6 pt-2 text-xs sm:text-sm">
                                <div>
                                    <span class="text-brand-900/60">Total del pedido:</span>
                                    <strong class="text-brand-900 ml-1">${{ number_format($pedido->precio, 2) }}</strong>
                                </div>
                                <div>
                                    <span class="text-brand-900/60">Abonado:</span>
                                    <strong class="text-emerald-700 ml-1">${{ number_format($abono_pagado, 2) }}</strong>
                                </div>
                                <div>
                                    <span class="text-brand-900/60">Saldo pendiente:</span>
                                    <strong class="{{ $pedido->saldo_pendiente > 0 ? 'text-rose-600' : 'text-emerald-700' }} ml-1">
                                        ${{ number_format($pedido->saldo_pendiente, 2) }}
                                    </strong>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

        @endif

    </div>
</section>

@endsection