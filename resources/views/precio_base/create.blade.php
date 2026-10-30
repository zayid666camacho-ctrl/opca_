@extends('layouts.module')

@section('title', 'Nuevo Precio Base')
@section('page-title', 'Registrar Nuevo Precio Base')

@section('content')

<div class="max-w-xl mx-auto">

    <div class="bg-white rounded-2xl border border-brand-200/80 shadow-xs p-6 sm:p-8">

        <div class="flex items-center justify-between mb-6 pb-4 border-b border-brand-100">
            <h2 class="text-xl font-bold text-brand-900">
                Nuevo Precio Base
            </h2>
            <a href="{{ route('precio_bases.index') }}"
               class="text-xs font-semibold text-brand-900/65 hover:text-brand-900">
                ← Volver
            </a>
        </div>

        @if($errors->any())
            <div class="bg-rose-50 border border-rose-300 text-rose-800 px-4 py-3 rounded-xl text-sm mb-5">
                <ul class="list-disc list-inside space-y-0.5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('precio_bases.store') }}" method="post" class="space-y-4">
            @csrf

            <div>
                <label class="block mb-1.5 text-xs font-semibold text-brand-900/80">Nombre de la prenda *</label>
                <input type="text" name="nombre_prenda" placeholder="Ej: Pantalón, Vestido de fiesta, Camisa..."
                    class="w-full bg-brand-50/50 border border-brand-200 rounded-xl px-3.5 py-2.5 text-sm text-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-500">
            </div>

            <div>
                <label class="block mb-1.5 text-xs font-semibold text-brand-900/80">Complejidad *</label>
                <select name="complejidad" id="complejidad"
                    class="w-full bg-brand-50/50 border border-brand-200 rounded-xl px-3.5 py-2.5 text-sm text-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-500">
                    <option value="Baja">Baja</option>
                    <option value="Media">Media</option>
                    <option value="Alta">Alta</option>
                </select>
            </div>

            <div>
                <label class="block mb-1.5 text-xs font-semibold text-brand-900/80">Precio de referencia ($) *</label>
                <input type="number" step="0.01" name="precio" placeholder="0.00"
                    class="w-full bg-brand-50/50 border border-brand-200 rounded-xl px-3.5 py-2.5 text-sm text-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-500">
            </div>

            <div>
                <label class="block mb-1.5 text-xs font-semibold text-brand-900/80">Descripción</label>
                <input type="text" name="descripcion" placeholder="Detalles de lo que incluye la tarifa..."
                    class="w-full bg-brand-50/50 border border-brand-200 rounded-xl px-3.5 py-2.5 text-sm text-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-500">
            </div>

            <div class="flex justify-end gap-3 pt-3">
                <a href="{{ route('precio_bases.index') }}"
                   class="px-4 py-2.5 rounded-xl bg-brand-50 border border-brand-200 text-sm font-medium text-brand-900 hover:bg-brand-100 transition-colors">
                    Cancelar
                </a>
                <button type="submit" class="bg-brand-600 hover:bg-brand-700 text-white text-sm font-semibold rounded-xl px-5 py-2.5 shadow-xs transition-colors">
                    Guardar precio base
                </button>
            </div>

        </form>

    </div>
</div>

@endsection
