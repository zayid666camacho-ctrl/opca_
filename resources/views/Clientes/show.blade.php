@extends('layouts.app')

@section('title')
    Detalle de cliente
@endsection

@section('content')

<x-card>
    <div class="max-w-3xl mx-auto mt-10" x-data="{ seccion: 'datos' }">

        <div class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-bold text-gray-700">
                {{ $cliente->nombre }} {{ $cliente->apellido }}
            </h2>

            <div class="space-x-2">
                <a href="{{ route('clientes.edit', $cliente->id) }}"
                    class="bg-primary-400 hover:bg-primary-500 text-white px-4 py-2 rounded">
                    Editar
                </a>
                <a href="{{ route('clientes.index') }}"
                    class="bg-gray-300 hover:bg-gray-400 text-white px-4 py-2 rounded">
                    Volver
                </a>
            </div>
        </div>

        {{-- ===== Datos generales ===== --}}
        <div class="bg-white rounded-lg shadow mb-4">
            <button type="button"
                @click="seccion = (seccion === 'datos') ? null : 'datos'"
                class="w-full flex justify-between items-center px-4 py-3 font-semibold text-slate-700">
                Datos generales
                <span x-text="seccion === 'datos' ? '−' : '+'"></span>
            </button>

            <div x-show="seccion === 'datos'" x-cloak class="px-4 pb-4 space-y-2">
                <p><span class="font-medium text-slate-600">Nombre:</span> {{ $cliente->nombre }}</p>
                <p><span class="font-medium text-slate-600">Apellido:</span> {{ $cliente->apellido }}</p>
                <p><span class="font-medium text-slate-600">Correo:</span> {{ $cliente->correo }}</p>
                <p><span class="font-medium text-slate-600">Teléfono:</span> {{ $cliente->telefono }}</p>
                <p><span class="font-medium text-slate-600">Fecha de registro:</span> {{ $cliente->fecha_registro }}</p>
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
        <div class="bg-white rounded-lg shadow mb-4">
            <button type="button"
                @click="seccion = (seccion === 'camisa') ? null : 'camisa'"
                class="w-full flex justify-between items-center px-4 py-3 font-semibold text-slate-700">
                Medidas Camisa
                <span x-text="seccion === 'camisa' ? '−' : '+'"></span>
            </button>

            <div x-show="seccion === 'camisa'" x-cloak class="px-4 pb-4">
                @if ($camisaConValor->isEmpty())
                    <p class="text-slate-400 italic">Sin medidas registradas.</p>
                @else
                    <div class="grid grid-cols-2 gap-2">
                        @foreach ($camisaConValor as $campo => $etiqueta)
                            <p><span class="font-medium text-slate-600">{{ $etiqueta }}:</span> {{ $cliente->$campo }}</p>
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
        <div class="bg-white rounded-lg shadow mb-4">
            <button type="button"
                @click="seccion = (seccion === 'pantalon') ? null : 'pantalon'"
                class="w-full flex justify-between items-center px-4 py-3 font-semibold text-slate-700">
                Medidas Pantalón
                <span x-text="seccion === 'pantalon' ? '−' : '+'"></span>
            </button>

            <div x-show="seccion === 'pantalon'" x-cloak class="px-4 pb-4">
                @if ($pantalonConValor->isEmpty())
                    <p class="text-slate-400 italic">Sin medidas registradas.</p>
                @else
                    <div class="grid grid-cols-2 gap-2">
                        @foreach ($pantalonConValor as $campo => $etiqueta)
                            <p><span class="font-medium text-slate-600">{{ $etiqueta }}:</span> {{ $cliente->$campo }}</p>
                        @endforeach
                    </div>
                @endif
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
                @if (is_null($cliente->largo_total))
                    <p class="text-slate-400 italic">Sin medidas registradas.</p>
                @else
                    <p><span class="font-medium text-slate-600">Largo total:</span> {{ $cliente->largo_total }}</p>
                @endif
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
                @if (empty($cliente->notas))
                    <p class="text-slate-400 italic">Sin notas registradas.</p>
                @else
                    <p class="whitespace-pre-line">{{ $cliente->notas }}</p>
                @endif
            </div>
        </div>

        {{-- ===== Historial de pedidos ===== --}}
        <div class="bg-white rounded-lg shadow mb-4">
            <button type="button"
                @click="seccion = (seccion === 'pedidos') ? null : 'pedidos'"
                class="w-full flex justify-between items-center px-4 py-3 font-semibold text-slate-700">
                Historial de pedidos
                <span x-text="seccion === 'pedidos' ? '−' : '+'"></span>
            </button>

            <div x-show="seccion === 'pedidos'" x-cloak class="px-4 pb-4">
                <p class="text-slate-400 italic">Aún no disponible —</p>
            </div>
        </div>

    </div>
</x-card>

@endsection