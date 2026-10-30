@extends('layouts.module')

@section('title', 'Perfil del Taller')
@section('page-title', 'Perfil del Taller — Información Pública')

@section('content')

<div class="max-w-4xl mx-auto space-y-6">

    {{-- Encabezado limpio --}}
    <div class="bg-white rounded-lg border border-slate-200 shadow-2xs p-6 flex flex-wrap items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <img src="{{ asset('img/logo-nayja.jpg') }}" alt="Logo {{ $taller['nombre'] }}" class="w-14 h-14 rounded-full object-cover border border-slate-200">
            <div>
                <h2 class="text-xl font-bold text-brand-900">{{ $taller['nombre'] }}</h2>
                <p class="text-xs sm:text-sm text-slate-500 mt-0.5">
                    Estos son los datos oficiales que ven los clientes en la sección <strong>"Visítanos o Escríbenos"</strong> del sitio público.
                </p>
            </div>
        </div>

        <a href="{{ route('sitio.index') }}#contacto" target="_blank"
           class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-slate-100 hover:bg-slate-200 text-xs font-semibold text-brand-900 transition-colors">
            <span class="w-4 h-4">@include('layouts.partials.icons', ['icon' => 'eye'])</span>
            <span>Ver en Sitio Público</span>
        </a>
    </div>

    @if (session('success'))
        <div class="bg-emerald-50 border border-emerald-300 text-emerald-800 px-4 py-3 rounded-lg text-sm">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="bg-rose-50 border border-rose-300 text-rose-800 px-4 py-3 rounded-lg text-sm">
            <ul class="list-disc list-inside space-y-0.5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Formulario de edición de datos públicos del taller --}}
    <form action="{{ route('taller.perfil.actualizar') }}" method="POST" class="bg-white rounded-lg border border-slate-200 shadow-2xs p-6 sm:p-8 space-y-6">
        @csrf
        @method('PUT')

        <div class="border-b border-slate-200 pb-3">
            <h3 class="text-base font-bold text-brand-900">1. Identidad del Taller</h3>
            <p class="text-xs text-slate-500 mt-0.5">Nombre comercial y mensaje principal del taller.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Nombre del Taller *</label>
                <input type="text" name="nombre" value="{{ old('nombre', $taller['nombre']) }}" required
                    class="w-full rounded-lg border border-slate-300 px-3.5 py-2 text-sm text-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-600 focus:border-brand-600">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Eslogan *</label>
                <input type="text" name="eslogan" value="{{ old('eslogan', $taller['eslogan']) }}" required
                    class="w-full rounded-lg border border-slate-300 px-3.5 py-2 text-sm text-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-600 focus:border-brand-600">
            </div>

            <div class="sm:col-span-2">
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Descripción breve</label>
                <textarea name="descripcion" rows="2"
                    class="w-full rounded-lg border border-slate-300 px-3.5 py-2 text-sm text-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-600 focus:border-brand-600">{{ old('descripcion', $taller['descripcion']) }}</textarea>
            </div>
        </div>

        <div class="border-b border-slate-200 pb-3 pt-2">
            <h3 class="text-base font-bold text-brand-900">2. Datos de Contacto y Ubicación ("Visítanos o Escríbenos")</h3>
            <p class="text-xs text-slate-500 mt-0.5">Se actualizan automáticamente en la página pública y en los enlaces de WhatsApp.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Teléfono visible al público *</label>
                <input type="text" name="telefono" value="{{ old('telefono', $taller['telefono']) }}" required placeholder="Ej: +57 310 8289121"
                    class="w-full rounded-lg border border-slate-300 px-3.5 py-2 text-sm text-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-600 focus:border-brand-600">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Número de WhatsApp (solo dígitos con código de país) *</label>
                <input type="text" name="whatsapp" value="{{ old('whatsapp', $taller['whatsapp']) }}" required placeholder="Ej: 573108289121"
                    class="w-full rounded-lg border border-slate-300 px-3.5 py-2 text-sm text-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-600 focus:border-brand-600">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Correo electrónico de contacto *</label>
                <input type="email" name="correo" value="{{ old('correo', $taller['correo']) }}" required
                    class="w-full rounded-lg border border-slate-300 px-3.5 py-2 text-sm text-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-600 focus:border-brand-600">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Horario de atención *</label>
                <input type="text" name="horario" value="{{ old('horario', $taller['horario']) }}" required placeholder="Ej: Lunes a Viernes: 8:30 AM - 8:30 PM"
                    class="w-full rounded-lg border border-slate-300 px-3.5 py-2 text-sm text-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-600 focus:border-brand-600">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Dirección física del taller *</label>
                <input type="text" name="direccion" value="{{ old('direccion', $taller['direccion']) }}" required
                    class="w-full rounded-lg border border-slate-300 px-3.5 py-2 text-sm text-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-600 focus:border-brand-600">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Ciudad / País *</label>
                <input type="text" name="ciudad" value="{{ old('ciudad', $taller['ciudad']) }}" required
                    class="w-full rounded-lg border border-slate-300 px-3.5 py-2 text-sm text-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-600 focus:border-brand-600">
            </div>
        </div>

        <div class="pt-4 border-t border-slate-200 flex items-center justify-end gap-3">
            <button type="submit"
                class="px-6 py-2.5 rounded-lg bg-brand-600 hover:bg-brand-700 text-white text-sm font-semibold shadow-xs transition-colors cursor-pointer">
                Guardar información del taller
            </button>
        </div>
    </form>

</div>

@endsection
