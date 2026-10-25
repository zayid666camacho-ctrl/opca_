@extends('layouts.module')

@section('title', 'Nuevo pedido')
@section('page-title', 'Nuevo pedido')

@section('content')

<x-card>
<div class="max-w-3xl mx-auto" x-data="flujo()">

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-5">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('pedidos.guardar') }}" method="POST"
        @keydown.enter="if ($event.target.tagName === 'INPUT') $event.preventDefault()">
        @csrf

        {{-- Fecha del pedido --}}
        <div class="flex items-center gap-3 mb-6">
            <label class="text-sm font-semibold text-slate-600">Fecha del pedido</label>
            <input type="date" name="fecha" x-model="fecha" class="border rounded px-3 py-2">
        </div>

        {{-- Indicador de pasos --}}
        <ol class="flex flex-wrap gap-2 mb-6 text-sm">
            <template x-for="(nombre, i) in pasos" :key="i">
                <li class="px-3 py-1 rounded-full border"
                    :class="paso === i + 1
                        ? 'bg-primary-500 text-white border-primary-500'
                        : (paso > i + 1 ? 'bg-primary-100 text-primary-700 border-primary-200' : 'text-slate-400 border-slate-200')"
                    x-text="(i + 1) + '. ' + nombre"></li>
            </template>
        </ol>

        {{-- ===== PASO 1: Cliente ===== --}}
        <section x-show="paso === 1" x-cloak class="bg-white rounded-lg shadow p-6">
            <h3 class="text-xl font-semibold text-slate-700 mb-4">¿El cliente es nuevo o ya existe?</h3>

            <input type="hidden" name="cliente_modo" :value="cliente_modo">

            <div class="grid grid-cols-2 gap-3 mb-6">
                <button type="button" @click="elegir_modo('nuevo')"
                    class="border rounded-lg px-4 py-4 text-left"
                    :class="cliente_modo === 'nuevo' ? 'border-primary-500 bg-primary-50' : 'border-slate-200 hover:bg-slate-50'">
                    <span class="font-semibold text-slate-700">Cliente nuevo</span>
                    <span class="block text-sm text-slate-500">Registrar sus datos ahora</span>
                </button>

                <button type="button" @click="elegir_modo('existente')"
                    class="border rounded-lg px-4 py-4 text-left"
                    :class="cliente_modo === 'existente' ? 'border-primary-500 bg-primary-50' : 'border-slate-200 hover:bg-slate-50'">
                    <span class="font-semibold text-slate-700">Cliente existente</span>
                    <span class="block text-sm text-slate-500">Buscarlo por nombre</span>
                </button>
            </div>

            {{-- Cliente existente --}}
            <div x-show="cliente_modo === 'existente'">

                <template x-if="!cliente">
                    <div>
                        <input type="text" x-model="busqueda" @input.debounce.300ms="buscar()"
                            placeholder="Buscar por nombre y apellido..."
                            class="w-full border rounded px-3 py-2">

                        <ul class="mt-2 divide-y divide-slate-100 border border-slate-100 rounded" x-show="resultados.length">
                            <template x-for="c in resultados" :key="c.id">
                                <li>
                                    <button type="button" @click="elegir_cliente(c)"
                                        class="w-full text-left px-3 py-2 hover:bg-slate-50">
                                        <span class="font-medium text-slate-700" x-text="c.nombre + ' ' + c.apellido"></span>
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
                    <div class="flex items-center justify-between bg-primary-50 border border-primary-100 rounded px-4 py-3">
                        <div>
                            <p class="font-semibold text-slate-700" x-text="cliente.nombre + ' ' + cliente.apellido"></p>
                            <p class="text-sm text-slate-500" x-text="cliente.correo + ' · ' + cliente.telefono"></p>
                        </div>
                        <button type="button" @click="cambiar_cliente()" class="text-sm text-primary-600 hover:underline">
                            Cambiar
                        </button>
                        <input type="hidden" name="idcliente" :value="cliente.id">
                    </div>
                </template>
            </div>

            {{-- Cliente nuevo --}}
            <template x-if="cliente_modo === 'nuevo'">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-600">Nombre</label>
                        <input type="text" name="cliente[nombre]" x-model="nuevo.nombre" class="mt-1 w-full border rounded px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-600">Apellido</label>
                        <input type="text" name="cliente[apellido]" x-model="nuevo.apellido" class="mt-1 w-full border rounded px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-600">Correo</label>
                        <input type="email" name="cliente[correo]" x-model="nuevo.correo" class="mt-1 w-full border rounded px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-600">Teléfono</label>
                        <input type="text" name="cliente[telefono]" x-model="nuevo.telefono" class="mt-1 w-full border rounded px-3 py-2">
                    </div>
                </div>
            </template>
        </section>

        {{-- ===== PASOS 2 a 6: se construyen en las siguientes partes ===== --}}
        <section x-show="paso === 2" x-cloak class="bg-white rounded-lg shadow p-6 text-slate-400">Prendas (en construcción)</section>
        <section x-show="paso === 3" x-cloak class="bg-white rounded-lg shadow p-6 text-slate-400">Medidas (en construcción)</section>
        <section x-show="paso === 4" x-cloak class="bg-white rounded-lg shadow p-6 text-slate-400">Datos del pedido (en construcción)</section>
        <section x-show="paso === 5" x-cloak class="bg-white rounded-lg shadow p-6 text-slate-400">Abono (en construcción)</section>
        <section x-show="paso === 6" x-cloak class="bg-white rounded-lg shadow p-6 text-slate-400">Resumen (en construcción)</section>

        {{-- Navegación --}}
        <div class="flex justify-between mt-6">
            <button type="button" @click="atras()" x-show="paso > 1" x-cloak
                class="px-4 py-2 rounded border border-slate-300 text-slate-600 hover:bg-slate-50">
                ← Atrás
            </button>
            <span x-show="paso === 1"></span>

            <button type="button" @click="siguiente()" x-show="paso < pasos.length" x-cloak
                :disabled="!puede_avanzar()"
                class="px-4 py-2 rounded bg-primary-500 text-white hover:bg-primary-600 disabled:opacity-40 disabled:cursor-not-allowed">
                Siguiente →
            </button>

            <button type="submit" x-show="paso === pasos.length" x-cloak
                class="px-4 py-2 rounded bg-primary-600 text-white hover:bg-primary-700">
                Guardar pedido
            </button>
        </div>

    </form>
</div>
</x-card>

@endsection

@push('scripts')
<script>
    const url_buscar_clientes = "{{ route('clientes.buscar_json') }}";

    function flujo() {
        return {
            pasos: ['Cliente', 'Prendas', 'Medidas', 'Pedido', 'Abono', 'Resumen'],
            paso: 1,
            const fecha = @json($fecha ?? now()->toDateString());

            // Paso 1: cliente
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

            // Navegación entre pasos
            puede_avanzar() {
                if (this.paso === 1) {
                    if (this.cliente_modo === 'existente') {
                        return this.cliente !== null;
                    }
                    if (this.cliente_modo === 'nuevo') {
                        return this.nuevo.nombre.trim() !== ''
                            && this.nuevo.apellido.trim() !== ''
                            && this.nuevo.correo.trim() !== ''
                            && this.nuevo.telefono.trim() !== '';
                    }
                    return false;
                }
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