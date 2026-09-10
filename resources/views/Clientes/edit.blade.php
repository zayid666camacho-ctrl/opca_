@extends('layouts.app')


@section('title')
    TITULO
@endsection


@section('content')


<x-card>
<div class="max-w-3xl mx-auto">
    <h1 class="text-2xl font-bold text-slate-800 mb-6">EDITAR CLIENTE</h1>

    <form action="{{ route('clientes.update', $cliente->id) }}" method="POST" x-data="{ seccion: 'datos' }">
        @csrf
        @method('PUT')

        {{-- ===== Datos generales ===== --}}
        <div class="bg-white rounded-lg shadow mb-4">
            <button type="button"
                @click="seccion = (seccion === 'datos') ? null : 'datos'"
                class="w-full flex justify-between items-center px-4 py-3 font-semibold text-slate-700">
                Datos generales
                <span x-text="seccion === 'datos' ? '−' : '+'"></span>
            </button>

            <div x-show="seccion === 'datos'" x-cloak class="px-4 pb-4 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-slate-600">Nombre</label>
                    <input type="text" name="nombre" value="{{ old('nombre', $cliente->nombre ) }}"
                        class="mt-1 w-full rounded border-slate-300 focus:ring-primary-500 focus:border-primary-500">
                    @error('nombre') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-600">Apellido</label>
                    <input type="text" name="apellido" value="{{ old('apellido', $cliente->apellido) }}"
                        class="mt-1 w-full rounded border-slate-300 focus:ring-primary-500 focus:border-primary-500">
                    @error('apellido') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-600">Correo</label>
                    <input type="email" name="correo" value="{{ old('correo', $cliente->correo) }}"
                        class="mt-1 w-full rounded border-slate-300 focus:ring-primary-500 focus:border-primary-500">
                    @error('correo') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-600">Teléfono</label>
                    <input type="text" name="telefono" value="{{ old('telefono', $cliente->telefono) }}"
                        class="mt-1 w-full rounded border-slate-300 focus:ring-primary-500 focus:border-primary-500">
                    @error('telefono') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        {{-- ===== Medidas Camisa ===== --}}
        <div class="bg-white rounded-lg shadow mb-4">
            <button type="button"
                @click="seccion = (seccion === 'camisa') ? null : 'camisa'"
                class="w-full flex justify-between items-center px-4 py-3 font-semibold text-slate-700">
                Medidas Camisa
                <span x-text="seccion === 'camisa' ? '−' : '+'"></span>
            </button>

            <div x-show="seccion === 'camisa'" x-cloak class="px-4 pb-4 grid grid-cols-2 gap-4">
                @foreach ([
                    'ancho_espalda' => 'Ancho espalda',
                    'largo_espalda' => 'Largo espalda',
                    'contorno_pecho' => 'Contorno pecho',
                    'hombro' => 'Hombro',
                    'manga' => 'Manga',
                    'puño' => 'Puño',
                    'antebrazo' => 'Antebrazo',
                    'cintura_suelta' => 'Cintura suelta',
                ] as $campo => $etiqueta)
                    <div>
                        <label class="block text-sm font-medium text-slate-600">{{ $etiqueta }}</label>
                        <input type="number" step="0.01" name="{{ $campo }}" value="{{ old($campo, $cliente->$campo) }}"
                            class="mt-1 w-full rounded border-slate-300 focus:ring-primary-500 focus:border-primary-500">
                        @error($campo) <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                @endforeach
            </div>
        </div>

        {{-- ===== Medidas Pantalón ===== --}}
        <div class="bg-white rounded-lg shadow mb-4">
            <button type="button"
                @click="seccion = (seccion === 'pantalon') ? null : 'pantalon'"
                class="w-full flex justify-between items-center px-4 py-3 font-semibold text-slate-700">
                Medidas Pantalón
                <span x-text="seccion === 'pantalon' ? '−' : '+'"></span>
            </button>

            <div x-show="seccion === 'pantalon'" x-cloak class="px-4 pb-4 grid grid-cols-2 gap-4">
                @foreach ([
                    'cintura' => 'Cintura',
                    'tiro' => 'Tiro',
                    'pierna' => 'Pierna',
                    'rodilla' => 'Rodilla',
                    'largo_pierna' => 'Largo pierna',
                    'bota' => 'Bota',
                ] as $campo => $etiqueta)
                    <div>
                        <label class="block text-sm font-medium text-slate-600">{{ $etiqueta }}</label>
                        <input type="number" step="0.01" name="{{ $campo }}" value="{{ old($campo, $cliente->$campo) }}"
                            class="mt-1 w-full rounded border-slate-300 focus:ring-primary-500 focus:border-primary-500">
                        @error($campo) <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                @endforeach
            </div>
        </div>

        {{-- ===== Medidas Generales ===== --}}
        <div class="bg-white rounded-lg shadow mb-4">
            <button type="button"
                @click="seccion = (seccion === 'generales') ? null : 'generales'"
                class="w-full flex justify-between items-center px-4 py-3 font-semibold text-slate-700">
                Medidas Generales
                <span x-text="seccion === 'generales' ? '−' : '+'"></span>
            </button>

            <div x-show="seccion === 'generales'" x-cloak class="px-4 pb-4">
                <label class="block text-sm font-medium text-slate-600">Largo total</label>
                <input type="number" step="0.01" name="largo_total" value="{{ old('largo_total', $cliente->largo_total) }}"
                    class="mt-1 w-full rounded border-slate-300 focus:ring-primary-500 focus:border-primary-500">
                @error('largo_total') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- ===== Notas ===== --}}
        <div class="bg-white rounded-lg shadow mb-4">
            <button type="button"
                @click="seccion = (seccion === 'notas') ? null : 'notas'"
                class="w-full flex justify-between items-center px-4 py-3 font-semibold text-slate-700">
                Notas
                <span x-text="seccion === 'notas' ? '−' : '+'"></span>
            </button>

            <div x-show="seccion === 'notas'" x-cloak class="px-4 pb-4">
                <textarea name="notas" rows="3"
                    class="mt-1 w-full rounded border-slate-300 focus:ring-primary-500 focus:border-primary-500">{{ old('notas', $cliente->notas) }}</textarea>
                @error('notas') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('clientes.index') }}"
                class="px-4 py-2 rounded border border-slate-300 text-slate-600 hover:bg-slate-50">
                Cancelar
            </a>
            <button type="submit"
                class="px-4 py-2 rounded bg-primary-600 text-white hover:bg-primary-700">
                Guardar cliente
            </button>
        </div>
    </form>
</div>
</x-card>

@endsection