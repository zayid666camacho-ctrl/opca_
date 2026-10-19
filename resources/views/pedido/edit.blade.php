@extends('layouts.module')


@section('title', 'Editar pedido')       
@section('page-title', 'Editar pedido')


@section('content')


<x-card>
<div class="container mx-auto mt-10">

    <div class="max-w-xl mx-auto bg-white shadow-lg rounded-lg p-8">

        <h2 class="text-3xl font-bold text-center mb-6">

            Editar pedido

        </h2>

        @if($errors->any())

            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-5">

                <ul>

                    @foreach($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif

        <form action="{{ route('pedidos.update', $pedido->id) }}" method="post">

            @csrf
            @method('PUT')

            <div class="mb-5">
                <label for="" class="block mb-2 font-semibold">Fecha</label>
                <input type="date" name="fecha" value="{{ $pedido->fecha }}" class="w-full border rounded px-3 py-2">

            </div>

            <div class="mb-5">
                <label for="" class="block mb-2 font-semibold">Fecha de entrega</label>
                <input type="date" name="fecha_entrega" value="{{ $pedido->fecha_entrega }}" class="w-full border rounded px-3 py-2">

            </div>

            <div class="mb-5">
                <label for="" class="block mb-2 font-semibold">Estado</label>
                <select name="estado" id="estado" class="w-full border rounded px-3 py-4">
                    <option value="recibido" {{ $pedido->estado == 'recibido' ? 'selected' : '' }}>Recivido</option>
                    <option value="en_proceso" {{ $pedido->estado == 'en_proceso' ? 'selected' : '' }}>En proceso</option>
                    <option value="terminado" {{ $pedido->estado == 'terminado' ? 'selected' : '' }}>Terminado</option>
                    <option value="entregado" {{ $pedido->estado == 'entregado' ? 'selected' : '' }}>Entregado</option>
                    <option value="cancelado" {{ $pedido->estado == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                </select>
    

            </div>

            <div class="mb-5">
                <label for="" class="block mb-2 font-semibold">Descripcion</label>
                <input type="text" name="descripcion" value="{{ $pedido->descripcion }}" class="w-full border rounded px-3 py-2">

            </div>

            <div class="mb-5">
                <label for="" class="block mb-2 font-semibold">Cliente</label>
                <select name="idcliente" id="idcliente">
                    @foreach ($cliente as $clientes)
                        <option value="{{$clientes->id}}" {{ $pedido->idcliente == $clientes->id ? 'selected' : '' }}> {{$clientes->nombre}} </option>
                    @endforeach

                </select>

            </div>




            <div class="mb-5">
                <button type="submit" class="bg-green-600 hover:bg-green-600 text-white rounded px-4 py-2">
                    guardar
                </button>
            </div>

        </form>

                

    </div>

    <div class="max-w-3xl mx-auto bg-white shadow-lg rounded-lg p-8 mt-6">

        <h3 class="text-2xl font-bold text-gray-700 mb-4">Prendas del pedido</h3>

        <table class="min-w-full mb-4">
            <thead class="bg-slate-50">
                <tr class="text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">
                    <th class="px-4 py-3">Prenda</th>
                    <th class="px-4 py-3">Tipo</th>
                    <th class="px-4 py-3">Descripción</th>
                    <th class="px-4 py-3 text-right">Precio</th>
                    <th class="px-4 py-3 text-right">Quitar</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-100">
                @forelse ($pedido->servicios as $servicio)
                    <tr>
                        <td class="px-4 py-3 text-slate-700">{{ $servicio->precio_base->nombre_prenda }}</td>
                        <td class="px-4 py-3 text-slate-500">{{ $servicio->tipo_servicio->nombre }}</td>
                        <td class="px-4 py-3 text-slate-500">{{ $servicio->descripcion }}</td>
                        <td class="px-4 py-3 text-right text-slate-700">${{ number_format($servicio->precio, 2) }}</td>
                        <td class="px-4 py-3">
                            <form action="{{ route('servicios.destroy', $servicio->id) }}" method="POST"
                                class="flex justify-end"
                                onsubmit="return confirm('¿Quitar esta prenda del pedido?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-5 h-5 text-slate-400 hover:text-red-600" title="Quitar">
                                    @include('layouts.partials.icons', ['icon' => 'trash'])
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-6 text-center text-slate-400">
                            Este pedido todavía no tiene prendas.
                        </td>
                    </tr>
                @endforelse
            </tbody>

            <tfoot>
                <tr>
                    <td colspan="3" class="px-4 py-3 text-right font-semibold text-slate-700">Total</td>
                    <td class="px-4 py-3 text-right font-semibold text-slate-700">${{ number_format($pedido->precio, 2) }}</td>
                    <td></td>
                </tr>
            </tfoot>
        </table>

        <form action="{{ route('servicios.store') }}" method="POST"
            class="grid grid-cols-1 md:grid-cols-4 gap-3 items-end border-t border-slate-100 pt-4">
            @csrf
            <input type="hidden" name="id_pedido" value="{{ $pedido->id }}">

            <div>
                <label class="block mb-1 text-sm font-semibold">Prenda</label>
                <select name="id_precio_bases" class="w-full border rounded px-3 py-2">
                    @foreach ($precio_bases as $precio_base)
                        <option value="{{ $precio_base->id }}">
                            {{ $precio_base->nombre_prenda }} (${{ number_format($precio_base->precio, 2) }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block mb-1 text-sm font-semibold">Tipo</label>
                <select name="id_tipo_servicios" class="w-full border rounded px-3 py-2">
                    @foreach ($tipo_servicios as $tipo)
                        <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block mb-1 text-sm font-semibold">Descripción</label>
                <input type="text" name="descripcion" class="w-full border rounded px-3 py-2">
            </div>

            <button type="submit" class="bg-primary-500 hover:bg-primary-600 text-white rounded px-4 py-2">
                Agregar prenda
            </button>
        </form>

    </div>

        <div class="max-w-3xl mx-auto bg-white shadow-lg rounded-lg p-8 mt-6">

        <h3 class="text-2xl font-bold text-gray-700">Medidas del cliente en CM</h3>
        <p class="text-sm text-slate-500 mb-4">
            {{ $pedido->cliente->nombre }} {{ $pedido->cliente->apellido }}.
            Se guardan en el perfil del cliente y se reutilizan en sus próximos pedidos.
        </p>

        @php
            $grupos = [
                'camisa' => [
                    'titulo' => 'Medidas Camisa',
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
                    'titulo' => 'Medidas Pantalón',
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
                <div class="border border-slate-200 rounded-lg mb-3">
                    <button type="button"
                        @click="seccion = (seccion === '{{ $clave }}') ? null : '{{ $clave }}'"
                        class="w-full flex justify-between items-center px-4 py-3 font-semibold text-slate-700">
                        {{ $grupo['titulo'] }}
                        <span x-text="seccion === '{{ $clave }}' ? '−' : '+'"></span>
                    </button>

                    <div x-show="seccion === '{{ $clave }}'" x-cloak class="px-4 pb-4 grid grid-cols-2 gap-4">
                        @foreach ($grupo['campos'] as $campo => $etiqueta)
                            <div>
                                <label class="block text-sm font-medium text-slate-600">{{ $etiqueta }}</label>
                                <input type="number" step="0.01" name="{{ $campo }}"
                                    value="{{ old($campo, $pedido->cliente->$campo) }}"
                                    class="mt-1 w-full rounded border-slate-300 focus:ring-primary-500 focus:border-primary-500">
                                @error($campo) <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach

            <div class="flex justify-end">
                <button type="submit" class="px-4 py-2 rounded bg-primary-600 text-white hover:bg-primary-700">
                    Guardar medidas
                </button>
            </div>
        </form>

    </div>

        <div class="max-w-3xl mx-auto bg-white shadow-lg rounded-lg p-8 mt-6">

        <h3 class="text-2xl font-bold text-gray-700 mb-4">Otros pedidos de este cliente</h3>

        <table class="min-w-full">
            <thead class="bg-slate-50">
                <tr class="text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">
                    <th class="px-4 py-3">Fecha</th>
                    <th class="px-4 py-3">Entrega</th>
                    <th class="px-4 py-3">Estado</th>
                    <th class="px-4 py-3 text-right">Total</th>
                    <th class="px-4 py-3 text-right">Abrir</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-100">
                @forelse ($historial as $anterior)
                    <tr>
                        <td class="px-4 py-3 text-slate-700">{{ $anterior->fecha }}</td>
                        <td class="px-4 py-3 text-slate-500">{{ $anterior->fecha_entrega }}</td>
                        <td class="px-4 py-3 text-slate-500">{{ ucfirst(str_replace('_', ' ', $anterior->estado)) }}</td>
                        <td class="px-4 py-3 text-right text-slate-700">${{ number_format($anterior->precio, 2) }}</td>
                        <td class="px-4 py-3">
                            <a href="{{ route('pedidos.edit', $anterior->id) }}"
                                class="w-5 h-5 block ml-auto text-slate-400 hover:text-primary-600" title="Abrir pedido">
                                @include('layouts.partials.icons', ['icon' => 'eye'])
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-6 text-center text-slate-400">
                            Este cliente no tiene otros pedidos.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>

</div>
</x-card>


@endsection