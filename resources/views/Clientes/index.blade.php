@extends('layouts.module')

@section('title', 'Directorio de Clientes')
@section('page-title', 'Directorio de Clientes')

@section('content')

<div class="max-w-7xl mx-auto space-y-6">

    <div class="bg-white rounded-2xl border border-brand-200/80 shadow-xs p-5 flex flex-wrap justify-between items-center gap-4">
        <div>
            <h2 class="text-xl font-bold text-brand-900">
                Directorio de Clientes
            </h2>
            <p class="text-xs sm:text-sm text-brand-900/65 mt-0.5">
                Administra los datos de contacto, medidas corporales en CM y notas de cada cliente.
            </p>
        </div>

        <a href="{{ route('clientes.create') }}"
           class="bg-brand-600 hover:bg-brand-700 text-white text-xs sm:text-sm font-semibold px-4 py-2.5 rounded-xl shadow-xs transition-colors">
            + Nuevo cliente
        </a>
    </div>

    @if (session('success'))
        <div class="bg-emerald-50 border border-emerald-300 text-emerald-800 px-4 py-3 rounded-xl text-sm shadow-xs">
            {{ session('success') }}
        </div>
    @endif

    <div x-data="{ termino: '' }" class="bg-white rounded-2xl border border-brand-200/80 shadow-xs overflow-hidden">

        <div class="p-4 sm:p-5 bg-brand-50/50 border-b border-brand-100">
            <label class="block text-xs font-semibold text-brand-900/70 mb-1">Buscar cliente</label>
            <input
                type="text"
                x-model="termino"
                @input.debounce.300ms="
                    fetch(`{{ route('clientes.buscar') }}?q=${encodeURIComponent(termino)}`)
                        .then(r => r.text())
                        .then(html => { $refs.tbody.innerHTML = html; })
                "
                placeholder="Buscar por nombre y apellido..."
                class="w-full sm:w-96 px-4 py-2 bg-white border border-brand-200 rounded-xl text-sm text-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-500"
            >
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-brand-100/50 border-b border-brand-200/70">
                    <tr class="text-left text-xs font-bold text-brand-900/75 uppercase tracking-wider">
                        <th class="px-6 py-3.5">Cliente</th>
                        <th class="px-6 py-3.5">Correo</th>
                        <th class="px-6 py-3.5">Teléfono</th>
                        <th class="px-6 py-3.5">Fecha de registro</th>
                        <th class="px-6 py-3.5 text-right">Acciones</th>
                    </tr>
                </thead>

                <tbody x-ref="tbody" class="divide-y divide-brand-100">
                    @include('clientes._tabla', ['clientes' => $clientes])
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection
