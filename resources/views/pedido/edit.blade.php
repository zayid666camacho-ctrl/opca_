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

</div>
</x-card>


@endsection