@extends('layouts.module')

@section('title', Servicios')
@section('page-title', 'Creaciones NayJa: Servicios')

@section('content')

<x-card>
<div class="container mx-auto mt-10">

        <div class="bg-white shadow-lg rounded-lg p-6">

            <div class="flex justify-between items-center mb-6">

                <h2 class="text-3xl font-bold text-gray-700">
                    PRECIOS BASE
                </h2>

                <a href="{{ route('servicios.create') }}"
                class="bg-primary-500 hover:bg-primary-600 text-white px-4 py-2 rounded">
                    NUEVO SERVICIO
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

                <thead class="bg-slate-50">
                    <tr>
                        <th class="border px-4 py-2">ID</th>
                        <th class="border px-4 py-2">Descripcion</th>
                        <th class="border px-4 py-2">Precio</th>
                        <th class="border px-4 py-2">id_pedido</th>
                        <th class="border px-4 py-2">id_precio base</th>
                        <th class="border px-4 py-2">id_tipo servicio</th>
                        <th class="border px-4 py-2">acciones</th>
                    </tr>
                </thead>

                <tbody>
                @foreach ($servicio as $servicio)
                    <tr class="text-center hover:bg-gray-50">
                        <td class="border px-4 py-2">{{ $servicio->id }}</td>
                        <td class="border px-4 py-2">{{ $servicio->descripcion }}</td>
                        <td class="border px-4 py-2">{{ $servicio->precio }}</td>
                        <td class="border px-4 py-2">{{ $servicio->pedido->descripcion }}</td>
                        <td class="border px-4 py-2">{{ $servicio->precio_base->nombre_prenda }}</td>
                        <td class="border px-4 py-2">{{ $servicio->tipo_servicio->servicio }}</td>
                        <td class="border px-4 py-2">
                            <a href="{{ route('servicios.index', $servicio->id) }}" class="inline-block bg-primary-500 hover:bg-primary-600 text-white shadow rounded-lg px-3 py-1.5">Editar</a>

                            <form action="{{ route('servicios.destroy', $servicio->id) }}" method="post" class="inline-block mt-2">
                                @csrf
                                @method('DELETE')
                                <button class="bg-red-500 hover:bg-red-600 text-white shadow rounded-lg px-3 py-1.5">eliminar</button>
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