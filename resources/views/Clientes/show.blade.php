@extends('layouts.module')

@section('title', 'Detalle de Cliente')
@section('page-title', 'Ficha de Cliente')

@section('content')

<div class="max-w-3xl mx-auto space-y-4" x-data="{ seccion: 'datos' }">

    <div class="bg-white rounded-2xl border border-brand-200/80 shadow-xs p-5 flex flex-wrap justify-between items-center gap-4">
        <div class="flex items-center gap-3.5">
            <div class="w-12 h-12 rounded-full bg-brand-100 text-brand-700 border border-brand-200 flex items-center justify-center text-base font-bold">
                {{ strtoupper(substr($cliente->nombre ?? '', 0, 1) . substr($cliente->apellido ?? '', 0, 1)) }}
            </div>
            <div>
                <h2 class="text-xl font-bold text-brand-900">
                    {{ $cliente->nombre }} {{ $cliente->apellido }}
                </h2>
                <p class="text-xs text-brand-900/60">Registrado el {{ $cliente->fecha_registro }}</p>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('clientes.edit', $cliente->id) }}"
               class="bg-brand-600 hover:bg-brand-700 text-white text-xs font-semibold px-4 py-2 rounded-xl shadow-xs transition-colors">
                Editar cliente
            </a>
            <a href="{{ route('clientes.index') }}"
               class="bg-brand-50 hover:bg-brand-100 border border-brand-200 text-brand-900 text-xs font-semibold px-3.5 py-2 rounded-xl transition-colors">
                ← Volver
            </a>
        </div>
    </div>

    {{-- ===== Datos generales ===== --}}
    <div class="bg-white rounded-2xl border border-brand-200/80 shadow-xs overflow-hidden">
        <button type="button"
            @click="seccion = (seccion === 'datos') ? null : 'datos'"
            class="w-full flex justify-between items-center px-5 py-3.5 bg-brand-50/70 font-bold text-sm text-brand-900">
            <span>Datos generales</span>
            <span class="text-brand-600 text-base font-bold" x-text="seccion === 'datos' ? '−' : '+'"></span>
        </button>

        <div x-show="seccion === 'datos'" x-cloak class="p-5 grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm text-brand-900">
            <p><span class="font-semibold text-brand-900/65">Nombre:</span> {{ $cliente->nombre }}</p>
            <p><span class="font-semibold text-brand-900/65">Apellido:</span> {{ $cliente->apellido }}</p>
            <p><span class="font-semibold text-brand-900/65">Correo:</span> {{ $cliente->correo ?: '—' }}</p>
            <p><span class="font-semibold text-brand-900/65">Teléfono:</span> {{ $cliente->telefono ?: '—' }}</p>
        </div>
    </div>

    {{-- ===== Medidas Camisa ===== --}}
    @php
        $medidasCamisa = [
            'ancho_espalda' => 'Ancho espalda',
            'largo_espalda' => 'Largo espalda',
            'contorno_pecho' => 'Contorno pecho',
            'hombro' => 'Hombro',
            'manga' => 'Manga',
            'puño' => 'Puño',
            'antebrazo' => 'Antebrazo',
            'cintura_suelta' => 'Cintura suelta',
        ];
        $camisaConValor = collect($medidasCamisa)->filter(fn($etiqueta, $campo) => !is_null($cliente->$campo));
    @endphp
    <div class="bg-white rounded-2xl border border-brand-200/80 shadow-xs overflow-hidden">
        <button type="button"
            @click="seccion = (seccion === 'camisa') ? null : 'camisa'"
            class="w-full flex justify-between items-center px-5 py-3.5 bg-brand-50/70 font-bold text-sm text-brand-900">
            <span>Medidas Superiores / Camisa (CM)</span>
            <span class="text-brand-600 text-base font-bold" x-text="seccion === 'camisa' ? '−' : '+'"></span>
        </button>

        <div x-show="seccion === 'camisa'" x-cloak class="p-5 text-sm">
            @if ($camisaConValor->isEmpty())
                <p class="text-brand-900/50 italic">Sin medidas registradas.</p>
            @else
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                    @foreach ($camisaConValor as $campo => $etiqueta)
                        <div class="bg-brand-50/60 border border-brand-100 rounded-xl p-2.5">
                            <span class="block text-xs text-brand-900/60">{{ $etiqueta }}</span>
                            <span class="font-bold text-brand-900">{{ $cliente->$campo }} cm</span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    {{-- ===== Medidas Pantalón ===== --}}
    @php
        $medidasPantalon = [
            'cintura' => 'Cintura',
            'tiro' => 'Tiro',
            'pierna' => 'Pierna',
            'rodilla' => 'Rodilla',
            'largo_pierna' => 'Largo pierna',
            'bota' => 'Bota',
        ];
        $pantalonConValor = collect($medidasPantalon)->filter(fn($etiqueta, $campo) => !is_null($cliente->$campo));
    @endphp
    <div class="bg-white rounded-2xl border border-brand-200/80 shadow-xs overflow-hidden">
        <button type="button"
            @click="seccion = (seccion === 'pantalon') ? null : 'pantalon'"
            class="w-full flex justify-between items-center px-5 py-3.5 bg-brand-50/70 font-bold text-sm text-brand-900">
            <span>Medidas Inferiores / Pantalón (CM)</span>
            <span class="text-brand-600 text-base font-bold" x-text="seccion === 'pantalon' ? '−' : '+'"></span>
        </button>

        <div x-show="seccion === 'pantalon'" x-cloak class="p-5 text-sm">
            @if ($pantalonConValor->isEmpty())
                <p class="text-brand-900/50 italic">Sin medidas registradas.</p>
            @else
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                    @foreach ($pantalonConValor as $campo => $etiqueta)
                        <div class="bg-brand-50/60 border border-brand-100 rounded-xl p-2.5">
                            <span class="block text-xs text-brand-900/60">{{ $etiqueta }}</span>
                            <span class="font-bold text-brand-900">{{ $cliente->$campo }} cm</span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    {{-- ===== Medidas Generales ===== --}}
    <div class="bg-white rounded-2xl border border-brand-200/80 shadow-xs overflow-hidden">
        <button type="button"
            @click="seccion = (seccion === 'generales') ? null : 'generales'"
            class="w-full flex justify-between items-center px-5 py-3.5 bg-brand-50/70 font-bold text-sm text-brand-900">
            <span>Medidas Generales (CM)</span>
            <span class="text-brand-600 text-base font-bold" x-text="seccion === 'generales' ? '−' : '+'"></span>
        </button>

        <div x-show="seccion === 'generales'" x-cloak class="p-5 text-sm">
            @if (is_null($cliente->largo_total))
                <p class="text-brand-900/50 italic">Sin medidas registradas.</p>
            @else
                <p><span class="font-semibold text-brand-900/65">Largo total:</span> <strong>{{ $cliente->largo_total }} cm</strong></p>
            @endif
        </div>
    </div>

    {{-- ===== Notas ===== --}}
    <div class="bg-white rounded-2xl border border-brand-200/80 shadow-xs overflow-hidden">
        <button type="button"
            @click="seccion = (seccion === 'notas') ? null : 'notas'"
            class="w-full flex justify-between items-center px-5 py-3.5 bg-brand-50/70 font-bold text-sm text-brand-900">
            <span>Notas y Observaciones</span>
            <span class="text-brand-600 text-base font-bold" x-text="seccion === 'notas' ? '−' : '+'"></span>
        </button>

        <div x-show="seccion === 'notas'" x-cloak class="p-5 text-sm text-brand-900">
            @if (empty($cliente->notas))
                <p class="text-brand-900/50 italic">Sin notas registradas.</p>
            @else
                <p class="whitespace-pre-line">{{ $cliente->notas }}</p>
            @endif
        </div>
    </div>

</div>

@endsection
