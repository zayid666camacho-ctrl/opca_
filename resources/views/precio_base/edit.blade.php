@extends('layouts.app')

@section('title')
    TITULO
@endsection

@section('content')

<x-card>
<div class="container mx-auto mt-10">

    <div class="max-w-xl mx-auto bg-white shadow-lg rounded-lg p-8">

        <h2 class="text-3xl font-bold text-center mb-6">
            Editar precio
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

        <form action="{{ route('precio_bases.update', $precio_base->id) }}" method="post">

            @csrf
            @method('PUT')

            <div class="mb-5">
                <label for="" class="block mb-2 font-semibold">Nombre de la prenda</label>
                <input type="text" name="nombre_prenda" value="{{ $precio_base->nombre_prenda }}" class="w-full border rounded px-3 py-2">
            </div>

            <div class="mb-5">
                <label for="" class="block mb-2 font-semibold">Complejidad</label>
                <select name="complejidad" id="complejidad" class="w-full border rounded px-3 py-4">
                    <option value="Baja" {{ $precio_base->complejidad == 'baja' ? 'selected' : '' }}>Baja</option>
                    <option value="Media" {{ $precio_base->complejidad == 'media' ? 'selected' : '' }}>Media</option>
                    <option value="Alta" {{ $precio_base->complejidad == 'alta' ? 'selected' : '' }}>Alta</option>
                </select>
            </div>

            <div class="mb-5">
                <label for="" class="block mb-2 font-semibold">Precio</label>
                <input type="number" name="precio" value="{{ $precio_base->precio }}" class="w-full border rounded px-3 py-2">
            </div>

            <div class="mb-5">
                <label for="" class="block mb-2 font-semibold">Descripcion</label>
                <input type="text" name="descripcion" value="{{ $precio_base->descripcion }}" class="w-full border rounded px-3 py-2">
            </div>

            <div class="mb-5">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white rounded px-4 py-2">
                    Actualizar
                </button>
            </div>

        </form>

    </div>
</div>
</x-card>

@endsection