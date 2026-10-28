{{--
    OPCA — Panel de Galería y Portafolio de Trabajos (Sprint 9)
    Vista administrativa para gestionar los trabajos fotográficos del taller Creaciones Nayja.

    Historias de usuario cubiertas:
    - HU27: Subir imágenes de trabajos finalizados (título, descripción, categoría y foto).
    - HU28: Administrar, editar, alternar visibilidad pública y eliminar fotos (limpiando archivo en storage).
--}}

@extends('layouts.app')

@section('title', 'Galería de Trabajos')

@section('content')

{{--
    Estado reactivo con Alpine.js:
    - modalCrear / modalEditar: control de apertura de modales.
    - previsualizacionCrear / previsualizacionEditar: vista previa instantánea de fotos antes de subir.
    - trabajoSeleccionado: objeto para edición.
--}}
<div x-data="{
    modalCrear: false,
    modalEditar: false,
    previsualizacionCrear: null,
    previsualizacionEditar: null,
    trabajoSeleccionado: {
        id: null,
        titulo: '',
        descripcion: '',
        categoria: '',
        fecha: '',
        visible_publico: true,
        imagen_url: ''
    },
    abrirEditar(trabajo, urlImagen) {
        this.trabajoSeleccionado = {
            id: trabajo.id,
            titulo: trabajo.titulo,
            descripcion: trabajo.descripcion || '',
            categoria: trabajo.categoria || '',
            fecha: trabajo.fecha ? trabajo.fecha.substring(0, 10) : '',
            visible_publico: Boolean(trabajo.visible_publico),
            imagen_url: urlImagen
        };
        this.previsualizacionEditar = null;
        this.modalEditar = true;
    },
    cargarPrevisualizacion(event, destino) {
        const archivo = event.target.files[0];
        if (!archivo) return;
        const lector = new FileReader();
        lector.onload = (e) => {
            if (destino === 'crear') this.previsualizacionCrear = e.target.result;
            if (destino === 'editar') this.previsualizacionEditar = e.target.result;
        };
        lector.readAsDataURL(archivo);
    }
}" class="space-y-6">

    {{-- =====================================================================
        1. ENCABEZADO Y BOTÓN DE ACCIÓN PRINCIPAL
        ===================================================================== --}}
    @if ($errors->any())
        <div class="rounded-xl border border-rose-300 bg-rose-50 p-4 text-rose-800 text-sm shadow-sm">
            <h4 class="font-bold text-rose-900 mb-1">No se pudo subir el trabajo:</h4>
            <ul class="list-disc list-inside space-y-0.5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-neutral-900">Galería de Trabajos</h1>
            <p class="text-sm text-neutral-500 mt-0.5">Catálogo visual de confecciones, arreglos y prendas terminadas.</p>
        </div>
        <div>
            <button
                type="button"
                @click="modalCrear = true"
                class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg bg-neutral-900 text-white text-sm font-semibold hover:bg-neutral-800 focus:outline-none focus:ring-2 focus:ring-neutral-400 transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Subir Trabajo
            </button>
        </div>
    </div>

    {{-- =====================================================================
        2. TARJETAS DE MÉTRICAS RÁPIDAS
        ===================================================================== --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm">
            <span class="text-xs font-medium text-neutral-500 uppercase tracking-wider">Total de Trabajos</span>
            <p class="text-2xl font-bold text-neutral-900 mt-1">{{ $trabajos->count() }}</p>
        </div>
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm">
            <span class="text-xs font-medium text-emerald-600 uppercase tracking-wider font-semibold">Públicos en la Web</span>
            <p class="text-2xl font-bold text-emerald-700 mt-1">{{ $trabajos->where('visible_publico', true)->count() }}</p>
        </div>
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm">
            <span class="text-xs font-medium text-neutral-500 uppercase tracking-wider">Ocultos / Privados</span>
            <p class="text-2xl font-bold text-neutral-600 mt-1">{{ $trabajos->where('visible_publico', false)->count() }}</p>
        </div>
    </div>

    {{-- =====================================================================
        3. FILTRADO POR CATEGORÍA
        ===================================================================== --}}
    <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex flex-col sm:flex-row items-center justify-between gap-3">
        <form method="GET" action="{{ route('galeria.index') }}" class="flex items-center gap-3 w-full sm:w-auto">
            <label class="text-xs font-semibold text-neutral-600 uppercase tracking-wider shrink-0">Filtrar:</label>
            <select
                name="categoria"
                onchange="this.form.submit()"
                class="px-3 py-2 border border-slate-300 rounded-lg text-sm text-neutral-900 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-300 w-full sm:w-56">
                <option value="">Todas las categorías</option>
                @foreach ($categorias as $cat)
                    <option value="{{ $cat }}" {{ $categoria == $cat ? 'selected' : '' }}>
                        {{ $cat }}
                    </option>
                @endforeach
            </select>
            @if ($categoria)
                <a href="{{ route('galeria.index') }}" class="px-3 py-2 bg-slate-100 text-neutral-700 text-xs font-medium rounded-lg hover:bg-slate-200 transition-colors">
                    Limpiar
                </a>
            @endif
        </form>

        <span class="text-xs text-neutral-500">
            Ordenado de más reciente a más antiguo (Regla #11)
        </span>
    </div>

    {{-- =====================================================================
        4. CUADRÍCULA DE FOTOS / TRABAJOS (HU27, HU28)
        ===================================================================== --}}
    @if ($trabajos->isEmpty())
        <div class="bg-white rounded-2xl border border-slate-200 p-12 text-center shadow-sm">
            <div class="w-16 h-16 rounded-full bg-slate-100 text-neutral-400 mx-auto flex items-center justify-center mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <h3 class="text-base font-bold text-neutral-900">Aún no hay trabajos en la galería</h3>
            <p class="text-sm text-neutral-500 mt-1 max-w-sm mx-auto">Sube fotos de tus confecciones, arreglos o diseños finalizados para mostrarlos a tus clientes.</p>
            <button
                type="button"
                @click="modalCrear = true"
                class="mt-5 px-4 py-2 bg-neutral-900 text-white text-sm font-semibold rounded-lg hover:bg-neutral-800 transition-colors">
                Subir primer trabajo
            </button>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach ($trabajos as $item)
                @php $urlImagen = $item->url_imagen(); @endphp
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden flex flex-col justify-between hover:shadow-md transition-shadow group">
                    
                    {{-- Miniatura de la imagen --}}
                    <div class="relative aspect-square w-full bg-slate-100 overflow-hidden">
                        <img
                            src="{{ $urlImagen }}"
                            alt="{{ $item->titulo }}"
                            loading="lazy"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">

                        {{-- Badge de Categoría --}}
                        @if ($item->categoria)
                            <span class="absolute top-3 left-3 px-2.5 py-1 rounded-full text-xs font-semibold bg-white/90 backdrop-blur-sm text-neutral-800 shadow-sm">
                                {{ $item->categoria }}
                            </span>
                        @endif

                        {{-- Indicador de visibilidad --}}
                        <div class="absolute top-3 right-3">
                            @if ($item->visible_publico)
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[11px] font-semibold bg-emerald-500 text-white shadow-sm" title="Visible para clientes">
                                    <span class="w-1.5 h-1.5 rounded-full bg-white"></span>
                                    Público
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[11px] font-semibold bg-neutral-700 text-neutral-200 shadow-sm" title="Solo visible para la administradora">
                                    Oculto
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- Información del trabajo --}}
                    <div class="p-4 flex-1 flex flex-col justify-between space-y-3">
                        <div>
                            <span class="text-[11px] text-neutral-400 font-medium">
                                {{ date('d/m/Y', strtotime($item->fecha)) }}
                            </span>
                            <h3 class="font-bold text-neutral-900 text-sm mt-0.5 leading-snug">
                                {{ $item->titulo }}
                            </h3>
                            @if ($item->descripcion)
                                <p class="text-xs text-neutral-500 mt-1 line-clamp-2">
                                    {{ $item->descripcion }}
                                </p>
                            @endif
                        </div>

                        {{-- Barra inferior de acciones (HU28) --}}
                        <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                            {{-- Botón para alternar visibilidad pública --}}
                            <form action="{{ route('galeria.visibilidad', $item->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button
                                    type="submit"
                                    class="text-xs font-medium {{ $item->visible_publico ? 'text-neutral-500 hover:text-amber-600' : 'text-emerald-600 hover:text-emerald-700' }} transition-colors"
                                    title="{{ $item->visible_publico ? 'Ocultar de la web pública' : 'Mostrar en la web pública' }}">
                                    {{ $item->visible_publico ? 'Ocultar' : 'Hacer público' }}
                                </button>
                            </form>

                            <div class="flex items-center gap-3">
                                {{-- Botón Editar --}}
                                <button
                                    type="button"
                                    @click='abrirEditar(@json($item), "{{ $urlImagen }}")'
                                    class="text-xs font-semibold text-blue-600 hover:text-blue-800 transition-colors">
                                    Editar
                                </button>

                                {{-- Botón Eliminar --}}
                                <form
                                    action="{{ route('galeria.destroy', $item->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('¿Seguro que deseas eliminar este trabajo y su imagen de la galería?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs font-semibold text-rose-600 hover:text-rose-800 transition-colors">
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            @endforeach
        </div>
    @endif

    {{-- =====================================================================
         5. MODAL PARA SUBIR NUEVO TRABAJO (HU27)
         Formulario con subida de archivo (enctype="multipart/form-data")
         ===================================================================== --}}
    <div
        x-show="modalCrear"
        x-cloak
        class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/50 flex items-center justify-center p-4">
        <div
            @click.away="modalCrear = false"
            class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-xl space-y-4">

            <div class="flex items-center justify-between border-b border-slate-200 pb-3">
                <h3 class="text-lg font-bold text-neutral-900">Subir Trabajo a la Galería</h3>
                <button @click="modalCrear = false" class="text-neutral-400 hover:text-neutral-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form action="{{ route('galeria.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf

                {{-- Campo para seleccionar y previsualizar imagen --}}
                <div>
                    <label class="block text-xs font-semibold text-neutral-700 uppercase tracking-wider mb-1">Fotografía del trabajo *</label>
                    
                    <div class="border-2 border-dashed border-slate-300 rounded-xl p-4 text-center hover:border-slate-400 transition-colors bg-slate-50/50">
                        <template x-if="previsualizacionCrear">
                            <div class="mb-3">
                                <img :src="previsualizacionCrear" class="max-h-48 mx-auto rounded-lg object-contain shadow-sm">
                            </div>
                        </template>

                        <input
                            type="file"
                            name="imagen"
                            accept="image/*"
                            required
                            @change="cargarPrevisualizacion($event, 'crear')"
                            class="w-full text-xs text-neutral-500 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-neutral-900 file:text-white hover:file:bg-neutral-800 cursor-pointer">
                        <p class="text-[11px] text-neutral-400 mt-1.5">Formatos: JPG, PNG, WEBP (Máx. 5 MB)</p>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-neutral-700 uppercase tracking-wider mb-1">Título de la prenda *</label>
                    <input type="text" name="titulo" required placeholder="Ej: Vestido de gala corte sirena" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm text-neutral-900 focus:ring-2 focus:ring-blue-100 focus:border-blue-300">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-neutral-700 uppercase tracking-wider mb-1">Categoría</label>
                        <input type="text" name="categoria" placeholder="Ej: Vestidos, Camisas, Arreglos" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm text-neutral-900 focus:ring-2 focus:ring-blue-100 focus:border-blue-300">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-neutral-700 uppercase tracking-wider mb-1">Fecha de confección *</label>
                        <input type="date" name="fecha" value="{{ date('Y-m-d') }}" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm text-neutral-900 focus:ring-2 focus:ring-blue-100 focus:border-blue-300">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-neutral-700 uppercase tracking-wider mb-1">Descripción / Detalles (opcional)</label>
                    <textarea name="descripcion" rows="2" placeholder="Detalles de las telas, confección o acabados especiales..." class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm text-neutral-900 focus:ring-2 focus:ring-blue-100 focus:border-blue-300"></textarea>
                </div>

                {{-- Checkbox de visibilidad pública --}}
                <div class="flex items-center gap-2 pt-1">
                    <input type="checkbox" name="visible_publico" value="1" id="visible_crear" checked class="w-4 h-4 text-neutral-900 rounded border-slate-300 focus:ring-neutral-400">
                    <label for="visible_crear" class="text-xs font-medium text-neutral-700">Mostrar este trabajo en la galería pública para clientes</label>
                </div>

                <div class="flex justify-end gap-2 pt-3 border-t border-slate-200">
                    <button type="button" @click="modalCrear = false" class="px-4 py-2 bg-slate-100 text-neutral-700 text-sm font-medium rounded-lg hover:bg-slate-200 transition-colors">
                        Cancelar
                    </button>
                    <button type="submit" class="px-4 py-2 bg-neutral-900 text-white text-sm font-medium rounded-lg hover:bg-neutral-800 transition-colors">
                        Subir y Publicar
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- =====================================================================
         6. MODAL PARA EDITAR TRABAJO (HU28)
         ===================================================================== --}}
    <div
        x-show="modalEditar"
        x-cloak
        class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/50 flex items-center justify-center p-4">
        <div
            @click.away="modalEditar = false"
            class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-xl space-y-4">

            <div class="flex items-center justify-between border-b border-slate-200 pb-3">
                <h3 class="text-lg font-bold text-neutral-900">Editar Trabajo</h3>
                <button @click="modalEditar = false" class="text-neutral-400 hover:text-neutral-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form :action="'{{ url('galeria') }}/' + trabajoSeleccionado.id" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')

                {{-- Sustituir imagen (opcional) --}}
                <div>
                    <label class="block text-xs font-semibold text-neutral-700 uppercase tracking-wider mb-1">Imagen (dejar vacío para mantener la actual)</label>
                    <div class="border-2 border-dashed border-slate-300 rounded-xl p-3 text-center bg-slate-50/50">
                        <div class="mb-2">
                            <img :src="previsualizacionEditar || trabajoSeleccionado.imagen_url" class="max-h-36 mx-auto rounded-lg object-contain shadow-sm">
                        </div>
                        <input
                            type="file"
                            name="imagen"
                            accept="image/*"
                            @change="cargarPrevisualizacion($event, 'editar')"
                            class="w-full text-xs text-neutral-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-neutral-900 file:text-white hover:file:bg-neutral-800 cursor-pointer">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-neutral-700 uppercase tracking-wider mb-1">Título *</label>
                    <input type="text" name="titulo" x-model="trabajoSeleccionado.titulo" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm text-neutral-900 focus:ring-2 focus:ring-blue-100 focus:border-blue-300">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-neutral-700 uppercase tracking-wider mb-1">Categoría</label>
                        <input type="text" name="categoria" x-model="trabajoSeleccionado.categoria" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm text-neutral-900 focus:ring-2 focus:ring-blue-100 focus:border-blue-300">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-neutral-700 uppercase tracking-wider mb-1">Fecha *</label>
                        <input type="date" name="fecha" x-model="trabajoSeleccionado.fecha" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm text-neutral-900 focus:ring-2 focus:ring-blue-100 focus:border-blue-300">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-neutral-700 uppercase tracking-wider mb-1">Descripción</label>
                    <textarea name="descripcion" x-model="trabajoSeleccionado.descripcion" rows="2" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm text-neutral-900 focus:ring-2 focus:ring-blue-100 focus:border-blue-300"></textarea>
                </div>

                <div class="flex items-center gap-2 pt-1">
                    <input type="checkbox" name="visible_publico" value="1" id="visible_editar" :checked="trabajoSeleccionado.visible_publico" class="w-4 h-4 text-neutral-900 rounded border-slate-300 focus:ring-neutral-400">
                    <label for="visible_editar" class="text-xs font-medium text-neutral-700">Mostrar este trabajo en la galería pública para clientes</label>
                </div>

                <div class="flex justify-end gap-2 pt-3 border-t border-slate-200">
                    <button type="button" @click="modalEditar = false" class="px-4 py-2 bg-slate-100 text-neutral-700 text-sm font-medium rounded-lg hover:bg-slate-200 transition-colors">
                        Cancelar
                    </button>
                    <button type="submit" class="px-4 py-2 bg-neutral-900 text-white text-sm font-medium rounded-lg hover:bg-neutral-800 transition-colors">
                        Actualizar Trabajo
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
