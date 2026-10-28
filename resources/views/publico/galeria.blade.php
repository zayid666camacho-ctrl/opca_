{{--
    OPCA — Galería Pública de Trabajos (Sprint 9)
    Vista dedicada para clientes y visitantes (HU29).
    - Ordenada de más reciente a más antigua (Regla de negocio 11).
    - Paleta C: Morado / Lavanda + Dorado + Rosa.
--}}

@extends('layouts.publico')

@section('title', 'Galería de Trabajos — Creaciones Nayja')

@section('content')
<div class="py-12 sm:py-16 bg-brand-50 min-h-screen" x-data="{ 
    categoriaActiva: 'todas',
    modalFoto: null,
    modalTitulo: ''
}">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Encabezado y migas de pan --}}
        <div class="mb-10 text-center max-w-2xl mx-auto">
            <a href="{{ route('sitio.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-brand-600 hover:text-brand-800 transition-colors mb-3">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Volver al Inicio
            </a>
            <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight text-brand-900">Galería de Trabajos Realizados</h1>
            <p class="text-brand-900/70 text-sm sm:text-base mt-2">
                Confecciones sobre medidas, transformaciones y arreglos terminados en el taller. Haz clic en cualquier prenda para verla en detalle o cotizar una similar.
            </p>
        </div>

        {{-- Barra de Filtros por Categoría --}}
        @if ($categorias_galeria->isNotEmpty())
            <div class="flex flex-wrap items-center justify-center gap-2 mb-12">
                <button
                    type="button"
                    @click="categoriaActiva = 'todas'"
                    :class="categoriaActiva === 'todas' 
                        ? 'bg-brand-600 text-white shadow-sm' 
                        : 'bg-white text-brand-900 hover:bg-brand-100 border border-brand-200'"
                    class="px-4 py-2 rounded-full text-xs font-semibold transition-all">
                    Todos los trabajos ({{ $galeria->count() }})
                </button>

                @foreach ($categorias_galeria as $cat)
                    @php $slug = strtolower(trim($cat)); @endphp
                    <button
                        type="button"
                        @click="categoriaActiva = '{{ $slug }}'"
                        :class="categoriaActiva === '{{ $slug }}' 
                            ? 'bg-brand-600 text-white shadow-sm' 
                            : 'bg-white text-brand-900 hover:bg-brand-100 border border-brand-200'"
                        class="px-4 py-2 rounded-full text-xs font-semibold transition-all">
                        {{ $cat }}
                    </button>
                @endforeach
            </div>
        @endif

        {{-- Cuadrícula de Fotos (HU29) --}}
        @if ($galeria->isEmpty())
            <div class="bg-white rounded-3xl border border-brand-100 p-16 text-center max-w-lg mx-auto shadow-sm">
                <div class="w-16 h-16 rounded-full bg-brand-100 text-brand-600 mx-auto flex items-center justify-center mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h3 class="text-base font-bold text-brand-900">Aún no hay fotos en la galería</h3>
                <p class="text-sm text-brand-900/60 mt-1">Pronto publicaremos fotos de nuestras confecciones más recientes.</p>
                <a href="{{ route('sitio.index') }}" class="inline-block mt-5 px-5 py-2.5 bg-brand-600 hover:bg-brand-700 text-white text-xs font-semibold rounded-xl">
                    Volver al Inicio
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($galeria as $item)
                    @php 
                        $slugItem = strtolower(trim($item->categoria ?? 'sin-categoria'));
                        $url = $item->url_imagen();
                    @endphp
                    <div 
                        x-show="categoriaActiva === 'todas' || categoriaActiva === '{{ $slugItem }}'"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100"
                        class="bg-white rounded-2xl border border-brand-100 shadow-sm overflow-hidden flex flex-col justify-between group hover:shadow-md hover:border-brand-200 transition-all">
                        
                        {{-- Imagen --}}
                        <div 
                            class="relative aspect-square w-full bg-brand-50 overflow-hidden cursor-pointer"
                            @click="modalFoto = '{{ $url }}'; modalTitulo = '{{ addslashes($item->titulo) }}'">
                            <img 
                                src="{{ $url }}" 
                                alt="{{ $item->titulo }}"
                                loading="lazy"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">

                            @if ($item->categoria)
                                <span class="absolute top-3 left-3 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-white/95 backdrop-blur-sm text-brand-700 border border-brand-100 shadow-sm">
                                    {{ $item->categoria }}
                                </span>
                            @endif

                            <div class="absolute inset-0 bg-brand-900/25 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                <span class="p-2 bg-white/90 rounded-full text-brand-900 shadow">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7"/>
                                    </svg>
                                </span>
                            </div>
                        </div>

                        {{-- Información del trabajo --}}
                        <div class="p-5 flex-1 flex flex-col justify-between">
                            <div>
                                <span class="text-[11px] text-brand-900/50 font-medium">
                                    {{ date('d/m/Y', strtotime($item->fecha)) }}
                                </span>
                                <h3 class="font-bold text-brand-900 text-base mt-0.5 leading-snug">
                                    {{ $item->titulo }}
                                </h3>
                                @if ($item->descripcion)
                                    <p class="text-xs text-brand-900/70 mt-1.5 leading-relaxed line-clamp-3">
                                        {{ $item->descripcion }}
                                    </p>
                                @endif
                            </div>

                            <div class="pt-4 mt-4 border-t border-brand-100 flex items-center justify-between">
                                <span class="text-[11px] text-brand-900/50 font-medium">{{ $item->realizado_por }}</span>
                                <a 
                                    href="https://wa.me/{{ $taller['whatsapp'] }}?text={{ urlencode('¡Hola Creaciones Nayja! Me encantó la prenda ' . $item->titulo . ' que vi en su galería. ¿Podríamos cotizar algo similar?') }}" 
                                    target="_blank" 
                                    rel="noopener noreferrer"
                                    class="inline-flex items-center gap-1 text-xs font-semibold text-brand-600 hover:text-brand-800 transition-colors">
                                    Cotizar similar &rarr;
                                </a>
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>
        @endif

    </div>

    {{-- Lightbox Modal Ampliado --}}
    <div 
        x-show="modalFoto" 
        x-cloak 
        @click.away="modalFoto = null"
        class="fixed inset-0 z-50 overflow-y-auto bg-brand-900/85 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="relative max-w-3xl w-full bg-white rounded-2xl overflow-hidden shadow-2xl">
            <button 
                @click="modalFoto = null" 
                class="absolute top-3 right-3 z-10 p-2 bg-white/80 rounded-full text-brand-900 hover:bg-white shadow transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
            <div class="max-h-[80vh] bg-slate-950 flex items-center justify-center overflow-hidden">
                <img :src="modalFoto" :alt="modalTitulo" class="max-h-[80vh] w-auto object-contain">
            </div>
            <div class="p-4 bg-white border-t border-brand-100 flex items-center justify-between">
                <span class="font-bold text-brand-900 text-sm" x-text="modalTitulo"></span>
                <button @click="modalFoto = null" class="text-xs font-semibold text-brand-600 hover:text-brand-900">Cerrar</button>
            </div>
        </div>
    </div>

</div>
@endsection
