@extends('layouts.app')

@section('title')
    Editar tipo de servicio
@endsection

@section('content')

<x-card>
<div class="container mx-auto mt-10">

    <div class="max-w-xl mx-auto bg-white shadow-lg rounded-lg p-8">

        <h2 class="text-3xl font-bold text-center mb-6">
            Editar tipo de servicio
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

        <form action="{{ route('tipo_servicio.update', $tipo_servicio->id) }}" method="post">
            @csrf
            @method('PUT')

            <div class="mb-5">
                <label for="" class="block mb-2 font-semibold">Servicio</label>
                <select name="servicio" id="servicio" class="w-full border rounded px-3 py-2">
                    <option value="arreglo" {{ $tipo_servicio->servicio == 'arreglo' ? 'selected' : '' }}>Arreglo</option>
                    <option value="confeccion" {{ $tipo_servicio->servicio == 'confeccion' ? 'selected' : '' }}>Confección</option>
                </select>
            </div>

            <div class="mb-5">
                <label for="" class="block mb-2 font-semibold">Descripcion</label>
                <input type="text" name="descripcion" value="{{ $tipo_servicio->descripcion }}" class="w-full border rounded px-3 py-2">
            </div>

            <div class="mb-5">
                <button type="submit" class="bg-primary-500 hover:bg-primary-600 text-white rounded px-4 py-2">
                    Actualizar
                </button>
            </div>

        </form>

    </div>
</div>
</x-card>

@endsection