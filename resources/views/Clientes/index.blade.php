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

        <div class="bg-white rounded-lg shadow overflow-hidden">
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

                <tbody class="divide-y divide-slate-100">
                    @forelse ($clientes as $cliente)
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-primary-100 text-primary-700 flex items-center justify-center text-sm font-semibold shrink-0">
                                        {{ strtoupper(substr($cliente->nombre, 0, 1) . substr($cliente->apellido, 0, 1)) }}
                                    </div>
                                    <span class="text-slate-700 font-medium">
                                        {{ $cliente->nombre }} {{ $cliente->apellido }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-slate-500">{{ $cliente->correo }}</td>
                            <td class="px-6 py-4 text-slate-500">{{ $cliente->telefono }}</td>
                            <td class="px-6 py-4 text-slate-500">{{ $cliente->fecha_registro }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="{{ route('clientes.show', $cliente->id) }}"
                                        class="w-5 h-5 text-slate-400 hover:text-primary-600" title="Ver detalles">
                                        @include('layouts.partials.icons', ['icon' => 'eye'])
                                    </a>

                                    <a href="{{ route('clientes.edit', $cliente->id) }}"
                                        class="w-5 h-5 text-slate-400 hover:text-primary-600" title="Editar">
                                        @include('layouts.partials.icons', ['icon' => 'pencil'])
                                    </a>

                                    <form action="{{ route('clientes.destroy', $cliente->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('¿Eliminar este cliente?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="w-5 h-5 text-slate-400 hover:text-red-600" title="Eliminar">
                                            @include('layouts.partials.icons', ['icon' => 'trash'])
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-slate-400">
                                No hay clientes registrados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</x-card>

@endsection