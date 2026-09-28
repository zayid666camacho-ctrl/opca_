@extends('layouts.app')


@section('title')
    TITULO
@endsection


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
</x-card>

@endsection