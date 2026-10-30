{{--
    OPCA — Módulo de Inventario (Sprint 7)
    Vista principal de gestión de insumos y materiales del taller Creaciones Nayja.

    Historias de usuario cubiertas:
    - HU30: Listado y registro de materiales con sus especificaciones.
    - HU31: Edición y actualización de stock de materiales existentes.
    - HU32: Sistema de alertas visuales para materiales con stock bajo.
--}}

@extends('layouts.module')

@section('title', 'Inventario de Materiales')
@section('page-title', 'Inventario de Materiales e Insumos')

@section('content')

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
}" class="max-w-7xl mx-auto space-y-6">

    {{-- 1. ENCABEZADO Y ACCIONES PRINCIPALES --}}
    <div class="bg-white rounded-2xl border border-brand-200/80 shadow-xs p-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-brand-900">Inventario de Materiales</h2>
            <p class="text-xs sm:text-sm text-brand-900/65 mt-0.5">Control de insumos, telas, hilos y alerta automática de stock mínimo.</p>
        </div>
        <div>
            <button
                type="button"
                @click="modalCrear = true"
                class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-brand-600 text-white text-xs sm:text-sm font-semibold hover:bg-brand-700 transition-colors shadow-xs">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Nuevo Material
            </button>
        </div>
    </div>

    {{-- 2. BANNER DE ALERTA DE STOCK BAJO (HU32) --}}
    @if ($alertas['total'] > 0)
        <div class="rounded-2xl border border-amber-300 bg-amber-50 p-4 sm:p-5 flex items-start gap-3.5 shadow-xs">
            <div class="p-2 bg-amber-100 text-amber-800 rounded-xl shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <div class="flex-1 min-w-0">
                <h3 class="text-sm font-bold text-amber-900">
                    Alerta: {{ $alertas['total'] }} {{ $alertas['total'] == 1 ? 'material con stock bajo' : 'materiales con stock bajo' }}
                </h3>
                <p class="text-xs text-amber-800 mt-0.5">
                    Los siguientes artículos han alcanzado o están por debajo de su stock mínimo:
                    <span class="font-semibold">
                        {{ $alertas['items']->pluck('nombre')->join(', ', ' y ') }}
                    </span>.
                </p>
            </div>
        </div>
    @endif

    {{-- 3. TARJETAS DE RESUMEN / MÉTRICAS RÁPIDAS --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white p-5 rounded-2xl border border-brand-200/80 shadow-xs">
            <span class="text-xs font-bold text-brand-900/60 uppercase tracking-wider">Total de Artículos</span>
            <p class="text-2xl font-extrabold text-brand-900 mt-1">{{ $materiales->count() }}</p>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-brand-200/80 shadow-xs">
            <span class="text-xs font-bold text-brand-900/60 uppercase tracking-wider">Categorías Activas</span>
            <p class="text-2xl font-extrabold text-brand-800 mt-1">{{ count($categorias) }}</p>
        </div>

        <div class="bg-white p-5 rounded-2xl border {{ $alertas['total'] > 0 ? 'border-amber-300 bg-amber-50/40' : 'border-brand-200/80' }} shadow-xs">
            <span class="text-xs font-bold {{ $alertas['total'] > 0 ? 'text-amber-800' : 'text-brand-900/60' }} uppercase tracking-wider">Stock Crítico</span>
            <p class="text-2xl font-extrabold {{ $alertas['total'] > 0 ? 'text-amber-700' : 'text-brand-900' }} mt-1">{{ $alertas['total'] }}</p>
        </div>
    </div>

    {{-- 4. BARRA DE BÚSQUEDA Y FILTRADO POR CATEGORÍA --}}
    <div class="bg-white p-4 rounded-2xl border border-brand-200/80 shadow-xs">
        <form method="GET" action="{{ route('inventario.index') }}" class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1 relative">
                <input
                    type="text"
                    name="buscar"
                    value="{{ $buscar }}"
                    placeholder="Buscar por nombre de material..."
                    class="w-full pl-10 pr-4 py-2 bg-brand-50/40 border border-brand-200 rounded-xl text-sm text-brand-900 placeholder-brand-900/45 focus:outline-none focus:ring-2 focus:ring-brand-500">
                <svg class="w-4 h-4 text-brand-900/45 absolute left-3.5 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>

            <div class="sm:w-56">
                <select
                    name="categoria"
                    onchange="this.form.submit()"
                    class="w-full px-3.5 py-2 bg-brand-50/40 border border-brand-200 rounded-xl text-sm text-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-500">
                    <option value="">Todas las categorías</option>
                    @foreach ($categorias as $cat)
                        <option value="{{ $cat }}" {{ $categoria == $cat ? 'selected' : '' }}>
                            {{ $cat }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex gap-2">
                <button
                    type="submit"
                    class="px-4 py-2 bg-brand-900 text-white text-sm font-semibold rounded-xl hover:bg-brand-800 transition-colors">
                    Filtrar
                </button>
                @if ($buscar || $categoria)
                    <a
                        href="{{ route('inventario.index') }}"
                        class="px-3.5 py-2 bg-brand-50 border border-brand-200 text-brand-900 text-sm font-medium rounded-xl hover:bg-brand-100 transition-colors">
                        Limpiar
                    </a>
                @endif
            </div>
        </form>
    </div>

    {{-- 5. TABLA DE REGISTROS DE INVENTARIO (HU30) --}}
    <div class="bg-white rounded-2xl border border-brand-200/80 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-brand-900">
                <thead class="bg-brand-100/50 border-b border-brand-200/70 text-xs font-bold text-brand-900/75 uppercase tracking-wider">
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
                <tbody class="divide-y divide-brand-100">
                    @forelse ($materiales as $item)
                        @php $bajo = $item->tiene_stock_bajo(); @endphp
                        <tr class="hover:bg-brand-50/60 transition-colors {{ $bajo ? 'bg-amber-50/30' : '' }}">
                            <td class="px-6 py-4 font-semibold text-brand-900">
                                {{ $item->nombre }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-brand-100 text-brand-800">
                                    {{ $item->categoria }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center font-bold text-brand-900">
                                {{ $item->stock }} <span class="text-xs font-normal text-brand-900/60">{{ $item->unidad }}</span>
                            </td>
                            <td class="px-6 py-4 text-center text-brand-900/65">
                                {{ $item->stock_minimo }} <span class="text-xs">{{ $item->unidad }}</span>
                            </td>
                            <td class="px-6 py-4 text-right font-semibold text-brand-900">
                                ${{ number_format($item->precio_unitario, 2) }}
                            </td>
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
                            <td class="px-6 py-4 text-right space-x-3">
                                <button
                                    type="button"
                                    @click="abrirEditar({{ json_encode($item) }})"
                                    class="text-brand-600 hover:text-brand-700 font-semibold text-xs">
                                    Editar
                                </button>

                                <form
                                    action="{{ route('inventario.destroy', $item->id) }}"
                                    method="POST"
                                    class="inline-block"
                                    onsubmit="return confirm('¿Seguro que deseas eliminar el material {{ $item->nombre }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-rose-600 hover:text-rose-800 font-semibold text-xs">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-brand-900/50">
                                No hay materiales registrados en el inventario.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- 6. MODAL PARA CREAR NUEVO MATERIAL (HU30) --}}
    <div
        x-show="modalCrear"
        x-cloak
        class="fixed inset-0 z-50 overflow-y-auto bg-brand-900/60 backdrop-blur-xs flex items-center justify-center p-4">
        <div
            @click.away="modalCrear = false"
            class="bg-white rounded-2xl border border-brand-200 max-w-lg w-full p-6 shadow-xl space-y-4">

            <div class="flex items-center justify-between border-b border-brand-100 pb-3">
                <h3 class="text-lg font-bold text-brand-900">Registrar Nuevo Material</h3>
                <button @click="modalCrear = false" class="text-brand-900/45 hover:text-brand-900">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form action="{{ route('inventario.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-brand-900/75 uppercase tracking-wider mb-1">Nombre del material</label>
                    <input type="text" name="nombre" required placeholder="Ej: Hilo poliéster negro" class="w-full px-3.5 py-2 bg-brand-50/50 border border-brand-200 rounded-xl text-sm text-brand-900 focus:ring-2 focus:ring-brand-500 focus:outline-none">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-brand-900/75 uppercase tracking-wider mb-1">Categoría</label>
                        <input type="text" name="categoria" required placeholder="Ej: Telas, Hilos, Botones" class="w-full px-3.5 py-2 bg-brand-50/50 border border-brand-200 rounded-xl text-sm text-brand-900 focus:ring-2 focus:ring-brand-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-brand-900/75 uppercase tracking-wider mb-1">Unidad de Medida</label>
                        <input type="text" name="unidad" required placeholder="Ej: unidades, metros, conos" class="w-full px-3.5 py-2 bg-brand-50/50 border border-brand-200 rounded-xl text-sm text-brand-900 focus:ring-2 focus:ring-brand-500 focus:outline-none">
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-brand-900/75 uppercase tracking-wider mb-1">Stock Inicial</label>
                        <input type="number" name="stock" min="0" required placeholder="0" class="w-full px-3.5 py-2 bg-brand-50/50 border border-brand-200 rounded-xl text-sm text-brand-900 focus:ring-2 focus:ring-brand-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-brand-900/75 uppercase tracking-wider mb-1">Stock Mínimo</label>
                        <input type="number" name="stock_minimo" min="0" required placeholder="0" class="w-full px-3.5 py-2 bg-brand-50/50 border border-brand-200 rounded-xl text-sm text-brand-900 focus:ring-2 focus:ring-brand-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-brand-900/75 uppercase tracking-wider mb-1">Precio Unitario ($)</label>
                        <input type="number" step="0.01" name="precio_unitario" min="0" required placeholder="0.00" class="w-full px-3.5 py-2 bg-brand-50/50 border border-brand-200 rounded-xl text-sm text-brand-900 focus:ring-2 focus:ring-brand-500 focus:outline-none">
                    </div>
                </div>

                <div class="flex justify-end gap-2 pt-3 border-t border-brand-100">
                    <button type="button" @click="modalCrear = false" class="px-4 py-2 bg-brand-50 border border-brand-200 text-brand-900 text-sm font-medium rounded-xl hover:bg-brand-100 transition-colors">
                        Cancelar
                    </button>
                    <button type="submit" class="px-4 py-2 bg-brand-600 text-white text-sm font-semibold rounded-xl hover:bg-brand-700 transition-colors">
                        Guardar Material
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- 7. MODAL PARA EDITAR MATERIAL (HU31) --}}
    <div
        x-show="modalEditar"
        x-cloak
        class="fixed inset-0 z-50 overflow-y-auto bg-brand-900/60 backdrop-blur-xs flex items-center justify-center p-4">
        <div
            @click.away="modalEditar = false"
            class="bg-white rounded-2xl border border-brand-200 max-w-lg w-full p-6 shadow-xl space-y-4">

            <div class="flex items-center justify-between border-b border-brand-100 pb-3">
                <h3 class="text-lg font-bold text-brand-900">Editar Material</h3>
                <button @click="modalEditar = false" class="text-brand-900/45 hover:text-brand-900">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form :action="'{{ url('inventario') }}/' + materialSeleccionado.id" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-xs font-semibold text-brand-900/75 uppercase tracking-wider mb-1">Nombre del material</label>
                    <input type="text" name="nombre" x-model="materialSeleccionado.nombre" required class="w-full px-3.5 py-2 bg-brand-50/50 border border-brand-200 rounded-xl text-sm text-brand-900 focus:ring-2 focus:ring-brand-500 focus:outline-none">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-brand-900/75 uppercase tracking-wider mb-1">Categoría</label>
                        <input type="text" name="categoria" x-model="materialSeleccionado.categoria" required class="w-full px-3.5 py-2 bg-brand-50/50 border border-brand-200 rounded-xl text-sm text-brand-900 focus:ring-2 focus:ring-brand-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-brand-900/75 uppercase tracking-wider mb-1">Unidad de Medida</label>
                        <input type="text" name="unidad" x-model="materialSeleccionado.unidad" required class="w-full px-3.5 py-2 bg-brand-50/50 border border-brand-200 rounded-xl text-sm text-brand-900 focus:ring-2 focus:ring-brand-500 focus:outline-none">
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-brand-900/75 uppercase tracking-wider mb-1">Stock Actual</label>
                        <input type="number" name="stock" min="0" x-model="materialSeleccionado.stock" required class="w-full px-3.5 py-2 bg-brand-50/50 border border-brand-200 rounded-xl text-sm text-brand-900 focus:ring-2 focus:ring-brand-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-brand-900/75 uppercase tracking-wider mb-1">Stock Mínimo</label>
                        <input type="number" name="stock_minimo" min="0" x-model="materialSeleccionado.stock_minimo" required class="w-full px-3.5 py-2 bg-brand-50/50 border border-brand-200 rounded-xl text-sm text-brand-900 focus:ring-2 focus:ring-brand-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-brand-900/75 uppercase tracking-wider mb-1">Precio Unitario ($)</label>
                        <input type="number" step="0.01" name="precio_unitario" min="0" x-model="materialSeleccionado.precio_unitario" required class="w-full px-3.5 py-2 bg-brand-50/50 border border-brand-200 rounded-xl text-sm text-brand-900 focus:ring-2 focus:ring-brand-500 focus:outline-none">
                    </div>
                </div>

                <div class="flex justify-end gap-2 pt-3 border-t border-brand-100">
                    <button type="button" @click="modalEditar = false" class="px-4 py-2 bg-brand-50 border border-brand-200 text-brand-900 text-sm font-medium rounded-xl hover:bg-brand-100 transition-colors">
                        Cancelar
                    </button>
                    <button type="submit" class="px-4 py-2 bg-brand-600 text-white text-sm font-semibold rounded-xl hover:bg-brand-700 transition-colors">
                        Actualizar Material
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
