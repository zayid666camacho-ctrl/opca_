{{--
    OPCA — Módulo de Inventario (Sprint 7)
    Vista principal de gestión de insumos y materiales del taller Creaciones Nayja.

    Historias de usuario cubiertas:
    - HU30: Listado y registro de materiales con sus especificaciones.
    - HU31: Edición y actualización de stock de materiales existentes.
    - HU32: Sistema de alertas visuales para materiales con stock bajo.

    Tecnologías de interfaz:
    - Plantilla base: layouts.app
    - Estilos: Tailwind CSS (clases utilitarias)
    - Interactividad: Alpine.js (control de modales y vinculación de datos sin recarga)
--}}

@extends('layouts.app')

@section('title', 'Inventario')

@section('content')

{{--
    Contenedor principal con estado reactivo de Alpine.js:
    - modalCrear: bandera booleana para mostrar/ocultar el modal de registro.
    - modalEditar: bandera booleana para mostrar/ocultar el modal de edición.
    - materialSeleccionado: almacena temporalmente los datos del material a editar.
    - abrirEditar(material): clona el objeto para editarlo sin mutar la fila original directamente.
--}}
<div x-data="{
    modalCrear: false,
    modalEditar: false,
    materialSeleccionado: {
        id: null,
        nombre: '',
        categoria: '',
        stock: 0,
        unidad: '',
        precio_unitario: 0,
        stock_minimo: 0
    },
    abrirEditar(material) {
        this.materialSeleccionado = { ...material };
        this.modalEditar = true;
    }
}" class="space-y-6">

    {{-- =====================================================================
         1. ENCABEZADO Y ACCIONES PRINCIPALES
         ===================================================================== --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-neutral-900">Inventario de Materiales</h1>
            <p class="text-sm text-neutral-500 mt-0.5">Control de insumos, telas, hilos y alerta de stock mínimo.</p>
        </div>
        <div>
            {{-- Botón para disparar el modal de nuevo registro --}}
            <button
                type="button"
                @click="modalCrear = true"
                class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg bg-neutral-900 text-white text-sm font-semibold hover:bg-neutral-800 focus:outline-none focus:ring-2 focus:ring-neutral-400 transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Nuevo Material
            </button>
        </div>
    </div>

    {{-- =====================================================================
         2. BANNER DE ALERTA DE STOCK BAJO (HU32)
         Se activa únicamente cuando hay al menos 1 material con stock <= stock_minimo
         ===================================================================== --}}
    @if ($alertas['total'] > 0)
        <div class="rounded-xl border border-amber-300 bg-amber-50 p-4 sm:p-5 flex items-start gap-3.5 shadow-sm">
            <div class="p-2 bg-amber-100 text-amber-800 rounded-lg shrink-0">
                {{-- Ícono de advertencia --}}
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <div class="flex-1 min-w-0">
                <h3 class="text-sm font-semibold text-amber-900">
                    Alerta: {{ $alertas['total'] }} {{ $alertas['total'] == 1 ? 'material con stock bajo' : 'materiales con stock bajo' }}
                </h3>
                <p class="text-xs text-amber-700 mt-0.5">
                    Los siguientes artículos han alcanzado o están por debajo de su stock mínimo:
                    <span class="font-medium">
                        {{ $alertas['items']->pluck('nombre')->join(', ', ' y ') }}
                    </span>.
                </p>
            </div>
        </div>
    @endif

    {{-- =====================================================================
         3. TARJETAS DE RESUMEN / MÉTRICAS RÁPIDAS
         ===================================================================== --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        {{-- Total de registros activos --}}
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm">
            <span class="text-xs font-medium text-neutral-500 uppercase tracking-wider">Total de Artículos</span>
            <p class="text-2xl font-bold text-neutral-900 mt-1">{{ $materiales->count() }}</p>
        </div>

        {{-- Conteo de categorías distintas registradas --}}
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm">
            <span class="text-xs font-medium text-neutral-500 uppercase tracking-wider">Categorías Activas</span>
            <p class="text-2xl font-bold text-neutral-900 mt-1">{{ count($categorias) }}</p>
        </div>

        {{-- Artículos en nivel crítico --}}
        <div class="bg-white p-5 rounded-xl border {{ $alertas['total'] > 0 ? 'border-amber-300 bg-amber-50/40' : 'border-slate-200' }} shadow-sm">
            <span class="text-xs font-medium {{ $alertas['total'] > 0 ? 'text-amber-800 font-semibold' : 'text-neutral-500' }} uppercase tracking-wider">Stock Crítico</span>
            <p class="text-2xl font-bold {{ $alertas['total'] > 0 ? 'text-amber-700' : 'text-neutral-900' }} mt-1">{{ $alertas['total'] }}</p>
        </div>
    </div>

    {{-- =====================================================================
         4. BARRA DE BÚSQUEDA Y FILTRADO POR CATEGORÍA
         Envía parámetros GET al InventarioController@index para filtrar
         ===================================================================== --}}
    <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
        <form method="GET" action="{{ route('inventario.index') }}" class="flex flex-col sm:flex-row gap-3">
            {{-- Búsqueda textual por nombre --}}
            <div class="flex-1 relative">
                <input
                    type="text"
                    name="buscar"
                    value="{{ $buscar }}"
                    placeholder="Buscar por nombre de material..."
                    class="w-full pl-10 pr-4 py-2 border border-slate-300 rounded-lg text-sm text-neutral-900 placeholder-neutral-400 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-300">
                <svg class="w-4 h-4 text-neutral-400 absolute left-3.5 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>

            {{-- Selector de filtro de categoría --}}
            <div class="sm:w-56">
                <select
                    name="categoria"
                    onchange="this.form.submit()"
                    class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm text-neutral-900 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-300">
                    <option value="">Todas las categorías</option>
                    @foreach ($categorias as $cat)
                        <option value="{{ $cat }}" {{ $categoria == $cat ? 'selected' : '' }}>
                            {{ $cat }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Botones de acción del formulario de búsqueda --}}
            <div class="flex gap-2">
                <button
                    type="submit"
                    class="px-4 py-2 bg-neutral-900 text-white text-sm font-medium rounded-lg hover:bg-neutral-800 transition-colors">
                    Filtrar
                </button>
                @if ($buscar || $categoria)
                    <a
                        href="{{ route('inventario.index') }}"
                        class="px-3 py-2 bg-slate-100 text-neutral-700 text-sm font-medium rounded-lg hover:bg-slate-200 transition-colors">
                        Limpiar
                    </a>
                @endif
            </div>
        </form>
    </div>

    {{-- =====================================================================
         5. TABLA DE REGISTROS DE INVENTARIO (HU30)
         Presenta cada material con formato de moneda, estado visual y botones
         ===================================================================== --}}
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-neutral-700">
                <thead class="bg-slate-50 border-b border-slate-200 text-xs font-semibold text-neutral-600 uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-3.5">Material</th>
                        <th class="px-6 py-3.5">Categoría</th>
                        <th class="px-6 py-3.5 text-center">Stock Actual</th>
                        <th class="px-6 py-3.5 text-center">Stock Mínimo</th>
                        <th class="px-6 py-3.5 text-right">Precio Unitario</th>
                        <th class="px-6 py-3.5 text-center">Estado</th>
                        <th class="px-6 py-3.5 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse ($materiales as $item)
                        {{-- Verificación de la regla de negocio: ¿está en stock bajo? --}}
                        @php $bajo = $item->tiene_stock_bajo(); @endphp
                        <tr class="hover:bg-slate-50/75 transition-colors {{ $bajo ? 'bg-amber-50/20' : '' }}">
                            <td class="px-6 py-4 font-semibold text-neutral-900">
                                {{ $item->nombre }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-800">
                                    {{ $item->categoria }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center font-bold text-neutral-900">
                                {{ $item->stock }} <span class="text-xs font-normal text-neutral-500">{{ $item->unidad }}</span>
                            </td>
                            <td class="px-6 py-4 text-center text-neutral-500">
                                {{ $item->stock_minimo }} <span class="text-xs">{{ $item->unidad }}</span>
                            </td>
                            <td class="px-6 py-4 text-right font-medium text-neutral-900">
                                ${{ number_format($item->precio_unitario, 2) }}
                            </td>
                            {{-- Badge visual de estado según umbral mínimo (HU32) --}}
                            <td class="px-6 py-4 text-center">
                                @if ($bajo)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-800 border border-amber-300">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-600 animate-pulse"></span>
                                        Stock Bajo
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Disponible
                                    </span>
                                @endif
                            </td>
                            {{-- Columna de acciones (Edición modal y eliminación protegida) --}}
                            <td class="px-6 py-4 text-right space-x-2">
                                {{-- Abre modal Alpine cargando los datos del item (HU31) --}}
                                <button
                                    type="button"
                                    @click="abrirEditar({{ json_encode($item) }})"
                                    class="text-blue-600 hover:text-blue-800 font-medium text-xs">
                                    Editar
                                </button>

                                {{-- Formulario de eliminación con confirmación nativa JS --}}
                                <form
                                    action="{{ route('inventario.destroy', $item->id) }}"
                                    method="POST"
                                    class="inline-block"
                                    onsubmit="return confirm('¿Seguro que deseas eliminar el material {{ $item->nombre }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-rose-600 hover:text-rose-800 font-medium text-xs">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        {{-- Estado vacío cuando no existen registros o no coinciden con la búsqueda --}}
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-neutral-500">
                                <svg class="w-10 h-10 mx-auto text-neutral-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                </svg>
                                No hay materiales registrados en el inventario.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- =====================================================================
         6. MODAL PARA CREAR NUEVO MATERIAL (HU30)
         Formulario POST hacia InventarioController@store
         ===================================================================== --}}
    <div
        x-show="modalCrear"
        x-cloak
        class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/50 flex items-center justify-center p-4">
        <div
            @click.away="modalCrear = false"
            class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-xl space-y-4">

            {{-- Cabecera del modal --}}
            <div class="flex items-center justify-between border-b border-slate-200 pb-3">
                <h3 class="text-lg font-bold text-neutral-900">Registrar Nuevo Material</h3>
                <button @click="modalCrear = false" class="text-neutral-400 hover:text-neutral-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {{-- Formulario con campos estrictos en snake_case --}}
            <form action="{{ route('inventario.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-neutral-700 uppercase tracking-wider mb-1">Nombre del material</label>
                    <input type="text" name="nombre" required placeholder="Ej: Hilo poliéster negro" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm text-neutral-900 focus:ring-2 focus:ring-blue-100 focus:border-blue-300">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-neutral-700 uppercase tracking-wider mb-1">Categoría</label>
                        <input type="text" name="categoria" required placeholder="Ej: Telas, Hilos, Botones" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm text-neutral-900 focus:ring-2 focus:ring-blue-100 focus:border-blue-300">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-neutral-700 uppercase tracking-wider mb-1">Unidad de Medida</label>
                        <input type="text" name="unidad" required placeholder="Ej: unidades, metros, conos" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm text-neutral-900 focus:ring-2 focus:ring-blue-100 focus:border-blue-300">
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-neutral-700 uppercase tracking-wider mb-1">Stock Inicial</label>
                        <input type="number" name="stock" min="0" required placeholder="0" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm text-neutral-900 focus:ring-2 focus:ring-blue-100 focus:border-blue-300">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-neutral-700 uppercase tracking-wider mb-1">Stock Mínimo</label>
                        <input type="number" name="stock_minimo" min="0" required placeholder="0" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm text-neutral-900 focus:ring-2 focus:ring-blue-100 focus:border-blue-300">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-neutral-700 uppercase tracking-wider mb-1">Precio Unitario ($)</label>
                        <input type="number" step="0.01" name="precio_unitario" min="0" required placeholder="0.00" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm text-neutral-900 focus:ring-2 focus:ring-blue-100 focus:border-blue-300">
                    </div>
                </div>

                {{-- Pie de acciones del modal --}}
                <div class="flex justify-end gap-2 pt-3 border-t border-slate-200">
                    <button type="button" @click="modalCrear = false" class="px-4 py-2 bg-slate-100 text-neutral-700 text-sm font-medium rounded-lg hover:bg-slate-200 transition-colors">
                        Cancelar
                    </button>
                    <button type="submit" class="px-4 py-2 bg-neutral-900 text-white text-sm font-medium rounded-lg hover:bg-neutral-800 transition-colors">
                        Guardar Material
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- =====================================================================
         7. MODAL PARA EDITAR MATERIAL (HU31)
         Formulario PUT hacia InventarioController@update/{id} con x-model
         ===================================================================== --}}
    <div
        x-show="modalEditar"
        x-cloak
        class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/50 flex items-center justify-center p-4">
        <div
            @click.away="modalEditar = false"
            class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-xl space-y-4">

            {{-- Cabecera del modal de edición --}}
            <div class="flex items-center justify-between border-b border-slate-200 pb-3">
                <h3 class="text-lg font-bold text-neutral-900">Editar Material</h3>
                <button @click="modalEditar = false" class="text-neutral-400 hover:text-neutral-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {{-- Formulario PUT dinámico enlazado al ID del material seleccionado --}}
            <form :action="'{{ url('inventario') }}/' + materialSeleccionado.id" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-xs font-semibold text-neutral-700 uppercase tracking-wider mb-1">Nombre del material</label>
                    <input type="text" name="nombre" x-model="materialSeleccionado.nombre" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm text-neutral-900 focus:ring-2 focus:ring-blue-100 focus:border-blue-300">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-neutral-700 uppercase tracking-wider mb-1">Categoría</label>
                        <input type="text" name="categoria" x-model="materialSeleccionado.categoria" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm text-neutral-900 focus:ring-2 focus:ring-blue-100 focus:border-blue-300">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-neutral-700 uppercase tracking-wider mb-1">Unidad de Medida</label>
                        <input type="text" name="unidad" x-model="materialSeleccionado.unidad" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm text-neutral-900 focus:ring-2 focus:ring-blue-100 focus:border-blue-300">
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-neutral-700 uppercase tracking-wider mb-1">Stock Actual</label>
                        <input type="number" name="stock" min="0" x-model="materialSeleccionado.stock" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm text-neutral-900 focus:ring-2 focus:ring-blue-100 focus:border-blue-300">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-neutral-700 uppercase tracking-wider mb-1">Stock Mínimo</label>
                        <input type="number" name="stock_minimo" min="0" x-model="materialSeleccionado.stock_minimo" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm text-neutral-900 focus:ring-2 focus:ring-blue-100 focus:border-blue-300">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-neutral-700 uppercase tracking-wider mb-1">Precio Unitario ($)</label>
                        <input type="number" step="0.01" name="precio_unitario" min="0" x-model="materialSeleccionado.precio_unitario" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm text-neutral-900 focus:ring-2 focus:ring-blue-100 focus:border-blue-300">
                    </div>
                </div>

                {{-- Pie de acciones del modal de edición --}}
                <div class="flex justify-end gap-2 pt-3 border-t border-slate-200">
                    <button type="button" @click="modalEditar = false" class="px-4 py-2 bg-slate-100 text-neutral-700 text-sm font-medium rounded-lg hover:bg-slate-200 transition-colors">
                        Cancelar
                    </button>
                    <button type="submit" class="px-4 py-2 bg-neutral-900 text-white text-sm font-medium rounded-lg hover:bg-neutral-800 transition-colors">
                        Actualizar Material
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection