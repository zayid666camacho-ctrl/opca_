{{--
    OPCA — Flujo Guiado de Nuevo Pedido (Fase 3)
    Recorrido paso a paso: Cliente → Prendas → Medidas → Datos → Abono → Resumen.
    Guardado atómico "todo o nada" mediante NuevoPedidoService (Fase 2).

    Historias de usuario:
    - HU11–HU14: Creación de pedido multi-prenda con precio congelado.
    - Documento Maestro §6: Flujo guiado completo.
--}}

@extends('layouts.module')

@section('title', 'Nuevo pedido')
@section('page-title', 'Nuevo pedido')

@section('content')

<x-card>
<div class="max-w-3xl mx-auto" x-data="flujo()">

    {{-- Errores de validación del servidor --}}
    @if ($errors->any())
        <div class="bg-red-50 border border-red-300 text-red-800 px-4 py-3 rounded-xl mb-5 text-sm">
            <h4 class="font-bold mb-1">No se pudo guardar el pedido:</h4>
            <ul class="list-disc list-inside space-y-0.5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('pedidos.guardar') }}" method="POST"
        @keydown.enter="if ($event.target.tagName === 'INPUT') $event.preventDefault()">
        @csrf

        {{-- Fecha del pedido (viene del Calendario) --}}
        <div class="flex items-center gap-3 mb-6">
            <label class="text-sm font-semibold text-slate-600">Fecha del pedido</label>
            <input type="date" name="fecha" x-model="fecha"
                class="border border-slate-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-100 focus:border-blue-300">
        </div>

        {{-- Indicador de pasos (stepper) --}}
        <ol class="flex flex-wrap gap-2 mb-6 text-sm">
            <template x-for="(nombre, i) in pasos" :key="i">
                <li class="px-3.5 py-1 rounded-full border font-semibold cursor-default transition-colors"
                    :class="paso === i + 1
                        ? 'bg-brand-600 text-white border-brand-600 shadow-sm'
                        : (paso > i + 1 ? 'bg-brand-100 text-brand-700 border-brand-200' : 'text-slate-400 border-slate-200')"
                    x-text="(i + 1) + '. ' + nombre"></li>
            </template>
        </ol>

        {{-- ===== PASO 1: Cliente ===== --}}
        <section x-show="paso === 1" x-cloak class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
            <h3 class="text-xl font-bold text-neutral-900 mb-4">¿El cliente es nuevo o ya existe?</h3>

            <input type="hidden" name="cliente_modo" :value="cliente_modo">

            <div class="grid grid-cols-2 gap-3 mb-6">
                <button type="button" @click="elegir_modo('nuevo')"
                    class="border rounded-xl px-4 py-4 text-left transition-colors"
                    :class="cliente_modo === 'nuevo' ? 'border-neutral-900 bg-slate-50' : 'border-slate-200 hover:bg-slate-50'">
                    <span class="font-semibold text-neutral-900">Cliente nuevo</span>
                    <span class="block text-sm text-slate-500">Registrar sus datos ahora</span>
                </button>

                <button type="button" @click="elegir_modo('existente')"
                    class="border rounded-xl px-4 py-4 text-left transition-colors"
                    :class="cliente_modo === 'existente' ? 'border-neutral-900 bg-slate-50' : 'border-slate-200 hover:bg-slate-50'">
                    <span class="font-semibold text-neutral-900">Cliente existente</span>
                    <span class="block text-sm text-slate-500">Buscarlo por nombre</span>
                </button>
            </div>

            {{-- Cliente existente: buscador --}}
            <div x-show="cliente_modo === 'existente'">

                <template x-if="!cliente">
                    <div>
                        <input type="text" x-model="busqueda" @input.debounce.300ms="buscar()"
                            placeholder="Buscar por nombre y apellido..."
                            class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-100">

                        <ul class="mt-2 divide-y divide-slate-100 border border-slate-100 rounded-lg" x-show="resultados.length">
                            <template x-for="c in resultados" :key="c.id">
                                <li>
                                    <button type="button" @click="elegir_cliente(c)"
                                        class="w-full text-left px-3 py-2 hover:bg-slate-50">
                                        <span class="font-medium text-neutral-900" x-text="c.nombre + ' ' + c.apellido"></span>
                                        <span class="block text-xs text-slate-500" x-text="c.correo + ' · ' + c.telefono"></span>
                                    </button>
                                </li>
                            </template>
                        </ul>

                        <p class="text-sm text-slate-400 mt-2"
                            x-show="busqueda.trim().length >= 2 && !resultados.length && !buscando">
                            No se encontró ningún cliente con ese nombre.
                        </p>
                    </div>
                </template>

                <template x-if="cliente">
                    <div class="flex items-center justify-between bg-slate-50 border border-slate-200 rounded-xl px-4 py-3">
                        <div>
                            <p class="font-semibold text-neutral-900" x-text="cliente.nombre + ' ' + cliente.apellido"></p>
                            <p class="text-sm text-slate-500" x-text="cliente.correo + ' · ' + cliente.telefono"></p>
                        </div>
                        <button type="button" @click="cambiar_cliente()" class="text-sm text-blue-600 hover:underline">
                            Cambiar
                        </button>
                        <input type="hidden" name="idcliente" :value="cliente.id">
                    </div>
                </template>
            </div>

            {{-- Cliente nuevo: formulario --}}
            <template x-if="cliente_modo === 'nuevo'">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-neutral-700 uppercase tracking-wider mb-1">Nombre *</label>
                        <input type="text" name="cliente[nombre]" x-model="nuevo.nombre"
                            class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-100">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-neutral-700 uppercase tracking-wider mb-1">Apellido *</label>
                        <input type="text" name="cliente[apellido]" x-model="nuevo.apellido"
                            class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-100">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-neutral-700 uppercase tracking-wider mb-1">Correo *</label>
                        <input type="email" name="cliente[correo]" x-model="nuevo.correo"
                            class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-100">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-neutral-700 uppercase tracking-wider mb-1">Teléfono *</label>
                        <input type="text" name="cliente[telefono]" x-model="nuevo.telefono"
                            class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-100">
                    </div>
                </div>
            </template>
        </section>

        {{-- ===== PASO 2: Prendas ===== --}}
        <section x-show="paso === 2" x-cloak class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
            <h3 class="text-xl font-bold text-neutral-900 mb-1">Selecciona las prendas del pedido</h3>
            <p class="text-sm text-slate-500 mb-5">Elige del catálogo de precios base y selecciona el tipo de servicio para cada una.</p>

            {{-- Selector de prenda del catálogo --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-6">
                <div>
                    <label class="block text-xs font-semibold text-neutral-700 uppercase tracking-wider mb-1">Prenda del catálogo *</label>
                    <select x-model="prenda_seleccionada"
                        class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-100">
                        <option value="">— Elige una prenda —</option>
                        <template x-for="pb in catalogo" :key="pb.id">
                            <option :value="pb.id" x-text="pb.nombre_prenda + ' (' + pb.complejidad + ') — $' + Number(pb.precio).toLocaleString('es-CO')"></option>
                        </template>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-neutral-700 uppercase tracking-wider mb-1">Tipo de servicio *</label>
                    <select x-model="tipo_seleccionado"
                        class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-100">
                        <option value="">— Tipo de servicio —</option>
                        <template x-for="ts in tipos_servicio" :key="ts.id">
                            <option :value="ts.id" x-text="ts.servicio === 'diseno' ? 'Diseño' : ts.servicio.charAt(0).toUpperCase() + ts.servicio.slice(1)"></option>
                        </template>
                    </select>
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-xs font-semibold text-neutral-700 uppercase tracking-wider mb-1">Descripción de la prenda (opcional)</label>
                <input type="text" x-model="prenda_descripcion" placeholder="Detalles, tela o indicaciones para esta prenda..."
                    class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-100">
            </div>

            <button type="button" @click="agregar_prenda()"
                :disabled="!prenda_seleccionada || !tipo_seleccionado"
                class="px-4 py-2 rounded-lg bg-brand-600 text-white text-sm font-semibold hover:bg-brand-700 transition-colors disabled:opacity-40 disabled:cursor-not-allowed">
                + Agregar prenda al pedido
            </button>

            {{-- Lista de prendas agregadas --}}
            <div x-show="prendas.length > 0" class="mt-6 space-y-3">
                <h4 class="text-sm font-bold text-neutral-700 uppercase tracking-wider">
                    Prendas en este pedido (<span x-text="prendas.length"></span>):
                </h4>

                <template x-for="(p, idx) in prendas" :key="idx">
                    <div class="flex items-center justify-between bg-slate-50 border border-slate-200 rounded-xl px-4 py-3">
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-neutral-900 text-sm" x-text="p.nombre_prenda"></p>
                            <p class="text-xs text-slate-500">
                                <span x-text="p.tipo_nombre"></span> ·
                                <span x-text="p.complejidad"></span> ·
                                $<span x-text="Number(p.precio).toLocaleString('es-CO')"></span>
                            </p>
                            <p class="text-xs text-slate-400 mt-0.5" x-show="p.descripcion" x-text="p.descripcion"></p>

                            {{-- Campos hidden para enviar al servidor --}}
                            <input type="hidden" :name="'prendas[' + idx + '][id_precio_bases]'" :value="p.id_precio_bases">
                            <input type="hidden" :name="'prendas[' + idx + '][id_tipo_servicios]'" :value="p.id_tipo_servicios">
                            <input type="hidden" :name="'prendas[' + idx + '][descripcion]'" :value="p.descripcion">
                        </div>
                        <button type="button" @click="quitar_prenda(idx)" class="text-rose-600 hover:text-rose-800 text-xs font-semibold ml-3">
                            Quitar
                        </button>
                    </div>
                </template>

                {{-- Total acumulado --}}
                <div class="flex items-center justify-between bg-brand-900 text-white rounded-xl px-5 py-3">
                    <span class="text-sm font-bold">Total del pedido:</span>
                    <span class="text-lg font-extrabold text-gold-500">$<span x-text="total_prendas().toLocaleString('es-CO')"></span></span>
                </div>
            </div>
        </section>

        {{-- ===== PASO 3: Medidas ===== --}}
        <section x-show="paso === 3" x-cloak class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
            <h3 class="text-xl font-bold text-neutral-900 mb-1">Medidas del cliente</h3>
            <p class="text-sm text-slate-500 mb-5">
                Solo se muestran los grupos de medidas que requieren las prendas seleccionadas. Son opcionales.
            </p>

            {{-- Aviso de medidas existentes para cliente existente --}}
            <template x-if="cliente && tiene_medidas_guardadas()">
                <div class="bg-blue-50 border border-blue-200 rounded-xl px-4 py-3 mb-5 text-sm text-blue-800">
                    <span class="font-semibold">Este cliente ya tiene medidas guardadas.</span>
                    Puedes verificarlas o actualizarlas a continuación.
                </div>
            </template>

            {{-- Grupo CAMISA (parte superior) --}}
            <div x-show="necesita_camisa()" class="mb-6">
                <h4 class="text-sm font-bold text-neutral-700 uppercase tracking-wider mb-3 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                    Medidas de Camisa (parte superior)
                </h4>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
                    <template x-for="campo in campos_camisa" :key="campo.nombre">
                        <div>
                            <label class="block text-xs font-medium text-slate-600 mb-0.5" x-text="campo.etiqueta"></label>
                            <input type="number" step="0.01" min="0" max="999.99"
                                :name="'medidas[' + campo.nombre + ']'"
                                :value="obtener_medida(campo.nombre)"
                                class="w-full border border-slate-300 rounded-lg px-2.5 py-1.5 text-sm focus:ring-2 focus:ring-blue-100"
                                placeholder="cm">
                        </div>
                    </template>
                </div>
            </div>

            {{-- Grupo PANTALÓN (parte inferior) --}}
            <div x-show="necesita_pantalon()" class="mb-6">
                <h4 class="text-sm font-bold text-neutral-700 uppercase tracking-wider mb-3 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    Medidas de Pantalón (parte inferior)
                </h4>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
                    <template x-for="campo in campos_pantalon" :key="campo.nombre">
                        <div>
                            <label class="block text-xs font-medium text-slate-600 mb-0.5" x-text="campo.etiqueta"></label>
                            <input type="number" step="0.01" min="0" max="999.99"
                                :name="'medidas[' + campo.nombre + ']'"
                                :value="obtener_medida(campo.nombre)"
                                class="w-full border border-slate-300 rounded-lg px-2.5 py-1.5 text-sm focus:ring-2 focus:ring-blue-100"
                                placeholder="cm">
                        </div>
                    </template>
                </div>
            </div>

            {{-- Grupo GENERALES (altura total) --}}
            <div x-show="necesita_generales()" class="mb-6">
                <h4 class="text-sm font-bold text-neutral-700 uppercase tracking-wider mb-3 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                    Medidas Generales
                </h4>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
                    <template x-for="campo in campos_generales" :key="campo.nombre">
                        <div>
                            <label class="block text-xs font-medium text-slate-600 mb-0.5" x-text="campo.etiqueta"></label>
                            <input type="number" step="0.01" min="0" max="999.99"
                                :name="'medidas[' + campo.nombre + ']'"
                                :value="obtener_medida(campo.nombre)"
                                class="w-full border border-slate-300 rounded-lg px-2.5 py-1.5 text-sm focus:ring-2 focus:ring-blue-100"
                                placeholder="cm">
                        </div>
                    </template>
                </div>
            </div>

            <p x-show="!necesita_camisa() && !necesita_pantalon() && !necesita_generales()"
                class="text-sm text-slate-400 italic">
                Las prendas seleccionadas no requieren medidas específicas.
            </p>
        </section>

        {{-- ===== PASO 4: Datos del pedido ===== --}}
        <section x-show="paso === 4" x-cloak class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
            <h3 class="text-xl font-bold text-neutral-900 mb-1">Datos del pedido</h3>
            <p class="text-sm text-slate-500 mb-5">Fecha de entrega y observaciones generales.</p>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-neutral-700 uppercase tracking-wider mb-1">Fecha de entrega *</label>
                    <input type="date" name="fecha_entrega" x-model="fecha_entrega" :min="fecha"
                        class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-100">
                    <p class="text-xs text-slate-400 mt-1">No puede ser anterior a la fecha del pedido.</p>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-neutral-700 uppercase tracking-wider mb-1">Descripción general (opcional)</label>
                    <textarea name="descripcion" x-model="descripcion" rows="3"
                        placeholder="Indicaciones generales del pedido..."
                        class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-100"></textarea>
                </div>
            </div>
        </section>

        {{-- ===== PASO 5: Abono ===== --}}
        <section x-show="paso === 5" x-cloak class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
            <h3 class="text-xl font-bold text-neutral-900 mb-1">Abono inicial</h3>
            <p class="text-sm text-slate-500 mb-5">Opcional. Si el cliente realiza un abono ahora, regístralo aquí.</p>

            <div class="flex items-center gap-3 mb-5">
                <input type="checkbox" x-model="abono_activo" id="abono_check" value="1"
                    class="w-4 h-4 text-neutral-900 rounded border-slate-300 focus:ring-neutral-400">
                <input type="hidden" name="abono_activo" :value="abono_activo ? '1' : '0'">
                <label for="abono_check" class="text-sm font-medium text-neutral-700">El cliente deja un abono con este pedido</label>
            </div>

            <div x-show="abono_activo" class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-neutral-700 uppercase tracking-wider mb-1">Monto del abono *</label>
                    <input type="number" step="0.01" min="1" :max="total_prendas()"
                        name="abono_monto" x-model="abono_monto"
                        class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-100">
                    <p class="text-xs text-slate-400 mt-1">
                        Máximo: $<span x-text="total_prendas().toLocaleString('es-CO')"></span>
                    </p>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-neutral-700 uppercase tracking-wider mb-1">Fecha del abono *</label>
                    <input type="date" name="abono_fecha" x-model="abono_fecha"
                        class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-100">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-neutral-700 uppercase tracking-wider mb-1">Notas (opcional)</label>
                    <input type="text" name="abono_notas" x-model="abono_notas" placeholder="Ej: Efectivo, transferencia..."
                        class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-100">
                </div>
            </div>
        </section>

        {{-- ===== PASO 6: Resumen ===== --}}
        <section x-show="paso === 6" x-cloak class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
            <h3 class="text-xl font-bold text-neutral-900 mb-1">Resumen del pedido</h3>
            <p class="text-sm text-slate-500 mb-5">Revisa que todo esté correcto antes de guardar.</p>

            <div class="space-y-4">
                {{-- Cliente --}}
                <div class="bg-slate-50 rounded-xl border border-slate-200 p-4">
                    <span class="text-xs font-bold text-neutral-500 uppercase tracking-wider">Cliente</span>
                    <template x-if="cliente_modo === 'existente' && cliente">
                        <p class="font-semibold text-neutral-900 mt-0.5" x-text="cliente.nombre + ' ' + cliente.apellido"></p>
                    </template>
                    <template x-if="cliente_modo === 'nuevo'">
                        <p class="font-semibold text-neutral-900 mt-0.5" x-text="nuevo.nombre + ' ' + nuevo.apellido + ' (nuevo)'"></p>
                    </template>
                </div>

                {{-- Prendas --}}
                <div class="bg-slate-50 rounded-xl border border-slate-200 p-4">
                    <span class="text-xs font-bold text-neutral-500 uppercase tracking-wider">
                        Prendas (<span x-text="prendas.length"></span>)
                    </span>
                    <template x-for="(p, idx) in prendas" :key="idx">
                        <div class="flex items-center justify-between mt-2 text-sm">
                            <div>
                                <span class="font-medium text-neutral-900" x-text="p.nombre_prenda"></span>
                                <span class="text-slate-500" x-text="' — ' + p.tipo_nombre + ' (' + p.complejidad + ')'"></span>
                            </div>
                            <span class="font-bold text-neutral-900">$<span x-text="Number(p.precio).toLocaleString('es-CO')"></span></span>
                        </div>
                    </template>
                    <div class="flex items-center justify-between mt-3 pt-3 border-t border-slate-300 text-sm">
                        <span class="font-bold text-neutral-900">Total:</span>
                        <span class="text-lg font-extrabold text-neutral-900">$<span x-text="total_prendas().toLocaleString('es-CO')"></span></span>
                    </div>
                </div>

                {{-- Fechas --}}
                <div class="bg-slate-50 rounded-xl border border-slate-200 p-4">
                    <span class="text-xs font-bold text-neutral-500 uppercase tracking-wider">Fechas</span>
                    <div class="grid grid-cols-2 gap-3 mt-1 text-sm">
                        <div>
                            <span class="text-slate-500">Pedido:</span>
                            <span class="font-medium text-neutral-900 ml-1" x-text="fecha"></span>
                        </div>
                        <div>
                            <span class="text-slate-500">Entrega:</span>
                            <span class="font-medium text-neutral-900 ml-1" x-text="fecha_entrega || 'No definida'"></span>
                        </div>
                    </div>
                </div>

                {{-- Abono --}}
                <div class="bg-slate-50 rounded-xl border border-slate-200 p-4" x-show="abono_activo">
                    <span class="text-xs font-bold text-neutral-500 uppercase tracking-wider">Abono inicial</span>
                    <div class="grid grid-cols-2 gap-3 mt-1 text-sm">
                        <div>
                            <span class="text-slate-500">Monto:</span>
                            <span class="font-bold text-emerald-700 ml-1">$<span x-text="Number(abono_monto || 0).toLocaleString('es-CO')"></span></span>
                        </div>
                        <div>
                            <span class="text-slate-500">Saldo pendiente:</span>
                            <span class="font-bold text-neutral-900 ml-1">$<span x-text="(total_prendas() - Number(abono_monto || 0)).toLocaleString('es-CO')"></span></span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Navegación entre pasos --}}
        <div class="flex justify-between mt-6">
            <button type="button" @click="atras()" x-show="paso > 1" x-cloak
                class="px-4 py-2 rounded-lg border border-slate-300 text-slate-600 text-sm font-medium hover:bg-slate-50 transition-colors">
                ← Atrás
            </button>
            <span x-show="paso === 1"></span>

            <button type="button" @click="siguiente()" x-show="paso < pasos.length" x-cloak
                :disabled="!puede_avanzar()"
                class="px-5 py-2 rounded-lg bg-brand-600 text-white text-sm font-semibold hover:bg-brand-700 transition-colors disabled:opacity-40 disabled:cursor-not-allowed shadow-sm">
                Siguiente →
            </button>

            <button type="submit" x-show="paso === pasos.length" x-cloak
                class="px-6 py-2.5 rounded-lg bg-brand-800 text-white text-sm font-bold hover:bg-brand-900 transition-colors shadow">
                ✓ Guardar pedido
            </button>
        </div>

    </form>
