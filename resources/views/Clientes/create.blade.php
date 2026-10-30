@extends('layouts.module')

@section('title', 'Nuevo Cliente')
@section('page-title', 'Registrar Nuevo Cliente')

@section('content')

<div class="max-w-3xl mx-auto">

    <div class="bg-white rounded-2xl border border-brand-200/80 shadow-xs p-5 mb-6 flex items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-brand-900">Registrar Nuevo Cliente</h2>
            <p class="text-xs sm:text-sm text-brand-900/65 mt-0.5">Completa los datos básicos y, si lo deseas, registra sus medidas en centímetros.</p>
        </div>
        <a href="{{ route('clientes.index') }}"
           class="px-3.5 py-2 rounded-xl bg-brand-50 border border-brand-200 text-xs font-semibold text-brand-900 hover:bg-brand-100 transition-colors">
            ← Volver al directorio
        </a>
    </div>

    <form action="{{ route('clientes.store') }}" method="POST" x-data="{ seccion: 'datos' }" class="space-y-4">
        @csrf

        {{-- ===== Datos generales ===== --}}
        <div class="bg-white rounded-2xl border border-brand-200/80 shadow-xs overflow-hidden">
            <button type="button"
                @click="seccion = (seccion === 'datos') ? null : 'datos'"
                class="w-full flex justify-between items-center px-5 py-3.5 bg-brand-50/70 hover:bg-brand-100/50 font-bold text-sm text-brand-900 transition-colors">
                <span>1. Datos generales de contacto</span>
                <span class="text-brand-600 text-base font-bold" x-text="seccion === 'datos' ? '−' : '+'"></span>
            </button>

            <div x-show="seccion === 'datos'" x-cloak class="p-5 grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-brand-900/80 mb-1">Nombre *</label>
                    <input type="text" name="nombre" value="{{ old('nombre') }}"
                        class="w-full rounded-xl bg-brand-50/40 border border-brand-200 px-3.5 py-2 text-sm text-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-500">
                    @error('nombre') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold text-brand-900/80 mb-1">Apellido *</label>
                    <input type="text" name="apellido" value="{{ old('apellido') }}"
                        class="w-full rounded-xl bg-brand-50/40 border border-brand-200 px-3.5 py-2 text-sm text-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-500">
                    @error('apellido') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold text-brand-900/80 mb-1">Correo electrónico</label>
                    <input type="email" name="correo" value="{{ old('correo') }}"
                        class="w-full rounded-xl bg-brand-50/40 border border-brand-200 px-3.5 py-2 text-sm text-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-500">
                    @error('correo') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold text-brand-900/80 mb-1">Teléfono / WhatsApp</label>
                    <input type="text" name="telefono" value="{{ old('telefono') }}"
                        class="w-full rounded-xl bg-brand-50/40 border border-brand-200 px-3.5 py-2 text-sm text-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-500">
                    @error('telefono') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        {{-- ===== Medidas Camisa ===== --}}
        <div class="bg-white rounded-2xl border border-brand-200/80 shadow-xs overflow-hidden">
            <button type="button"
                @click="seccion = (seccion === 'camisa') ? null : 'camisa'"
                class="w-full flex justify-between items-center px-5 py-3.5 bg-brand-50/70 hover:bg-brand-100/50 font-bold text-sm text-brand-900 transition-colors">
                <span>2. Medidas Superiores / Camisa (CM)</span>
                <span class="text-brand-600 text-base font-bold" x-text="seccion === 'camisa' ? '−' : '+'"></span>
            </button>

            <div x-show="seccion === 'camisa'" x-cloak class="p-5 grid grid-cols-2 sm:grid-cols-4 gap-4">
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
                        <label class="block text-xs font-semibold text-brand-900/75 mb-1">{{ $etiqueta }}</label>
                        <input type="number" step="0.01" name="{{ $campo }}" value="{{ old($campo) }}"
                            class="w-full rounded-xl bg-brand-50/40 border border-brand-200 px-3 py-2 text-sm text-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-500">
                        @error($campo) <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                @endforeach
            </div>
        </div>

        {{-- ===== Medidas Pantalón ===== --}}
        <div class="bg-white rounded-2xl border border-brand-200/80 shadow-xs overflow-hidden">
            <button type="button"
                @click="seccion = (seccion === 'pantalon') ? null : 'pantalon'"
                class="w-full flex justify-between items-center px-5 py-3.5 bg-brand-50/70 hover:bg-brand-100/50 font-bold text-sm text-brand-900 transition-colors">
                <span>3. Medidas Inferiores / Pantalón (CM)</span>
                <span class="text-brand-600 text-base font-bold" x-text="seccion === 'pantalon' ? '−' : '+'"></span>
            </button>

            <div x-show="seccion === 'pantalon'" x-cloak class="p-5 grid grid-cols-2 sm:grid-cols-3 gap-4">
                @foreach ([
                    'cintura' => 'Cintura',
                    'tiro' => 'Tiro',
                    'pierna' => 'Pierna',
                    'rodilla' => 'Rodilla',
                    'largo_pierna' => 'Largo pierna',
                    'bota' => 'Bota',
                ] as $campo => $etiqueta)
                    <div>
                        <label class="block text-xs font-semibold text-brand-900/75 mb-1">{{ $etiqueta }}</label>
                        <input type="number" step="0.01" name="{{ $campo }}" value="{{ old($campo) }}"
                            class="w-full rounded-xl bg-brand-50/40 border border-brand-200 px-3 py-2 text-sm text-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-500">
                        @error($campo) <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                @endforeach
            </div>
        </div>

        {{-- ===== Medidas Generales ===== --}}
        <div class="bg-white rounded-2xl border border-brand-200/80 shadow-xs overflow-hidden">
            <button type="button"
                @click="seccion = (seccion === 'generales') ? null : 'generales'"
                class="w-full flex justify-between items-center px-5 py-3.5 bg-brand-50/70 hover:bg-brand-100/50 font-bold text-sm text-brand-900 transition-colors">
                <span>4. Medidas Generales (CM)</span>
                <span class="text-brand-600 text-base font-bold" x-text="seccion === 'generales' ? '−' : '+'"></span>
            </button>

            <div x-show="seccion === 'generales'" x-cloak class="p-5">
                <label class="block text-xs font-semibold text-brand-900/75 mb-1">Largo total</label>
                <input type="number" step="0.01" name="largo_total" value="{{ old('largo_total') }}"
                    class="w-full sm:w-64 rounded-xl bg-brand-50/40 border border-brand-200 px-3.5 py-2 text-sm text-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-500">
                @error('largo_total') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- ===== Notas ===== --}}
        <div class="bg-white rounded-2xl border border-brand-200/80 shadow-xs overflow-hidden">
            <button type="button"
                @click="seccion = (seccion === 'notas') ? null : 'notas'"
                class="w-full flex justify-between items-center px-5 py-3.5 bg-brand-50/70 hover:bg-brand-100/50 font-bold text-sm text-brand-900 transition-colors">
                <span>5. Notas y Observaciones</span>
                <span class="text-brand-600 text-base font-bold" x-text="seccion === 'notas' ? '−' : '+'"></span>
            </button>

            <div x-show="seccion === 'notas'" x-cloak class="p-5">
                <textarea name="notas" rows="3" placeholder="Preferencias de entalle, observaciones especiales..."
                    class="w-full rounded-xl bg-brand-50/40 border border-brand-200 px-3.5 py-2 text-sm text-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-500">{{ old('notas') }}</textarea>
                @error('notas') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="flex justify-end gap-3 pt-2">
            <a href="{{ route('clientes.index') }}"
                class="px-4 py-2.5 rounded-xl bg-white border border-brand-200 text-sm font-medium text-brand-900 hover:bg-brand-50 transition-colors">
                Cancelar
            </a>
            <button type="submit"
                class="px-5 py-2.5 rounded-xl bg-brand-600 text-white text-sm font-semibold hover:bg-brand-700 shadow-xs transition-colors">
                Guardar cliente
            </button>
        </div>
    </form>
</div>

@endsection
