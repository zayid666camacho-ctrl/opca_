@extends('layouts.module')

@section('title', 'Configuración')
@section('page-title', 'Configuración')

@section('content')

<x-card>
    <div class="container mx-auto mt-10">

        <h2 class="text-3xl font-bold text-gray-700 mb-6">
            Configuración
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">

            <a href="{{ route('precio_bases.index') }}"
                class="block bg-white rounded-lg shadow p-5 border border-slate-100 hover:shadow-md">
                <div class="w-10 h-10 text-primary-600 mb-3">
                    @include('layouts.partials.icons', ['icon' => 'tag'])
                </div>
                <h3 class="font-semibold text-slate-700">Precios base</h3>
                <p class="text-sm text-slate-500 mt-1">
                    Prendas y tarifas que se usan al cotizar los pedidos.
                </p>
            </a>

        </div>

    </div>
</x-card>

@endsection