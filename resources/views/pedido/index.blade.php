@extends('layouts.module')

@section('title', 'Pedidos')
@section('page-title', 'Creaciones NayJa: Pedidos')

@section('content')

<x-card>
    <div class="container mx-auto mt-10">

        <div class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-bold text-gray-700">
                Pedidos
            </h2>

            <a href="{{ route('pedidos.create') }}"
            class="bg-primary-500 hover:bg-primary-600 text-white px-4 py-2 rounded">
                Nuevo pedido
            </a>
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
            class="bg-white rounded-lg shadow overflow-hidden">

            <div class="p-4 border-b border-slate-100 flex flex-col lg:flex-row gap-3 lg:items-end">
                <input
                    type="text"
                    x-model="cliente"
                    @input.debounce.300ms="filtrar()"
                    placeholder="Buscar por cliente..."
                    class="w-full lg:w-64 px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-400"
                >

                <select
                    x-model="estado"
                    @change="filtrar()"
                    class="px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-400"
                >
                    <option value="">Todos los estados</option>
                    <option value="recibido">Recibido</option>
                    <option value="en_proceso">En proceso</option>
                    <option value="terminado">Terminado</option>
                    <option value="entregado">Entregado</option>
                    <option value="cancelado">Cancelado</option>
                </select>

                <label class="text-xs text-slate-500 flex flex-col gap-1">
                    Desde
                    <input type="date" x-model="desde" @change="filtrar()"
                        class="px-3 py-2 border border-slate-300 rounded-lg text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-primary-400">
                </label>

                <label class="text-xs text-slate-500 flex flex-col gap-1">
                    Hasta
                    <input type="date" x-model="hasta" @change="filtrar()"
                        class="px-3 py-2 border border-slate-300 rounded-lg text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-primary-400">
                </label>
            </div>

            <table class="min-w-full">
                <thead class="bg-slate-50">
                    <tr class="text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">
                        <th class="px-6 py-3">Cliente</th>
                        <th class="px-6 py-3">Descripción</th>
                        <th class="px-6 py-3">Fecha</th>
                        <th class="px-6 py-3">Entrega</th>
                        <th class="px-6 py-3">Estado</th>
                        <th class="px-6 py-3 text-right">Acciones</th>
                    </tr>
                </thead>

                <tbody x-ref="tbody" class="divide-y divide-slate-100">
                    @include('pedido._tabla', ['pedidos' => $pedidos])
                </tbody>
            </table>
        </div>

    </div>
</x-card>

@endsection 