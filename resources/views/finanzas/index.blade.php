@extends('layouts.module')

@section('title', 'Finanzas')
@section('page-title', 'Creaciones NayJa: Finanzas')

@section('content')

<x-card>
<div class="container mx-auto mt-6 space-y-8">

    <!-- Título y Botón de Exportar Excel (Preparado para la siguiente fase) -->
    <div class="flex justify-between items-center bg-white p-6 rounded-xl shadow-sm border border-slate-200">
        <div>
            <h2 class="text-3xl font-bold text-slate-800">Módulo de Finanzas</h2>
            <p class="text-sm text-slate-500 mt-1">Control de ingresos, abonos y saldos pendientes del taller.</p>
        </div>
        <!-- Botón placeholder para cuando implementes la exportación a Excel -->
        <a href="{{ route('finanzas.exportar', ['anio' => $anio]) }}" class="bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold px-4 py-2.5 rounded-lg shadow-sm transition flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            Exportar a Excel
        </a>
    </div>

    <!-- Mensajes de Error -->
    @if ($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-r-lg shadow-sm">
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- ===== SECCIÓN 1: REGISTRAR PAGO (Destacada) ===== -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
            <span class="w-2.5 h-2.5 rounded-full bg-primary-500"></span>
            Registrar Nuevo Abono / Pago
        </h3>

        @if ($pedidos->isEmpty())
            <p class="text-slate-400 text-sm italic">No hay pedidos con saldo pendiente en este momento.</p>
        @else
            <form action="{{ route('finanzas.store') }}" method="POST"
                class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                @csrf

                <div class="md:col-span-2">
                    <label class="block mb-1 text-xs font-bold uppercase tracking-wider text-slate-600">Pedido / Cliente</label>
                    <select name="id_pedido" class="w-full border border-slate-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-primary-400 focus:outline-none">
                        @foreach ($pedidos as $pedido)
                            <option value="{{ $pedido->id }}" {{ old('id_pedido') == $pedido->id ? 'selected' : '' }}>
                                #{{ $pedido->id }} · {{ $pedido->cliente->nombre }} {{ $pedido->cliente->apellido }} 
                                (Debe: ${{ number_format($pedido->saldo_pendiente, 2) }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block mb-1 text-xs font-bold uppercase tracking-wider text-slate-600">Monto ($)</label>
                    <input type="number" step="0.01" min="0.01" name="monto" value="{{ old('monto') }}" placeholder="0.00"
                        class="w-full border border-slate-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-primary-400 focus:outline-none">
                </div>

                <div>
                    <label class="block mb-1 text-xs font-bold uppercase tracking-wider text-slate-600">Fecha del Pago</label>
                    <input type="date" name="fecha" value="{{ old('fecha', now()->toDateString()) }}"
                        class="w-full border border-slate-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-primary-400 focus:outline-none">
                </div>

                <div class="md:col-span-3">
                    <label class="block mb-1 text-xs font-bold uppercase tracking-wider text-slate-600">Notas (opcional)</label>
                    <input type="text" name="notas" value="{{ old('notas') }}" placeholder="Ej. Pago parcial en efectivo..."
                        class="w-full border border-slate-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-primary-400 focus:outline-none">
                </div>

                <button type="submit" class="bg-primary-500 hover:bg-primary-600 text-white font-semibold rounded-lg px-5 py-2.5 text-sm transition shadow-sm">
                    Guardar Pago
                </button>
            </form>
        @endif
    </div>

    <!-- ===== SECCIÓN 2: DOS COLUMNAS (Ingresos por Mes & Saldos Pendientes) ===== -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <!-- 2A. Ingresos por mes -->
        @php
            $nombres_meses = [
                1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
                5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
                9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre',
            ];
            $total_anual = collect($resumen)->sum('total');
        @endphp

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden flex flex-col justify-between">
            <div>
                <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                    <a href="{{ route('finanzas.index', ['anio' => $anio - 1]) }}"
                        class="text-xl font-bold text-slate-400 hover:text-primary-600 px-2">&lsaquo;</a>
                    <span class="font-bold text-slate-700 text-sm">Resumen de Ingresos · {{ $anio }}</span>
                    <a href="{{ route('finanzas.index', ['anio' => $anio + 1]) }}"
                        class="text-xl font-bold text-slate-400 hover:text-primary-600 px-2">&rsaquo;</a>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-slate-50 text-slate-500 uppercase text-xs tracking-wider">
                            <tr>
                                <th class="px-5 py-2.5 text-left">Mes</th>
                                <th class="px-5 py-2.5 text-right">Pagos</th>
                                <th class="px-5 py-2.5 text-right">Total recibido</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach ($resumen as $mes => $datos)
                                <tr class="{{ ($anio == now()->year && $mes == now()->month) ? 'bg-primary-50/60 font-medium' : '' }}">
                                    <td class="px-5 py-2.5 text-slate-700">{{ $nombres_meses[$mes] }}</td>
                                    <td class="px-5 py-2.5 text-right text-slate-500">{{ $datos['cantidad'] }}</td>
                                    <td class="px-5 py-2.5 text-right font-semibold text-slate-700">${{ number_format($datos['total'], 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-slate-50 px-6 py-3 border-t border-slate-200 flex justify-between items-center text-sm">
                <span class="font-bold text-slate-700">Total Anual ({{ $anio }})</span>
                <span class="font-extrabold text-slate-900 text-base">${{ number_format($total_anual, 2) }}</span>
            </div>
        </div>

        <!-- 2B. Saldos pendientes -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 font-bold text-slate-700 text-sm bg-slate-50/50">
                Saldos Pendientes por Cobrar
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-slate-50 text-slate-500 uppercase text-xs tracking-wider">
                        <tr>
                            <th class="px-5 py-2.5 text-left">Cliente</th>
                            <th class="px-5 py-2.5 text-left">Pedido</th>
                            <th class="px-5 py-2.5 text-right">Saldo</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($pedidos as $pedido)
                            <tr>
                                <td class="px-5 py-3 text-slate-700 font-medium">
                                    {{ $pedido->cliente->nombre }} {{ $pedido->cliente->apellido }}
                                </td>
                                <td class="px-5 py-3 text-slate-500 text-xs">#{{ $pedido->id }}</td>
                                <td class="px-5 py-3 text-right font-bold text-red-600">${{ number_format($pedido->saldo_pendiente, 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-5 py-8 text-center text-slate-400 italic">Ningún pedido tiene saldo pendiente.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- ===== SECCIÓN 3: HISTORIAL DE PAGOS ===== -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 font-bold text-slate-700 text-sm bg-slate-50/50">
            Historial de Pagos Recientes
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50 text-slate-500 uppercase text-xs tracking-wider">
                    <tr>
                        <th class="px-6 py-3 text-left">Fecha</th>
                        <th class="px-6 py-3 text-left">Cliente</th>
                        <th class="px-6 py-3 text-left">Pedido</th>
                        <th class="px-6 py-3 text-right">Monto</th>
                        <th class="px-6 py-3 text-left">Notas</th>
                        <th class="px-6 py-3 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($pagos as $pago)
                        <tr>
                            <td class="px-6 py-3 text-slate-500 text-xs">{{ $pago->fecha }}</td>
                            <td class="px-6 py-3 text-slate-700 font-medium">
                                {{ $pago->pedido->cliente->nombre }} {{ $pago->pedido->cliente->apellido }}
                            </td>
                            <td class="px-6 py-3 text-slate-500 text-xs">#{{ $pago->pedido->id }}</td>
                            <td class="px-6 py-3 text-right font-bold text-emerald-600">+${{ number_format($pago->monto, 2) }}</td>
                            <td class="px-6 py-3 text-slate-500 text-xs">{{ $pago->notas ?: '—' }}</td>
                            <td class="px-6 py-3 text-right">
                                <form action="{{ route('finanzas.destroy', $pago->id) }}" method="POST"
                                    class="inline-block"
                                    onsubmit="return confirm('Al eliminar este pago, el saldo del pedido vuelve a subir. ¿Continuar?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-slate-400 hover:text-red-600 transition" title="Eliminar pago">
                                        <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-slate-400 italic">Todavía no hay pagos registrados en el sistema.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
</x-card>

@endsection