</div>
</x-card>

@endsection

@push('scripts')
<script>
    // URL para buscar clientes existentes vía API JSON
    const url_buscar_clientes = "{{ route('clientes.buscar_json') }}";

    // Fecha precargada desde el Calendario (o la de hoy)
    const fecha_inicial = @json($fecha ?? now()->toDateString());

    // Catálogo de prendas con precios base (incluye requiere_camisa/pantalon/generales)
    const catalogo_prendas = @json($precio_bases);

    // Tipos de servicio (arreglo, confección, diseño)
    const tipos_servicio_catalogo = @json($tipo_servicios);

    function flujo() {
        return {
            pasos: ['Cliente', 'Prendas', 'Medidas', 'Pedido', 'Abono', 'Resumen'],
            paso: 1,
            fecha: fecha_inicial,

            // ===== Paso 1: Cliente =====
            cliente_modo: '',
            busqueda: '',
            resultados: [],
            buscando: false,
            cliente: null,
            nuevo: { nombre: '', apellido: '', correo: '', telefono: '' },

            elegir_modo(modo) {
                this.cliente_modo = modo;
                if (modo === 'nuevo') {
                    this.cliente = null;
                }
            },

            async buscar() {
                if (this.busqueda.trim().length < 2) {
                    this.resultados = [];
                    return;
                }
                this.buscando = true;
                const respuesta = await fetch(url_buscar_clientes + '?q=' + encodeURIComponent(this.busqueda));
                this.resultados = await respuesta.json();
                this.buscando = false;
            },

            elegir_cliente(c) {
                this.cliente = c;
                this.resultados = [];
                this.busqueda = '';
            },

            cambiar_cliente() {
                this.cliente = null;
            },

            // ===== Paso 2: Prendas =====
            catalogo: catalogo_prendas,
            tipos_servicio: tipos_servicio_catalogo,
            prenda_seleccionada: '',
            tipo_seleccionado: '',
            prenda_descripcion: '',
            prendas: [],

            agregar_prenda() {
                const pb = this.catalogo.find(p => p.id == this.prenda_seleccionada);
                const ts = this.tipos_servicio.find(t => t.id == this.tipo_seleccionado);
                if (!pb || !ts) return;

                this.prendas.push({
                    id_precio_bases: pb.id,
                    id_tipo_servicios: ts.id,
                    nombre_prenda: pb.nombre_prenda,
                    complejidad: pb.complejidad,
                    precio: pb.precio,
                    tipo_nombre: ts.servicio === 'diseno' ? 'Diseño' : ts.servicio.charAt(0).toUpperCase() + ts.servicio.slice(1),
                    descripcion: this.prenda_descripcion.trim(),
                    requiere_camisa: pb.requiere_camisa,
                    requiere_pantalon: pb.requiere_pantalon,
                    requiere_generales: pb.requiere_generales,
                });

                // Resetear selectores
                this.prenda_seleccionada = '';
                this.tipo_seleccionado = '';
                this.prenda_descripcion = '';
            },

            quitar_prenda(idx) {
                this.prendas.splice(idx, 1);
            },

            total_prendas() {
                return this.prendas.reduce((suma, p) => suma + Number(p.precio), 0);
            },

            // ===== Paso 3: Medidas =====
            // Grupos de medidas según la tabla clientes
            campos_camisa: [
                { nombre: 'ancho_espalda',    etiqueta: 'Ancho espalda' },
                { nombre: 'largo_espalda',    etiqueta: 'Largo espalda' },
                { nombre: 'contorno_pecho',   etiqueta: 'Contorno pecho' },
                { nombre: 'hombro',           etiqueta: 'Hombro' },
                { nombre: 'manga',            etiqueta: 'Manga' },
                { nombre: 'puño',             etiqueta: 'Puño' },
                { nombre: 'antebrazo',        etiqueta: 'Antebrazo' },
                { nombre: 'cintura_suelta',   etiqueta: 'Cintura suelta' },
            ],
            campos_pantalon: [
                { nombre: 'cintura',       etiqueta: 'Cintura' },
                { nombre: 'tiro',          etiqueta: 'Tiro' },
                { nombre: 'pierna',        etiqueta: 'Pierna' },
                { nombre: 'rodilla',       etiqueta: 'Rodilla' },
                { nombre: 'largo_pierna',  etiqueta: 'Largo pierna' },
                { nombre: 'bota',          etiqueta: 'Bota' },
            ],
            campos_generales: [
                { nombre: 'largo_total', etiqueta: 'Largo total (altura)' },
            ],

            necesita_camisa() {
                return this.prendas.some(p => p.requiere_camisa);
            },
            necesita_pantalon() {
                return this.prendas.some(p => p.requiere_pantalon);
            },
            necesita_generales() {
                return this.prendas.some(p => p.requiere_generales);
            },

            obtener_medida(campo) {
                // Si es un cliente existente seleccionado, precargar sus medidas guardadas
                if (this.cliente && this.cliente[campo] !== null && this.cliente[campo] !== undefined) {
                    return this.cliente[campo];
                }
                return '';
            },

            tiene_medidas_guardadas() {
                if (!this.cliente) return false;
                const campos_todos = [...this.campos_camisa, ...this.campos_pantalon, ...this.campos_generales];
                return campos_todos.some(c => this.cliente[c.nombre] !== null && this.cliente[c.nombre] !== undefined && this.cliente[c.nombre] !== '' && this.cliente[c.nombre] > 0);
            },

            // ===== Paso 4: Datos del pedido =====
            fecha_entrega: '',
            descripcion: '',

            // ===== Paso 5: Abono =====
            abono_activo: false,
            abono_monto: '',
            abono_fecha: fecha_inicial,
            abono_notas: '',

            // ===== Navegación entre pasos =====
            puede_avanzar() {
                if (this.paso === 1) {
                    if (this.cliente_modo === 'existente') return this.cliente !== null;
                    if (this.cliente_modo === 'nuevo') {
                        return this.nuevo.nombre.trim() !== ''
                            && this.nuevo.apellido.trim() !== ''
                            && this.nuevo.correo.trim() !== ''
                            && this.nuevo.telefono.trim() !== '';
                    }
                    return false;
                }
                if (this.paso === 2) {
                    return this.prendas.length > 0;
                }
                if (this.paso === 4) {
                    return this.fecha_entrega !== '' && this.fecha_entrega >= this.fecha;
                }
                // Pasos 3 (medidas opcionales), 5 (abono opcional): siempre puede avanzar
                return true;
            },

            siguiente() {
                if (this.puede_avanzar() && this.paso < this.pasos.length) {
                    this.paso++;
                }
            },

            atras() {
                if (this.paso > 1) {
                    this.paso--;
                }
            },
        };
    }
</script>
@endpush
