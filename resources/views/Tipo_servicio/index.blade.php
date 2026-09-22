@extends('layouts.app')

@section('title')
    Tipo de servicio
@endsection

@section('content')

<x-card>
<div class="container mx-auto mt-10">

        <div class="bg-white shadow-lg rounded-lg p-6">

            <div class="flex justify-between items-center mb-6">
                <h2 class="text-3xl font-bold text-gray-700">
                    TIPO DE SERVICIO
                </h2>

                <a href="{{ route('tipo_servicio.create') }}"
                class="bg-primary-500 hover:bg-primary-600 text-white px-4 py-2 rounded">
                    NUEVO TIPO DE SERVICIO
                </a>
            </div>

            <table class="min-w-full border border-gray-200">

                <thead class="bg-slate-50">
                    <tr>
                        <th class="border px-4 py-2">ID</th>
                        <th class="border px-4 py-2">Servicio</th>
                        <th class="border px-4 py-2">Descripcion</th>
                        <th class="border px-4 py-2">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                @foreach ($tiposervicio as $tipo)
                    <tr class="text-center hover:bg-gray-50">
                        <td class="border px-4 py-2">{{ $tipo->id }}</td>
                        <td class="border px-4 py-2">{{ ucfirst($tipo->servicio) }}</td>
                        <td class="border px-4 py-2">{{ $tipo->descripcion }}</td>
                        <td class="border px-4 py-2">
                            <a href="{{ route('tipo_servicio.edit', $tipo->id) }}" class="inline-block bg-primary-500 hover:bg-primary-600 text-white shadow rounded-lg px-3 py-1.5">Editar</a>

                            <form action="{{ route('tipo_servicio.destroy', $tipo->id) }}" method="post" class="inline-block mt-2">
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
