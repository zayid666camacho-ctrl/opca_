@extends('layouts.app')

@section('title')
    Clientes
@endsection

@section('content')

<x-card>
    <div class="container mx-auto mt-10">

        <div class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-bold text-gray-700">
                Clientes
            </h2>

            <a href="{{ route('clientes.create') }}"
            class="bg-primary-500 hover:bg-primary-600 text-white px-4 py-2 rounded">
                Nuevo cliente
            </a>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        


        <div x-data="{ termino: '' }" class="bg-white rounded-lg shadow overflow-hidden">

    <div class="p-4 border-b border-slate-100">
        <input
            type="text"
            x-model="termino"
            @input.debounce.300ms="
                fetch(`{{ route('clientes.buscar') }}?q=${encodeURIComponent(termino)}`)
                    .then(r => r.text())
                    .then(html => { $refs.tbody.innerHTML = html; })
            "
            placeholder="Buscar por nombre y apellido..."
            class="w-full sm:w-80 px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-400"
        >
    </div>

    <table class="min-w-full">
        <thead class="bg-slate-50">
            <tr class="text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">
                <th class="px-6 py-3">Cliente</th>
                <th class="px-6 py-3">Correo</th>
                <th class="px-6 py-3">Teléfono</th>
                <th class="px-6 py-3">Fecha de registro</th>
                <th class="px-6 py-3 text-right">Acciones</th>
            </tr>
        </thead>

        <tbody x-ref="tbody" class="divide-y divide-slate-100">
            @include('clientes._tabla', ['clientes' => $clientes])
        </tbody>
    </table>
</div>

    </div>
</x-card>

@endsection