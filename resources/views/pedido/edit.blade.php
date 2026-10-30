@extends('layouts.module')

@section('title', 'Detalle y Edición de Pedido #' . $pedido->id)
@section('page-title', 'Detalle y Edición del Pedido #' . $pedido->id)

@section('content')

<div class="max-w-6xl mx-auto space-y-6">

    {{-- Cabecera con navegación rápida --}}
    <div class="bg-white rounded-2xl border border-brand-200/80 shadow-xs p-5 flex flex-wrap items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2.5">
                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-brand-100 text-brand-700 border border-brand-200">
                    Pedido #{{ $pedido->id }}
                </span>
                <h2 class="text-lg sm:text-xl font-bold text-brand-900">
                    {{ $pedido->cliente->nombre }} {{ $pedido->cliente->apellido ?? '' }}
                </h2>
            </div>
            <p class="text-xs sm:text-sm text-brand-900/65 mt-1">
                Gestiona las fechas, estado, prendas asociadas y medidas corporales del cliente.
            </p>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('pedidos.kanban') }}"
               class="px-3.5 py-2 rounded-xl bg-brand-50 border border-brand-200 text-xs font-semibold text-brand-900 hover:bg-brand-100 transition-colors">
                ← Tablero Kanban
            </a>
            <a href="{{ route('pedidos.index') }}"
               class="px-3.5 py-2 rounded-xl bg-brand-50 border border-brand-200 text-xs font-semibold text-brand-900 hover:bg-brand-100 transition-colors">
                Lista de Pedidos
            </a>
        </div>
    </div>

    @if($errors->any())
        <div class="bg-rose-50 border border-rose-300 text-rose-800 px-4 py-3 rounded-xl text-sm">
            <ul class="list-disc list-inside space-y-0.5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        {{-- Columna izquierda: Datos del pedido --}}
        <div class="lg:col-span-5">
            <div class="bg-white rounded-2xl border border-brand-200/80 shadow-xs p-6">
                <h3 class="text-base font-bold text-brand-900 mb-4 pb-3 border-b border-brand-100">
                    Datos Generales del Pedido
                </h3>

                <form action="{{ route('pedidos.update', $pedido->id) }}" method="post" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block mb-1.5 text-xs font-semibold text-brand-900/80">Fecha de recepción</label>
                            <input type="date" name="fecha" value="{{ $pedido->fecha }}"
                                class="w-full bg-brand-50/50 border border-brand-200 rounded-xl px-3.5 py-2 text-sm text-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-500">
                        </div>

                        <div>
                            <label class="block mb-1.5 text-xs font-semibold text-brand-900/80">Fecha de entrega</label>
                            <input type="date" name="fecha_entrega" value="{{ $pedido->fecha_entrega }}"
                                class="w-full bg-brand-50/50 border border-brand-200 rounded-xl px-3.5 py-2 text-sm text-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-500">
                        </div>
                    </div>

                    <div>
                        <label class="block mb-1.5 text-xs font-semibold text-brand-900/80">Estado del pedido</label>
                        <select name="estado" id="estado"
                            class="w-full bg-brand-50/50 border border-brand-200 rounded-xl px-3.5 py-2.5 text-sm text-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-500">
                            <option value="recibido" {{ $pedido->estado == 'recibido' ? 'selected' : '' }}>Recibido</option>
                            <option value="en_proceso" {{ $pedido->estado == 'en_proceso' ? 'selected' : '' }}>En proceso</option>
                            <option value="terminado" {{ $pedido->estado == 'terminado' ? 'selected' : '' }}>Terminado</option>
                            <option value="entregado" {{ $pedido->estado == 'entregado' ? 'selected' : '' }}>Entregado</option>
                            <option value="cancelado" {{ $pedido->estado == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                        </select>
                    </div>

                    <div>
                        <label class="block mb-1.5 text-xs font-semibold text-brand-900/80">Descripción general / Notas</label>
                        <input type="text" name="descripcion" value="{{ $pedido->descripcion }}"
                            class="w-full bg-brand-50/50 border border-brand-200 rounded-xl px-3.5 py-2 text-sm text-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-500">
                    </div>

                    <div>
                        <label class="block mb-1.5 text-xs font-semibold text-brand-900/80">Cliente asociado</label>
                        <select name="idcliente" id="idcliente"
                            class="w-full bg-brand-50/50 border border-brand-200 rounded-xl px-3.5 py-2.5 text-sm text-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-500">
                            @foreach ($cliente as $clientes)
                                <option value="{{ $clientes->id }}" {{ $pedido->idcliente == $clientes->id ? 'selected' : '' }}>
                                    {{ $clientes->nombre }} {{ $clientes->apellido ?? '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="pt-2">
                        <button type="submit"
                            class="w-full bg-brand-600 hover:bg-brand-700 text-white font-semibold text-sm rounded-xl px-4 py-2.5 shadow-xs transition-colors">
                            Guardar cambios del pedido
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Columna derecha: Prendas del pedido --}}
        <div class="lg:col-span-7">
            <div class="bg-white rounded-2xl border border-brand-200/80 shadow-xs p-6">
                <div class="flex items-center justify-between mb-4 pb-3 border-b border-brand-100">
                    <h3 class="text-base font-bold text-brand-900">Prendas y Servicios del Pedido</h3>
                    <span class="text-xs font-bold text-brand-700 bg-brand-100 px-3 py-1 rounded-full">
                        Total: ${{ number_format($pedido->precio, 2) }}
                    </span>
                </div>

                <div class="overflow-x-auto mb-5">
                    <table class="min-w-full">
                        <thead class="bg-brand-50 border-b border-brand-200/60">
                            <tr class="text-left text-xs font-bold text-brand-900/70 uppercase tracking-wider">
                                <th class="px-4 py-2.5">Prenda</th>
                                <th class="px-4 py-2.5">Servicio</th>
                                <th class="px-4 py-2.5">Especificación</th>
                                <th class="px-4 py-2.5 text-right">Precio</th>
                                <th class="px-4 py-2.5 text-right">Quitar</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-brand-100 text-sm">
                            @forelse ($pedido->servicios as $servicio)
                                <tr class="hover:bg-brand-50/40">
                                    <td class="px-4 py-3 font-medium text-brand-900">
                                        {{ $servicio->precio_base->nombre_prenda ?? '—' }}
                                    </td>
                                    <td class="px-4 py-3 text-brand-900/75">
                                        {{ $servicio->tipo_servicio->nombre ?? ucfirst($servicio->tipo_servicio->servicio ?? '') }}
                                    </td>
                                    <td class="px-4 py-3 text-brand-900/70">
                                        {{ $servicio->descripcion ?: '—' }}
                                    </td>
                                    <td class="px-4 py-3 text-right font-semibold text-brand-900">
                                        ${{ number_format($servicio->precio, 2) }}
                                    </td>
                                    <td class="px-4 py-3">
                                        <form action="{{ route('servicios.destroy', $servicio->id) }}" method="POST"
                                            class="flex justify-end"
                                            onsubmit="return confirm('¿Quitar esta prenda del pedido?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-5 h-5 text-brand-900/40 hover:text-rose-600 transition-colors" title="Quitar">
                                                @include('layouts.partials.icons', ['icon' => 'trash'])
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-6 text-center text-brand-900/50 text-sm">
                                        Este pedido todavía no tiene prendas registradas.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                        <tfoot class="border-t border-brand-200 bg-brand-50/40">
                            <tr>
                                <td colspan="3" class="px-4 py-3 text-right font-bold text-brand-900 text-sm">Total calculado</td>
                                <td class="px-4 py-3 text-right font-extrabold text-brand-700 text-sm">${{ number_format($pedido->precio, 2) }}</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <form action="{{ route('servicios.store') }}" method="POST"
                    class="bg-brand-50/60 rounded-xl p-4 border border-brand-200/70 grid grid-cols-1 sm:grid-cols-2 gap-3 items-end">
                    @csrf
                    <input type="hidden" name="id_pedido" value="{{ $pedido->id }}">

                    <div>
                        <label class="block mb-1 text-xs font-semibold text-brand-900/80">Prenda base</label>
                        <select name="id_precio_bases" class="w-full bg-white border border-brand-200 rounded-xl px-3 py-2 text-sm text-brand-900">
                            @foreach ($precio_bases as $precio_base)
                                <option value="{{ $precio_base->id }}">
                                    {{ $precio_base->nombre_prenda }} (${{ number_format($precio_base->precio, 2) }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block mb-1 text-xs font-semibold text-brand-900/80">Tipo de servicio</label>
                        <select name="id_tipo_servicios" class="w-full bg-white border border-brand-200 rounded-xl px-3 py-2 text-sm text-brand-900">
                            @foreach ($tipo_servicios as $tipo)
                                <option value="{{ $tipo->id }}">
                                    {{ $tipo->nombre ?? ucfirst($tipo->servicio ?? '') }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="sm:col-span-2 flex flex-col sm:flex-row gap-3 items-end">
                        <div class="w-full flex-1">
                            <label class="block mb-1 text-xs font-semibold text-brand-900/80">Detalle de la prenda / arreglo</label>
                            <input type="text" name="descripcion" placeholder="Ej: Subir bota 3 cm, entallar cintura..."
                                class="w-full bg-white border border-brand-200 rounded-xl px-3 py-2 text-sm text-brand-900">
                        </div>

                        <button type="submit"
                            class="w-full sm:w-auto bg-brand-800 hover:bg-brand-900 text-white text-xs font-semibold rounded-xl px-4 py-2.5 transition-colors shrink-0">
                            + Agregar prenda
                        </button>
                    </div>
                </form>

            </div>
        </div>

    </div>

    {{-- Medidas del cliente en CM --}}
    <div class="bg-white rounded-2xl border border-brand-200/80 shadow-xs p-6">
        <div class="mb-4">
            <h3 class="text-base font-bold text-brand-900">Medidas del Cliente (en CM)</h3>
            <p class="text-xs sm:text-sm text-brand-900/65 mt-0.5">
                Medidas de <strong>{{ $pedido->cliente->nombre }} {{ $pedido->cliente->apellido ?? '' }}</strong>. Se guardan en su ficha y se reutilizan automáticamente en próximos pedidos.
            </p>
        </div>

        @php
            $grupos = [
                'camisa' => [
                    'titulo' => 'Medidas Superiores / Camisa',
                    'campos' => [
                        'ancho_espalda'  => 'Ancho espalda',
                        'largo_espalda'  => 'Largo espalda',
                        'contorno_pecho' => 'Contorno pecho',
                        'hombro'         => 'Hombro',
                        'manga'          => 'Manga',
                        'puño'           => 'Puño',
                        'antebrazo'      => 'Antebrazo',
                        'cintura_suelta' => 'Cintura suelta',
                    ],
                ],
                'pantalon' => [
                    'titulo' => 'Medidas Inferiores / Pantalón',
                    'campos' => [
                        'cintura'      => 'Cintura',
                        'tiro'         => 'Tiro',
                        'pierna'       => 'Pierna',
                        'rodilla'      => 'Rodilla',
                        'largo_pierna' => 'Largo pierna',
                        'bota'         => 'Bota',
                    ],
                ],
                'generales' => [
                    'titulo' => 'Medidas Generales',
                    'campos' => [
                        'largo_total' => 'Largo total',
                    ],
                ],
            ];
        @endphp

        <form action="{{ route('pedidos.medidas', $pedido->id) }}" method="POST" x-data="{ seccion: 'camisa' }">
            @csrf
            @method('PATCH')

            @foreach ($grupos as $clave => $grupo)
                <div class="border border-brand-200/80 rounded-xl mb-3 overflow-hidden">
                    <button type="button"
                        @click="seccion = (seccion === '{{ $clave }}') ? null : '{{ $clave }}'"
                        class="w-full flex justify-between items-center px-4 py-3 bg-brand-50/70 hover:bg-brand-100/50 font-semibold text-sm text-brand-900 transition-colors">
                        <span>{{ $grupo['titulo'] }}</span>
                        <span class="text-brand-600 font-bold text-base" x-text="seccion === '{{ $clave }}' ? '−' : '+'"></span>
                    </button>

                    <div x-show="seccion === '{{ $clave }}'" x-cloak class="p-4 grid grid-cols-2 sm:grid-cols-4 gap-4 bg-white">
                        @foreach ($grupo['campos'] as $campo => $etiqueta)
                            <div>
                                <label class="block text-xs font-semibold text-brand-900/75 mb-1">{{ $etiqueta }}</label>
                                <input type="number" step="0.01" name="{{ $campo }}"
                                    value="{{ old($campo, $pedido->cliente->$campo) }}"
                                    class="w-full rounded-xl bg-brand-50/40 border border-brand-200 px-3 py-2 text-sm text-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-500">
                                @error($campo) <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach

            <div class="flex justify-end pt-2">
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-brand-600 hover:bg-brand-700 text-white text-xs sm:text-sm font-semibold shadow-xs transition-colors">
                    Guardar medidas del cliente
                </button>
            </div>
        </form>
    </div>

    {{-- Historial de otros pedidos del cliente --}}
    <div class="bg-white rounded-2xl border border-brand-200/80 shadow-xs p-6">
        <h3 class="text-base font-bold text-brand-900 mb-4">Otros pedidos de este cliente</h3>

        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-brand-50 border-b border-brand-200/60">
                    <tr class="text-left text-xs font-bold text-brand-900/70 uppercase tracking-wider">
                        <th class="px-4 py-3">Fecha recepción</th>
                        <th class="px-4 py-3">Entrega</th>
                        <th class="px-4 py-3">Estado</th>
                        <th class="px-4 py-3 text-right">Total</th>
                        <th class="px-4 py-3 text-right">Abrir</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-brand-100 text-sm">
                    @forelse ($historial as $anterior)
                        <tr class="hover:bg-brand-50/50">
                            <td class="px-4 py-3 text-brand-900">{{ $anterior->fecha }}</td>
                            <td class="px-4 py-3 text-brand-900/75">{{ $anterior->fecha_entrega }}</td>
                            <td class="px-4 py-3 text-brand-900/75">{{ ucfirst(str_replace('_', ' ', $anterior->estado)) }}</td>
                            <td class="px-4 py-3 text-right font-semibold text-brand-900">${{ number_format($anterior->precio, 2) }}</td>
                            <td class="px-4 py-3">
                                <a href="{{ route('pedidos.edit', $anterior->id) }}"
                                    class="w-5 h-5 block ml-auto text-brand-900/50 hover:text-brand-600 transition-colors" title="Abrir pedido">
                                    @include('layouts.partials.icons', ['icon' => 'eye'])
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-6 text-center text-brand-900/50 text-sm">
                                Este cliente no tiene otros pedidos registrados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection
