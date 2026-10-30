@extends('layouts.module')

@section('title', 'Catálogo de Precios Base')
@section('page-title', 'Catálogo de Precios Base por Prenda')

@section('content')

<div class="max-w-6xl mx-auto space-y-6">

    <div class="bg-white rounded-2xl border border-brand-200/80 shadow-xs p-5 flex flex-wrap justify-between items-center gap-4">
        <div>
            <h2 class="text-xl font-bold text-brand-900">
                Catálogo de Precios Base
            </h2>
            <p class="text-xs sm:text-sm text-brand-900/65 mt-0.5">
                Define las prendas y tarifas de referencia según su complejidad (se reflejan en el cotizador y en la web pública).
            </p>
        </div>

        <a href="{{ route('precio_bases.create') }}"
           class="bg-brand-600 hover:bg-brand-700 text-white text-xs sm:text-sm font-semibold px-4 py-2.5 rounded-xl shadow-xs transition-colors">
            + Nuevo precio base
        </a>
    </div>

    @if (session('store'))
        <div class="bg-emerald-50 border border-emerald-300 text-emerald-800 px-4 py-3 rounded-xl text-sm shadow-xs">
            {{ session('store') }}
        </div>
    @endif

    @if (session('edit'))
        <div class="bg-amber-50 border border-amber-300 text-amber-800 px-4 py-3 rounded-xl text-sm shadow-xs">
            {{ session('edit') }}
        </div>
    @endif

    @if (session('delete'))
        <div class="bg-rose-50 border border-rose-300 text-rose-800 px-4 py-3 rounded-xl text-sm shadow-xs">
            {{ session('delete') }}
        </div>
    @endif

    @php
        $colores_complejidad = [
            'Baja'  => 'bg-emerald-100 text-emerald-800 border-emerald-200',
            'Media' => 'bg-amber-100 text-amber-800 border-amber-200',
            'Alta'  => 'bg-brand-100 text-brand-700 border-brand-200',
        ];
    @endphp

    <div class="bg-white rounded-2xl border border-brand-200/80 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-brand-100/50 border-b border-brand-200/70">
                    <tr class="text-left text-xs font-bold text-brand-900/75 uppercase tracking-wider">
                        <th class="px-6 py-3.5">ID</th>
                        <th class="px-6 py-3.5">Nombre de la prenda</th>
                        <th class="px-6 py-3.5">Complejidad</th>
                        <th class="px-6 py-3.5 text-right">Precio Base</th>
                        <th class="px-6 py-3.5">Descripción</th>
                        <th class="px-6 py-3.5 text-right">Acciones</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-brand-100">
                @forelse ($precio_bases as $precio_base)
                    @php
                        $badge = $colores_complejidad[$precio_base->complejidad] ?? 'bg-slate-100 text-slate-700 border-slate-200';
                    @endphp
                    <tr class="hover:bg-brand-50/60 transition-colors">
                        <td class="px-6 py-4 text-xs font-semibold text-brand-900/50">#{{ $precio_base->id }}</td>
                        <td class="px-6 py-4 font-bold text-brand-900">{{ $precio_base->nombre_prenda }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold border {{ $badge }}">
                                {{ $precio_base->complejidad }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right font-bold text-brand-900">${{ number_format($precio_base->precio, 2) }}</td>
                        <td class="px-6 py-4 text-brand-900/70">{{ $precio_base->descripcion ?: '—' }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-3">
                                <a href="{{ route('precio_bases.edit', $precio_base->id) }}"
                                   class="text-xs font-semibold text-brand-600 hover:text-brand-700 transition-colors">
                                    Editar
                                </a>

                                <form action="{{ route('precio_bases.destroy', $precio_base->id) }}" method="post"
                                      class="inline-block"
                                      onsubmit="return confirm('¿Eliminar este precio base?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-xs font-semibold text-rose-600 hover:text-rose-800 transition-colors">
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-brand-900/50">
                            No hay precios base registrados.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection
