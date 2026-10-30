{{--
    OPCA — Catálogo Público de Tarifas y Precios Base
    Vista dedicada para clientes y visitantes del taller Creaciones Nayja.
    - Incluye enlace a WhatsApp con referencia única (?prenda=ID#prenda-ID).
--}}

@extends('layouts.publico')

@section('title', 'Tarifas y Precios de Referencia — Creaciones Nayja')

@section('content')
@php
    $prendaDestacadaId = (int) request()->query('prenda', 0);
@endphp

<div class="py-12 sm:py-16 bg-brand-50 min-h-screen" x-data="{
    buscar: '',
    complejidadFiltro: 'todas',
    destacadaId: {{ $prendaDestacadaId ?: 'null' }},
    coincide(item) {
        const textoMatch = !this.buscar || item.nombre_prenda.toLowerCase().includes(this.buscar.toLowerCase()) || (item.descripcion && item.descripcion.toLowerCase().includes(this.buscar.toLowerCase()));
        const complejidadMatch = this.complejidadFiltro === 'todas' || item.complejidad.toLowerCase() === this.complejidadFiltro.toLowerCase();
        return textoMatch && complejidadMatch;
    }
}">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Encabezado y navegación --}}
        <div class="mb-10 text-center max-w-2xl mx-auto">
            <a href="{{ route('sitio.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-brand-600 hover:text-brand-800 transition-colors mb-3">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Volver al Inicio
            </a>
            <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight text-brand-900">Tarifas y Precios de Referencia</h1>
            <p class="text-brand-900/70 text-sm sm:text-base mt-2">
                Consulta nuestras tarifas base de confección y arreglo. Los precios son valores de referencia y pueden adaptarse según telas especiales o detalles personalizados.
            </p>
        </div>

        {{-- Barra de Búsqueda y Filtros de Complejidad --}}
        <div class="bg-white p-4 rounded-2xl border border-brand-100 shadow-sm max-w-3xl mx-auto mb-10 flex flex-col sm:flex-row gap-3">
            <div class="flex-1 relative">
                <input
                    type="text"
                    x-model="buscar"
                    placeholder="Buscar prenda (ej: camisa, pantalón, vestido)..."
                    class="w-full pl-10 pr-4 py-2 border border-brand-200 rounded-xl text-sm text-brand-900 placeholder-brand-900/40 focus:outline-none focus:ring-2 focus:ring-brand-100 focus:border-brand-600">
                <svg class="w-4 h-4 text-brand-600/60 absolute left-3.5 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>

            <div class="sm:w-52">
                <select
                    x-model="complejidadFiltro"
                    class="w-full px-3 py-2 border border-brand-200 rounded-xl text-sm text-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-100 focus:border-brand-600">
                    <option value="todas">Toda complejidad</option>
                    <option value="baja">Complejidad Baja</option>
                    <option value="media">Complejidad Media</option>
                    <option value="alta">Complejidad Alta</option>
                </select>
            </div>
        </div>

        {{-- Cuadrícula de Tarjetas de Precios Base --}}
        @if ($precios->isEmpty())
            <div class="bg-white rounded-3xl border border-brand-100 p-16 text-center max-w-lg mx-auto shadow-sm">
                <p class="text-brand-900/70 text-sm">No hay tarifas registradas en este momento.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($precios as $item)
                    @php 
                        $itemJson = json_encode([
                            'id' => $item->id,
                            'nombre_prenda' => $item->nombre_prenda,
                            'complejidad' => $item->complejidad,
                            'descripcion' => $item->descripcion ?? '',
                            'precio' => (float) $item->precio,
                        ]);
                        $complejidadLower = strtolower($item->complejidad);
                        $urlDirectaTarifa = route('sitio.precios', ['prenda' => $item->id]) . '#prenda-' . $item->id;
                        $mensajeTarifa = "¡Hola Creaciones Nayja! Me interesa cotizar esta prenda de su catálogo de tarifas:\n"
                            . "• Prenda: {$item->nombre_prenda} (Ref. #{$item->id} · Complejidad {$item->complejidad})\n"
                            . "• Tarifa base: $" . number_format($item->precio, 0, ',', '.') . " COP\n"
                            . "• Ver referencia: {$urlDirectaTarifa}";
                    @endphp

                    <div 
                        id="prenda-{{ $item->id }}"
                        x-show="coincide({{ $itemJson }})"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100"
                        :class="destacadaId === {{ $item->id }} ? 'ring-2 ring-brand-600 border-brand-600 shadow-lg' : 'border-brand-100 hover:border-brand-200 shadow-sm hover:shadow-md'"
                        class="bg-white rounded-2xl border p-6 transition-all flex flex-col justify-between group">
                        
                        <div>
                            {{-- Cabecera de la tarjeta --}}
                            <div class="flex items-start justify-between gap-3 mb-3">
                                <div>
                                    <span class="text-[10px] font-bold text-brand-900/45 uppercase tracking-wider block">Ref. #{{ $item->id }}</span>
                                    <h3 class="text-lg font-bold text-brand-900 leading-snug group-hover:text-brand-600 transition-colors">
                                        {{ $item->nombre_prenda }}
                                    </h3>
                                </div>

                                {{-- Badge de Complejidad --}}
                                @if ($complejidadLower === 'baja')
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200 shrink-0">
                                        Baja
                                    </span>
                                @elseif ($complejidadLower === 'media')
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-gold-100 text-gold-600 border border-gold-500/30 shrink-0">
                                        Media
                                    </span>
                                @else
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-brand-100 text-brand-700 border border-brand-200 shrink-0">
                                        Alta
                                    </span>
                                @endif
                            </div>

                            {{-- Precio de Referencia --}}
                            <div class="mb-4">
                                <span class="text-xs text-brand-900/50 font-medium block">Tarifa base sugerida</span>
                                <p class="text-3xl font-extrabold text-brand-900 tracking-tight">
                                    ${{ number_format($item->precio, 0, ',', '.') }}
                                    <span class="text-xs text-brand-900/60 font-normal">COP</span>
                                </p>
                            </div>

                            {{-- Descripción o detalles --}}
                            @if ($item->descripcion)
                                <p class="text-xs text-brand-900/70 leading-relaxed pt-3 border-t border-brand-100">
                                    {{ $item->descripcion }}
                                </p>
                            @else
                                <p class="text-xs text-brand-900/40 italic pt-3 border-t border-brand-100">
                                    Confección sobre medidas anatómicas o arreglo especializado.
                                </p>
                            @endif
                        </div>

                        {{-- Botón de Acción a WhatsApp --}}
                        <div class="pt-5 mt-5 border-t border-brand-100">
                            <a 
                                href="https://wa.me/{{ $taller['whatsapp'] }}?text={{ urlencode($mensajeTarifa) }}" 
                                target="_blank" 
                                rel="noopener noreferrer"
                                class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-brand-600 hover:bg-brand-700 text-white text-xs font-semibold rounded-xl transition-colors shadow-sm">
                                <svg class="w-4 h-4 text-emerald-300" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.598 2.664-.698c.974.53 1.83.81 2.796.81 3.183 0 5.77-2.587 5.77-5.766.001-3.182-2.585-5.767-5.77-5.767zm0 10.372c-.876 0-1.704-.265-2.428-.73l-.174-.108-1.799.472.48-1.753-.119-.189c-.524-.834-.8-1.748-.799-2.698.001-2.535 2.062-4.596 4.598-4.596 2.537 0 4.598 2.061 4.598 4.596 0 2.536-2.061 4.596-4.598 4.596z"/>
                                </svg>
                                Cotizar esta prenda
                            </a>
                        </div>

                    </div>
                @endforeach
            </div>
        @endif

        {{-- Nota aclaratoria de precios al cliente --}}
        <div class="mt-12 max-w-2xl mx-auto p-4 rounded-xl bg-brand-100/70 border border-brand-200 text-brand-900/80 text-xs text-center leading-relaxed">
            <span class="font-bold text-brand-900">Nota para clientes:</span> Los precios mostrados corresponden a tarifas base de mano de obra y confección. El valor final puede variar de acuerdo a la tela seleccionada, forros, apliques o modificaciones especiales que requiera tu diseño.
        </div>

    </div>
</div>
@endsection
