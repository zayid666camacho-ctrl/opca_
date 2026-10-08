@extends('layouts.app')

@section('title')
    Nuevo servicio
@endsection

@section('content')

<x-card>
<div class="container mx-auto mt-10">

    <div class="max-w-xl mx-auto bg-white shadow-lg rounded-lg p-8">

        <h2 class="text-3xl font-bold text-center mb-6">
            Nuevo servicio
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

        <form action="{{ route('servicios.store') }}" method="post">
            @csrf

            <div class="mb-5">
                <label for="" class="block mb-2 font-semibold">Descripcion</label>
                <input type="text" name="descripcion" class="w-full border rounded px-3 py-2">
            </div>

            <div class="mb-5">
                <label for="" class="block mb-2 font-semibold">Precio</label>
                <input type="number" name="precio" class="w-full border rounded px-3 py-2">
            </div>

            <div class="mb-5">
                <label for="" class="block mb-2 font-semibold">Descripcion Pedido</label>
                <select name="id_pedido" id="id_pedido">
                    @foreach ($pedido as $pedido)
                        <option value="{{$pedido->id}}"> {{$pedido->descripcion}} </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-5">
                <label for="" class="block mb-2 font-semibold">Nombre_prenda</label>
                <select name="id_precio_bases" id="id_precio_bases">
                    @foreach ($precio_bases as $precio_base)
                        <option value="{{$precio_base->id}}"> {{$precio_base->nombre_prenda}} </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-5">
                <label for="" class="block mb-2 font-semibold">Servicio</label>
                <select name="id_tipo_servicios" id="id_tipo_servicios">
                    @foreach ($tipo_servicios as $tipo_servicios)
                        <option value="{{$tipo_servicios->id}}"> {{$tipo_servicios->servicio}} </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-5">
                <button type="submit" class="bg-primary-500 hover:bg-primary-600 text-white rounded px-4 py-2">
                    guardar
                </button>
            </div>

        </form>

    </div>
</div>
</x-card>

@endsection