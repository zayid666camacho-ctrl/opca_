@extends('layouts.app')


@section('title')
    TITULO
@endsection


@section('content')


<x-card>
@extends('layouts.app')


@section('title')
    TITULO
@endsection


@section('content')


<x-card>
<div class="container mx-auto mt-10">

    <div class="max-w-xl mx-auto bg-white shadow-lg rounded-lg p-8">

        <h2 class="text-3xl font-bold text-center mb-6">

            Nuevo pedido

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

        <form action="{{ route('pedidos.update', $pedidos->id) }}" method="post">

            @csrf
            @method('PUT')

            <div class="mb-5">
                <label for="" class="block mb-2 font-semibold">Fecha</label>
                <input type="date" name="fecha" value="{{ $pedidos->fecha }}" class="w-full border rounded px-3 py-2">

            </div>

            <div class="mb-5">
                <label for="" class="block mb-2 font-semibold">Fecha de entrega</label>
                <input type="date" name="fecha_entrega" value="{{ $pedidos->fecha_entrega }}" class="w-full border rounded px-3 py-2">

            </div>

            <div class="mb-5">
                <label for="" class="block mb-2 font-semibold">Estado</label>
                <select name="estado" id="estado" class="w-full border rounded px-3 py-4">
                    <option value="recibido">Recivido</option>
                    <option value="en_proceso">En proceso</option>
                    <option value="terminado">Terminado</option>
                    <option value="entregado">Entregado</option>
                    <option value="cancelado">Cancelado</option>
                </select>
    

            </div>

            <div class="mb-5">
                <label for="" class="block mb-2 font-semibold">Descripcion</label>
                <input type="text" name="descripcion" value="{{ $pedidos->descripcion }}" class="w-full border rounded px-3 py-2">

            </div>

            <div class="mb-5">
                <label for="" class="block mb-2 font-semibold">Precio</label>
                <input type="number" name="precio" value="{{ $pedidos->precio }}" class="w-full border rounded px-3 py-2">
            </div>

            <div class="mb-5">
                <label for="" class="block mb-2 font-semibold">Saldo pendiente</label>
                <input type="number" name="saldo_pendiente" value="{{ $pedidos->saldo_pendiente }}" class="w-full border rounded px-3 py-2">
            </div>

            <div class="mb-5">
                <label for="" class="block mb-2 font-semibold">Cliente</label>
                <select name="idcliente" id="idcliente">
                    @foreach ($cliente as $clientes)
                        <option value="{{$clientes->id}}"> {{$clientes->nombre}} </option>
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
</x-card>

@endsection