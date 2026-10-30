@extends('layouts.module')

@section('title', 'Lista de Pedidos')
@section('page-title', 'Lista General de Pedidos')

@section('content')

<div class="max-w-7xl mx-auto">

    <div class="bg-white rounded-2xl border border-brand-200/80 shadow-xs p-5 mb-6 flex flex-wrap items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-brand-900">
                Historial y Gestión de Pedidos
            </h2>
            <p class="text-xs sm:text-sm text-brand-900/65 mt-0.5">
                Consulta, filtra o edita cualquier encargo registrado en el taller.
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-2.5">
            <a href="{{ route('pedidos.kanban') }}"
               class="px-3.5 py-2 rounded-xl bg-brand-50 border border-brand-200 text-xs font-semibold text-brand-900 hover:bg-brand-100 transition-colors">
                Ver Tablero Kanban
            </a>
            <a href="{{ route('pedidos.nuevo') }}"
               class="bg-brand-600 hover:bg-brand-700 text-white text-xs sm:text-sm font-semibold px-4 py-2 rounded-xl shadow-xs transition-colors">
                + Nuevo pedido
            </a>
        </div>
    </div>

    <div x-data="{
            cliente: '',
            estado: '',
            desde: '',
            hasta: '',
            filtrar() {
                const parametros = new URLSearchParams({
                    cliente: this.cliente,
                    estado: this.estado,
                    desde: this.desde,
                    hasta: this.hasta,
                });
                fetch(`{{ route('pedidos.filtrar') }}?${parametros}`)
                    .then(r => r.text())
                    .then(html => { this.$refs.tbody.innerHTML = html; });
            }
        }"
        class="bg-white rounded-2xl border border-brand-200/80 shadow-xs overflow-hidden">

        <div class="p-4 sm:p-5 bg-brand-50/50 border-b border-brand-100 flex flex-col lg:flex-row gap-3 lg:items-end">
            <div class="flex-1">
                <label class="block text-xs font-semibold text-brand-900/70 mb-1">Cliente</label>
                <input
                    type="text"
                    x-model="cliente"
                    @input.debounce.300ms="filtrar()"
                    placeholder="Buscar por nombre o apellido..."
                    class="w-full px-3.5 py-2 bg-white border border-brand-200 rounded-xl text-sm text-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-500"
                >
            </div>

            <div>
                <label class="block text-xs font-semibold text-brand-900/70 mb-1">Estado</label>
                <select
                    x-model="estado"
                    @change="filtrar()"
                    class="w-full lg:w-48 px-3.5 py-2 bg-white border border-brand-200 rounded-xl text-sm text-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-500"
                >
                    <option value="">Todos los estados</option>
                    <option value="recibido">Recibido</option>
                    <option value="en_proceso">En proceso</option>
                    <option value="terminado">Terminado</option>
                    <option value="entregado">Entregado</option>
                    <option value="cancelado">Cancelado</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-brand-900/70 mb-1">Entrega desde</label>
                <input type="date" x-model="desde" @change="filtrar()"
                    class="w-full px-3.5 py-2 bg-white border border-brand-200 rounded-xl text-sm text-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-500">
            </div>

            <div>
                <label class="block text-xs font-semibold text-brand-900/70 mb-1">Entrega hasta</label>
                <input type="date" x-model="hasta" @change="filtrar()"
                    class="w-full px-3.5 py-2 bg-white border border-brand-200 rounded-xl text-sm text-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-500">
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-brand-100/50 border-b border-brand-200/70">
                    <tr class="text-left text-xs font-bold text-brand-900/75 uppercase tracking-wider">
                        <th class="px-6 py-3.5">Cliente</th>
                        <th class="px-6 py-3.5">Descripción</th>
                        <th class="px-6 py-3.5">Fecha recepción</th>
                        <th class="px-6 py-3.5">Fecha entrega</th>
                        <th class="px-6 py-3.5">Estado</th>
                        <th class="px-6 py-3.5 text-right">Acciones</th>
                    </tr>
                </thead>

                <tbody x-ref="tbody" class="divide-y divide-brand-100">
                    @include('pedido._tabla', ['pedidos' => $pedidos])
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection
