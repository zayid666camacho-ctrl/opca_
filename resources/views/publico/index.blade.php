{{--
    OPCA — Vista Pública Principal (Sprint 8)
    Presentación del taller Creaciones Nayja e información de contacto para clientes.

    Historias de usuario:
    - HU33: Información de contacto (teléfono, WhatsApp, correo, dirección y horario).
    - HU34: Experiencia visual responsive y moderna adaptada a cualquier dispositivo.
--}}
@extends('layouts.publico')

@section('title', 'Creaciones Nayja — Taller de Modistería')

@section('content')

{{-- =====================================================================
     1. SECCIÓN HERO (BIENVENIDA)
     ===================================================================== --}}
<section id="inicio" class="relative overflow-hidden bg-white py-16 sm:py-24 border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-slate-100 text-neutral-700 text-xs font-semibold mb-6">
                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                Taller Abierto • Confecciones & Arreglos
            </div>
            
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-neutral-900 leading-[1.15]">
                Prendas hechas a tu medida con dedicación y estilo.
            </h1>
            
            <p class="mt-6 text-lg sm:text-xl text-neutral-600 leading-relaxed">
                {{ $taller['descripcion'] }} Especialistas en confección de prendas sobre medidas anatómicas, ajustes precisos y transformación textil.
            </p>

            <div class="mt-8 flex flex-col sm:flex-row gap-4">
                {{-- Enlace directo a WhatsApp para cotizar (HU33) --}}
                <a 
                    href="https://wa.me/{{ $taller['whatsapp'] }}?text={{ urlencode('¡Hola Creaciones Nayja! Me gustaría cotizar un trabajo de costura.') }}" 
                    target="_blank" 
                    rel="noopener noreferrer"
                    class="inline-flex items-center justify-center gap-2 px-6 py-3.5 bg-neutral-900 text-white font-semibold text-sm rounded-xl hover:bg-neutral-800 transition-all shadow-md hover:shadow-lg">
                    <svg class="w-5 h-5 text-emerald-400" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.598 2.664-.698c.974.53 1.83.81 2.796.81 3.183 0 5.77-2.587 5.77-5.766.001-3.182-2.585-5.767-5.77-5.767zm0 10.372c-.876 0-1.704-.265-2.428-.73l-.174-.108-1.799.472.48-1.753-.119-.189c-.524-.834-.8-1.748-.799-2.698.001-2.535 2.062-4.596 4.598-4.596 2.537 0 4.598 2.061 4.598 4.596 0 2.536-2.061 4.596-4.598 4.596z"/>
                    </svg>
                    Escríbenos por WhatsApp
                </a>

                <a 
                    href="#servicios" 
                    class="inline-flex items-center justify-center px-6 py-3.5 bg-slate-100 text-neutral-800 font-semibold text-sm rounded-xl hover:bg-slate-200 transition-colors">
                    Conocer Servicios
                </a>
            </div>
        </div>
    </div>
</section>

{{-- =====================================================================
     2. SECCIÓN DE SERVICIOS
     ===================================================================== --}}
<section id="servicios" class="py-16 sm:py-20 bg-slate-50 border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center max-w-2xl mx-auto mb-14">
            <span class="text-xs font-bold uppercase tracking-wider text-neutral-500">¿Qué hacemos?</span>
            <h2 class="text-3xl font-bold tracking-tight text-neutral-900 mt-2">Nuestros Servicios de Costura</h2>
            <p class="text-neutral-600 text-sm mt-3">Cada prenda recibe atención personalizada para asegurar un calce perfecto y acabados de primera calidad.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach ($servicios as $servicio)
                <div class="bg-white p-8 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 rounded-xl bg-slate-100 flex items-center justify-center text-neutral-900 mb-6">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.121 14.121L19 19m-7-7l7-7m-7 7l-2.879 2.879M12 12L9.121 9.121m0 5.758a3 3 0 10-4.243 4.243 3 3 0 004.243-4.243zm0-5.758a3 3 0 10-4.243-4.243 3 3 0 004.243 4.243z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-neutral-900 mb-2">{{ $servicio['titulo'] }}</h3>
                        <p class="text-sm text-neutral-600 leading-relaxed">{{ $servicio['descripcion'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- =====================================================================
     3. SECCIÓN DE CONTACTO Y UBICACIÓN (HU33)
     ===================================================================== --}}
<section id="contacto" class="py-16 sm:py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="max-w-3xl mx-auto bg-slate-50 border border-slate-200 rounded-3xl p-8 sm:p-12 shadow-sm">
            <div class="text-center mb-10">
                <span class="text-xs font-bold uppercase tracking-wider text-neutral-500">Ponte en Contacto</span>
                <h2 class="text-3xl font-bold tracking-tight text-neutral-900 mt-2">Visítanos o Escríbenos</h2>
                <p class="text-neutral-600 text-sm mt-2">Estamos listos para hacer realidad tu próxima prenda o ajustar tus piezas favoritas.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-sm">
                
                {{-- Teléfono / WhatsApp --}}
                <div class="p-5 bg-white rounded-2xl border border-slate-200 shadow-sm flex items-start gap-4">
                    <div class="p-3 bg-emerald-50 text-emerald-700 rounded-xl shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                    </div>
                    <div>
                        <span class="text-xs font-semibold text-neutral-500 uppercase tracking-wider">Teléfono / WhatsApp</span>
                        <a href="https://wa.me/{{ $taller['whatsapp'] }}" class="block font-bold text-neutral-900 hover:text-emerald-600 transition-colors mt-0.5">
                            {{ $taller['telefono'] }}
                        </a>
                        <span class="text-xs text-neutral-500">Atención rápida por chat</span>
                    </div>
                </div>

                {{-- Correo Electrónico --}}
                <div class="p-5 bg-white rounded-2xl border border-slate-200 shadow-sm flex items-start gap-4">
                    <div class="p-3 bg-blue-50 text-blue-700 rounded-xl shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <span class="text-xs font-semibold text-neutral-500 uppercase tracking-wider">Correo Electrónico</span>
                        <a href="mailto:{{ $taller['correo'] }}" class="block font-bold text-neutral-900 hover:text-blue-600 transition-colors mt-0.5">
                            {{ $taller['correo'] }}
                        </a>
                        <span class="text-xs text-neutral-500">Consultas y cotizaciones</span>
                    </div>
                </div>

                {{-- Dirección Física --}}
                <div class="p-5 bg-white rounded-2xl border border-slate-200 shadow-sm flex items-start gap-4">
                    <div class="p-3 bg-rose-50 text-rose-700 rounded-xl shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <div>
                        <span class="text-xs font-semibold text-neutral-500 uppercase tracking-wider">Ubicación del Taller</span>
                        <p class="font-bold text-neutral-900 mt-0.5">{{ $taller['direccion'] }}</p>
                        <span class="text-xs text-neutral-500">{{ $taller['ciudad'] }}</span>
                    </div>
                </div>

                {{-- Horario de Atención --}}
                <div class="p-5 bg-white rounded-2xl border border-slate-200 shadow-sm flex items-start gap-4">
                    <div class="p-3 bg-amber-50 text-amber-700 rounded-xl shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <span class="text-xs font-semibold text-neutral-500 uppercase tracking-wider">Horario de Atención</span>
                        <p class="font-bold text-neutral-900 mt-0.5">{{ $taller['horario'] }}</p>
                        <span class="text-xs text-neutral-500">Pruebas con cita previa</span>
                    </div>
                </div>

            </div>

            {{-- Botón destacado inferior --}}
            <div class="mt-8 text-center">
                <a 
                    href="https://wa.me/{{ $taller['whatsapp'] }}?text={{ urlencode('Hola Creaciones Nayja, deseo información sobre sus servicios.') }}" 
                    target="_blank" 
                    rel="noopener noreferrer"
                    class="inline-flex items-center gap-2 px-8 py-3 bg-neutral-900 text-white font-semibold text-sm rounded-xl hover:bg-neutral-800 transition-colors shadow">
                    Agendar una visita o cotización
                </a>
            </div>
        </div>

    </div>
</section>

@endsection