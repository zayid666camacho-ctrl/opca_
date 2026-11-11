@extends('layouts.module')

@section('title', 'Estado de Cuenta y Finanzas')
@section('page-title', 'Estado de Cuenta y Finanzas')

@section('content')

<div class="max-w-7xl mx-auto space-y-6">

    <!-- Cabecera y Botón de Exportar Excel -->
    <div class="bg-white rounded-2xl border border-brand-200/80 shadow-xs p-5 flex flex-wrap justify-between items-center gap-4">
        <div>
            <h2 class="text-xl font-bold text-brand-900">Control Financiero del Taller</h2>
            <p class="text-xs sm:text-sm text-brand-900/65 mt-0.5">Control de ingresos mensuales, abonos y saldos pendientes por cobrar.</p>
        </div>
        <a href="{{ route('finanzas.exportar', ['anio' => $anio]) }}"
           class="bg-emerald-600 hover:bg-emerald-700 text-white text-xs sm:text-sm font-semibold px-4 py-2.5 rounded-xl shadow-xs transition-colors flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            Exportar a Excel ({{ $anio }})
        </a>
    </div>

    <!-- Mensajes de Error -->
    @if ($errors->any())
        <div class="bg-rose-50 border border-rose-300 text-rose-800 p-4 rounded-xl shadow-xs">
            <ul class="list-disc list-inside text-sm space-y-0.5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- ===== SECCIÓN 1: REGISTRAR PAGO ===== -->
    <div class="bg-white rounded-2xl border border-brand-200/80 shadow-xs p-6">
        <h3 class="text-base font-bold text-brand-900 mb-4 flex items-center gap-2">
            <span class="w-2.5 h-2.5 rounded-full bg-brand-600"></span>
            Registrar Nuevo Abono / Pago
        </h3>

        @if ($pedidos->isEmpty())
            <p class="text-brand-900/50 text-sm italic">No hay pedidos con saldo pendiente en este momento.</p>
        @else
            <form action="{{ route('finanzas.store') }}" method="POST"
                class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                @csrf

                <div class="md:col-span-2">
                    <label class="block mb-1.5 text-xs font-semibold text-brand-900/75">Pedido / Cliente</label>
                    <select name="id_pedido" class="w-full bg-brand-50/50 border border-brand-200 rounded-xl px-3.5 py-2.5 text-sm text-brand-900 focus:ring-2 focus:ring-brand-500 focus:outline-none">
                        @foreach ($pedidos as $pedido)
                            <option value="{{ $pedido->id }}" {{ old('id_pedido') == $pedido->id ? 'selected' : '' }}>
                                #{{ $pedido->id }} · {{ $pedido->cliente->nombre }} {{ $pedido->cliente->apellido }} 
                                (Debe: ${{ number_format($pedido->saldo_pendiente, 2) }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block mb-1.5 text-xs font-semibold text-brand-900/75">Monto ($)</label>
                    <input type="number" step="0.01" min="0.01" name="monto" value="{{ old('monto') }}" placeholder="0.00"
                        class="w-full bg-brand-50/50 border border-brand-200 rounded-xl px-3.5 py-2.5 text-sm text-brand-900 focus:ring-2 focus:ring-brand-500 focus:outline-none">
                </div>

                <div>
                    <label class="block mb-1.5 text-xs font-semibold text-brand-900/75">Fecha del Pago</label>
                    <input type="date" name="fecha" value="{{ old('fecha', now()->toDateString()) }}"
                        class="w-full bg-brand-50/50 border border-brand-200 rounded-xl px-3.5 py-2.5 text-sm text-brand-900 focus:ring-2 focus:ring-brand-500 focus:outline-none">
                </div>

                <div class="md:col-span-3">
                    <label class="block mb-1.5 text-xs font-semibold text-brand-900/75">Notas (opcional)</label>
                    <input type="text" name="notas" value="{{ old('notas') }}" placeholder="Ej. Pago parcial en efectivo o transferencia..."
                        class="w-full bg-brand-50/50 border border-brand-200 rounded-xl px-3.5 py-2.5 text-sm text-brand-900 focus:ring-2 focus:ring-brand-500 focus:outline-none">
                </div>

                <button type="submit" class="bg-brand-600 hover:bg-brand-700 text-white font-semibold rounded-xl px-5 py-2.5 text-sm transition-colors shadow-xs">
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

        <div class="bg-white rounded-2xl border border-brand-200/80 shadow-xs overflow-hidden flex flex-col justify-between">
            <div>
                <div class="px-6 py-4 border-b border-brand-100 flex items-center justify-between bg-brand-50/60">
                    <a href="{{ route('finanzas.index', ['anio' => $anio - 1]) }}"
                        class="w-8 h-8 rounded-lg bg-white border border-brand-200 flex items-center justify-center font-bold text-brand-900 hover:bg-brand-100 transition-colors">&lsaquo;</a>
                    <span class="font-bold text-brand-900 text-sm">Resumen de Ingresos · {{ $anio }}</span>
                    <a href="{{ route('finanzas.index', ['anio' => $anio + 1]) }}"
                        class="w-8 h-8 rounded-lg bg-white border border-brand-200 flex items-center justify-center font-bold text-brand-900 hover:bg-brand-100 transition-colors">&rsaquo;</a>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-brand-100/40 text-brand-900/70 uppercase text-xs font-bold tracking-wider">
                            <tr>
                                <th class="px-5 py-2.5 text-left">Mes</th>
                                <th class="px-5 py-2.5 text-right">Pagos</th>
                                <th class="px-5 py-2.5 text-right">Total recibido</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-brand-100">
                            @foreach ($resumen as $mes => $datos)
                                <tr class="{{ ($anio == now()->year && $mes == now()->month) ? 'bg-brand-100/60 font-semibold' : 'hover:bg-brand-50/40' }}">
                                    <td class="px-5 py-2.5 text-brand-900">{{ $nombres_meses[$mes] }}</td>
                                    <td class="px-5 py-2.5 text-right text-brand-900/65">{{ $datos['cantidad'] }}</td>
                                    <td class="px-5 py-2.5 text-right font-semibold text-brand-900">${{ number_format($datos['total'], 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-brand-50 px-6 py-3.5 border-t border-brand-200 flex justify-between items-center text-sm">
                <span class="font-bold text-brand-900">Total Anual ({{ $anio }})</span>
                <span class="font-extrabold text-brand-700 text-base">${{ number_format($total_anual, 2) }}</span>
            </div>
        </div>

        <!-- 2B. Saldos pendientes -->
        <div class="bg-white rounded-2xl border border-brand-200/80 shadow-xs overflow-hidden">
            <div class="px-6 py-4 border-b border-brand-100 font-bold text-brand-900 text-sm bg-brand-50/60">
                Saldos Pendientes por Cobrar
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-brand-100/40 text-brand-900/70 uppercase text-xs font-bold tracking-wider">
                        <tr>
                            <th class="px-5 py-2.5 text-left">Cliente</th>
                            <th class="px-5 py-2.5 text-left">Pedido</th>
                            <th class="px-5 py-2.5 text-right">Saldo Pendiente</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-brand-100">
                        @forelse ($pedidos as $pedido)
                            <tr class="hover:bg-brand-50/40">
                                <td class="px-5 py-3 text-brand-900 font-semibold">
                                    {{ $pedido->cliente->nombre }} {{ $pedido->cliente->apellido }}
                                </td>
                                <td class="px-5 py-3 text-xs">
                                    <a href="{{ route('pedidos.edit', $pedido->id) }}" class="text-brand-600 hover:underline font-semibold">
                                        #{{ $pedido->id }}
                                    </a>
                                </td>
                                <td class="px-5 py-3 text-right font-bold text-rose-600">${{ number_format($pedido->saldo_pendiente, 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-5 py-10 text-center text-brand-900/50 italic">Ningún pedido tiene saldo pendiente.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- ===== SECCIÓN 3: HISTORIAL DE PAGOS ===== -->
    <div x-data="{ editando_id: null }" class="bg-white rounded-2xl border border-brand-200/80 shadow-xs overflow-hidden">
        <div class="px-6 py-4 border-b border-brand-100 bg-brand-50/60 flex flex-wrap items-center justify-between gap-4">
            <div>
                <h3 class="font-bold text-brand-900 text-sm">
                    Historial de Pagos Recientes
                </h3>
                <p class="text-xs text-brand-900/60 mt-0.5">
                    @if (!empty($mes_historial))
                        Mostrando pagos del mes seleccionado ({{ $mes_historial }}).
                    @else
                        Mostrando pagos registrados en los últimos 10 días.
                    @endif
                </p>
            </div>

            <form action="{{ route('finanzas.index') }}" method="GET" class="flex flex-wrap items-center gap-2">
                <input type="hidden" name="anio" value="{{ $anio }}">
                <label class="text-xs font-semibold text-brand-900/70">Filtrar por mes:</label>
                <input type="month" name="mes_historial" value="{{ $mes_historial }}"
                    class="bg-white border border-brand-200 rounded-xl px-3 py-1.5 text-xs text-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-500">
                <button type="submit"
                    class="bg-brand-800 hover:bg-brand-900 text-white text-xs font-semibold px-3.5 py-1.5 rounded-xl transition-colors cursor-pointer">
                    Buscar mes
                </button>
                @if (!empty($mes_historial))
                    <a href="{{ route('finanzas.index', ['anio' => $anio]) }}"
                        class="text-xs font-semibold text-brand-600 hover:underline px-2 py-1.5">
                        Ver últimos 10 días
                    </a>
                @endif
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-brand-100/40 text-brand-900/70 uppercase text-xs font-bold tracking-wider">
                    <tr>
                        <th class="px-6 py-3 text-left">Fecha</th>
                        <th class="px-6 py-3 text-left">Cliente</th>
                        <th class="px-6 py-3 text-left">Pedido</th>
                        <th class="px-6 py-3 text-right">Monto</th>
                        <th class="px-6 py-3 text-left">Notas</th>
                        <th class="px-6 py-3 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-brand-100">
                    @forelse ($pagos as $pago)
                        <tr class="hover:bg-brand-50/40">
                            <td class="px-6 py-3 text-brand-900/70 text-xs">{{ $pago->fecha }}</td>
                            <td class="px-6 py-3 text-brand-900 font-semibold">
                                {{ $pago->pedido->cliente->nombre }} {{ $pago->pedido->cliente->apellido }}
                            </td>
                            <td class="px-6 py-3 text-brand-900/70 text-xs">#{{ $pago->pedido->id }}</td>
                            <td class="px-6 py-3 text-right font-bold text-emerald-600">+${{ number_format($pago->monto, 2) }}</td>
                            <td class="px-6 py-3 text-brand-900/65 text-xs">{{ $pago->notas ?: '—' }}</td>
                            <td class="px-6 py-3 text-right">
                                <button type="button"
                                    @click="editando_id = (editando_id === {{ $pago->id }} ? null : {{ $pago->id }})"
                                    class="w-5 h-5 inline-flex items-center justify-center text-brand-900/50 hover:text-brand-600 transition-colors cursor-pointer"
                                    title="Editar pago">
                                    @include('layouts.partials.icons', ['icon' => 'pencil'])
                                </button>
                            </td>
                        </tr>
                        <tr x-show="editando_id === {{ $pago->id }}" x-cloak class="bg-brand-50/70">
                            <td colspan="6" class="px-6 py-4">
                                <form action="{{ route('finanzas.update', $pago->id) }}" method="POST"
                                    class="grid grid-cols-1 sm:grid-cols-4 gap-3 items-end">
                                    @csrf
                                    @method('PUT')
                                    <div>
                                        <label class="block mb-1 text-xs font-semibold text-brand-900/75">Monto ($)</label>
                                        <input type="number" step="0.01" min="1000" name="monto" value="{{ $pago->monto }}" required
                                            class="w-full bg-white border border-brand-200 rounded-xl px-3 py-2 text-xs text-brand-900 focus:ring-2 focus:ring-brand-500 focus:outline-none">
                                    </div>
                                    <div>
                                        <label class="block mb-1 text-xs font-semibold text-brand-900/75">Fecha del pago</label>
                                        <input type="date" name="fecha" value="{{ $pago->fecha }}" required
                                            class="w-full bg-white border border-brand-200 rounded-xl px-3 py-2 text-xs text-brand-900 focus:ring-2 focus:ring-brand-500 focus:outline-none">
                                    </div>
                                    <div>
                                        <label class="block mb-1 text-xs font-semibold text-brand-900/75">Notas</label>
                                        <input type="text" name="notas" value="{{ $pago->notas }}" placeholder="Observación del pago..."
                                            class="w-full bg-white border border-brand-200 rounded-xl px-3 py-2 text-xs text-brand-900 focus:ring-2 focus:ring-brand-500 focus:outline-none">
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <button type="submit"
                                            class="bg-brand-600 hover:bg-brand-700 text-white text-xs font-semibold px-4 py-2 rounded-xl transition-colors cursor-pointer">
                                            Guardar cambios
                                        </button>
                                        <button type="button" @click="editando_id = null"
                                            class="border border-brand-200 bg-white hover:bg-brand-100 text-brand-900 text-xs font-semibold px-3 py-2 rounded-xl transition-colors cursor-pointer">
                                            Cancelar
                                        </button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-brand-900/50 italic">
                                @if (!empty($mes_historial))
                                    No se encontraron pagos registrados en el mes seleccionado ({{ $mes_historial }}).
                                @else
                                    No hay pagos registrados en los últimos 10 días. Usa el filtro superior para consultar un mes específico.
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection
