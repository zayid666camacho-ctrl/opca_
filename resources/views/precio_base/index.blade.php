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
                    PRECIOS BASE
                </h2>

                <a href="{{ route('precio_bases.create') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">

                    NUEVO PRECIO BASE
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
                            Nombre de la prenda
                        </th>

                        <th class="border px-4 py-2">
                            Complejidad
                        </th>

                        <th class="border px-4 py-2">
                            Precio 
                        </th>

                        <th class="border px-4 py-2">
                            Tiempo de echura
                        </th>

                        <th class="border px-4 py-2">
                            Descripcion
                        </th>

                    </tr>

                </thead>

                <tbody>

                @foreach ($precio_bases as $precio_base)

                    <tr class="text-center hover:bg-gray-50">
                        <td class="border px-4 py-2">{{ $precio_base->id}}</td>
                        <td class="border px-4 py-2">{{ $precio_base->nombre_prenda}}</td>
                        <td class="border px-4 py-2">{{ $precio_base->complejidad}}</td>
                        <td class="border px-4 py-2">{{ $precio_base->precio}}</td>
                        <td class="border px-4 py-2">{{ $precio_base->descripcion}}</td>
                        
                        <td class="border px-4 py-2">


                        <br>
                            <a href="{{ route('precio_bases.edit', $precio_base->id)}}" class="max-w-xl mx-auto bg-purple-400 shadow-lg rounded-lg p-3 my-4">Editar</a>

                            <form action="{{ route('precio_bases.destroy', $precio_base->id)}}" method="post">
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