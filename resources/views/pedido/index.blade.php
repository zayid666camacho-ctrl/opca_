@extends('layouts.app')


@section('title')
    TITULO
@endsection


@section('content')


<x-card>
<div class="container mx-auto mt-10">

        <div class="bg-white shadow-lg rounded-lg p-6">

            <div class="flex justify-between items-center mb-6">

                <h2 class="text-3xl font-bold text-gray-700">
                    PEDIDOS
                </h2>

                <a href="{{ route('pedidos.create') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">

                    NUEVO PEDIDO
                <br>
                </a>

            </div>


            @if (session('store'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('store') }}
                </div>
            @endif

            @if (session('edit'))
                <div class="bg-yellow-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('edit') }}
                </div>
            @endif

            @if (session('delete'))
                <div class="bg-red-100 border border-red-400 text-red-500 px-4 py-3 rounded mb-4">
                    {{ session('delete') }}
                </div>
            @endif



            <table class="min-w-full border border-gray-200">

                <thead class="bg-gray-200">

                    <tr>

                        <th class="border px-4 py-2">
                            ID
                        </th>

                        <th class="border px-4 py-2">
                            Fecha
                        </th>

                        <th class="border px-4 py-2">
                            Fecha de entrega
                        </th>

                        <th class="border px-4 py-2">
                            Estado
                        </th>

                        <th class="border px-4 py-2">
                            Descripcion
                        </th>

                        <th class="border px-4 py-2">
                            Precio
                        </th>

                        <th class="border px-4 py-2">
                            Saldo pendiente
                        </th>

                        <th class="border px-4 py-2">
                            ID_Cliente
                        </th>



                    </tr>

                </thead>

                <tbody>

                @foreach ($pedido as $pedidos)

                    <tr class="text-center hover:bg-gray-50">
                        <td class="border px-4 py-2">{{ $pedidos->id}}</td>
                        <td class="border px-4 py-2">{{ $pedidos->fecha}}</td>
                        <td class="border px-4 py-2">{{ $pedidos->fecha_entrega}}</td>
                        <td class="border px-4 py-2">{{ $pedidos->estado}}</td>
                        <td class="border px-4 py-2">{{ $pedidos->descripcion}}</td>
                        <td class="border px-4 py-2">{{ $pedidos->precio}}</td>
                        <td class="border px-4 py-2">{{ $pedidos->saldo_pendiente}}</td>
                        <td class="border px-4 py-2">{{ $pedidos->clientes->nombre}}</td>
                        <td class="border px-4 py-2">


                        <br>
                            <a href="{{ route('pedidos.edit', $pedido->id)}}" class="max-w-xl mx-auto bg-purple-400 shadow-lg rounded-lg p-3 my-4">Editar</a>

                            <form action="{{ route('pedidos.destroy', $pedido->id)}}" method="post">
                                @csrf
                                @method('DELETE')

                                <br>
                                <button class="max-w-xl mx-auto bg-red-400 shadow-lg rounded-lg p-3">eliminar</button>
                                
                            </form>

                        </td>
                    </tr>

                @endforeach

                


                </tbody>

            </table>

        </div>

    </div>

</x-card>

@endsection