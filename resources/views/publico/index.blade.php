{{--
    OPCA — Vista Pública Principal (Sprint 8)
    Diseño editorial guiado por las 3 composiciones del autor + Paleta A y las imágenes oficiales del taller:
    - Hero: public/img/hero-sastre.jpg (Sastre en tono rosa)
    - Cotiza al instante: public/img/cotiza-taller.jpg (Taller con maniquíes y prendas)
    - Nuestros Servicios: public/img/servicios-maquina.jpg (Máquina de coser en tono rosa de fondo)
--}}
@extends('layouts.publico')

@section('title', 'Creaciones Nayja — Taller de Modistería')

@section('content')

{{-- =====================================================================
     1. SECCIÓN HERO (Composición Imagen 1 + hero-sastre.jpg)
     ===================================================================== --}}
<section id="inicio" class="relative min-h-[560px] lg:min-h-[640px] flex items-center overflow-hidden bg-brand-900 text-white">
    {{-- Imagen real del sastre en tono rosa --}}
    <div 
        class="absolute inset-0 bg-cover bg-center opacity-55"
        style="background-image: url('{{ asset('img/hero-sastre.jpg') }}');">
    </div>

    {{-- Superposición gradual más oscura a la izquierda para máxima legibilidad del texto --}}
    <div class="absolute inset-0 bg-gradient-to-r from-brand-900/90 via-brand-900/75 to-brand-900/40"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-28 w-full">
        <div class="max-w-4xl">
            <h1 class="text-3xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-white leading-[1.12] drop-shadow-sm">
                Bienvenidos a Confecciones NAyJA:<br>
                <span class="text-brand-100">Perfección en cada puntada</span>
            </h1>

            <p class="mt-6 text-base sm:text-lg text-slate-100 leading-relaxed max-w-3xl drop-shadow-sm">
                Transforma cada prenda en una nueva oportunidad.<br class="hidden sm:inline">
                Somos un taller de confección y arreglos comprometido con la <strong class="font-bold text-white">calidad, la puntualidad y el detalle en cada costura</strong>. Cada hilo, cada puntada y cada acabado reflejan nuestro amor por lo bien hecho y nuestro compromiso con quienes confían en nosotros.
            </p>

            {{-- Botones de acción (misma disposición que la Imagen 1) --}}
            <div class="mt-9 flex flex-wrap items-center gap-4">
                <a 
                    href="{{ route('sitio.galeria') }}" 
                    class="inline-flex items-center justify-center px-7 py-3.5 bg-brand-600 hover:bg-brand-700 text-white font-bold text-sm rounded-lg shadow-lg transition-all">
                    Galería
                </a>

                <a 
                    href="#servicios" 
                    class="inline-flex items-center justify-center px-7 py-3.5 bg-brand-900/40 backdrop-blur-sm border border-brand-500 text-brand-100 hover:bg-brand-600/30 hover:border-brand-200 font-semibold text-sm rounded-lg transition-all">
                    Conocer Servicios
                </a>
            </div>
        </div>
    </div>
</section>

{{-- =====================================================================
     2. POR QUÉ CONFIAR EN CREACIONES NAYJA (Composición Imagen 2: 3 pilares numerados)
     ===================================================================== --}}
<section class="py-20 sm:py-24 bg-brand-50 border-b border-brand-200/60">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <h2 class="text-3xl sm:text-4xl font-extrabold tracking-tight text-brand-900 mb-14">
            Por qué confiar en Creaciones NAyJA
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-10 lg:gap-12">

            {{-- Pilar 1 --}}
            <div class="flex items-start gap-4">
                <span class="w-11 h-11 rounded-lg bg-brand-600 text-white font-extrabold text-lg flex items-center justify-center shrink-0 shadow-sm mt-0.5">
                    1
                </span>
                <div>
                    <h3 class="text-xl sm:text-2xl font-extrabold text-brand-900 leading-tight mb-3">
                        Experiencia y<br>Calidad Artesanal
                    </h3>
                    <p class="text-sm sm:text-base text-brand-900/75 leading-relaxed">
                        Con años de dedicación al arte de la costura, en Creaciones NAyJA nos enorgullecemos de ofrecer acabados impecables y atención al detalle en cada prenda, transformando tus ideas en realidad con maestría.
                    </p>
                </div>
            </div>

            {{-- Pilar 2 --}}
            <div class="flex items-start gap-4">
                <span class="w-11 h-11 rounded-lg bg-brand-600 text-white font-extrabold text-lg flex items-center justify-center shrink-0 shadow-sm mt-0.5">
                    2
                </span>
                <div>
                    <h3 class="text-xl sm:text-2xl font-extrabold text-brand-900 leading-tight mb-3">
                        Clientes<br>Satisfechos
                    </h3>
                    <p class="text-sm sm:text-base text-brand-900/75 leading-relaxed">
                        Nuestra reputación se construye sobre la confianza de cientos de clientes que han elegido Creaciones NAyJA por nuestro compromiso con sus expectativas y la entrega de resultados excepcionales que superan sus deseos.
                    </p>
                </div>
            </div>

            {{-- Pilar 3 --}}
            <div class="flex items-start gap-4">
                <span class="w-11 h-11 rounded-lg bg-brand-600 text-white font-extrabold text-lg flex items-center justify-center shrink-0 shadow-sm mt-0.5">
                    3
                </span>
                <div>
                    <h3 class="text-xl sm:text-2xl font-extrabold text-brand-900 leading-tight mb-3">
                        Compromiso y<br>Trayectoria
                    </h3>
                    <p class="text-sm sm:text-base text-brand-900/75 leading-relaxed">
                        Desde nuestra fundación, Creaciones NAyJA se ha consolidado como un referente de confianza en la costura, trabajando con pasión para dar vida a tus proyectos con la precisión y el cuidado que mereces.
                    </p>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- =====================================================================
     3. COTIZA AL INSTANTE Y CON TRANSPARENCIA TOTAL (Composición Imagen 3 + cotiza-taller.jpg)
     ===================================================================== --}}
<section class="py-20 sm:py-24 bg-white border-b border-brand-200/60">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">

            {{-- Columna izquierda: Texto + barra vertical + acciones --}}
            <div class="lg:col-span-7">
                <h2 class="text-3xl sm:text-4xl font-extrabold tracking-tight text-brand-900 leading-tight">
                    Cotiza al instante y con transparencia total
                </h2>

                <p class="mt-5 text-base text-brand-900/80 leading-relaxed">
                    Consulta presupuestos claros, detallados y personalizados en minutos, basados en nuestro catálogo de precios base y la complejidad de cada prenda (Baja, Media o Alta).
                </p>

                {{-- Bloque destacado con barra vertical izquierda en rosa coral (idéntico a Imagen 3) --}}
                <div class="my-6 pl-5 border-l-4 border-brand-600 py-1">
                    <p class="text-sm sm:text-base text-brand-900 font-medium leading-relaxed">
                        Evita malentendidos y acelera el proceso de inicio de la confección con tarifas de referencia claras y atención directa por WhatsApp, garantizando un flujo de trabajo ágil.
                    </p>
                </div>

                <p class="text-sm sm:text-base text-brand-900/70 leading-relaxed">
                    Ejemplo real: consulta el valor base de tu prenda desde tu móvil en menos de 2 minutos y escríbenos con un solo clic para agendar tu toma de medidas.
                </p>

                <div class="mt-8 flex flex-wrap gap-4">
                    <a 
                        href="{{ route('sitio.precios') }}" 
                        class="inline-flex items-center gap-2 px-6 py-3.5 bg-brand-600 hover:bg-brand-700 text-white text-sm font-bold rounded-lg shadow transition-all">
                        Ver Tarifas y Precios Base
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>

            {{-- Columna derecha: Imagen real del taller con maniquíes (cotiza-taller.jpg) --}}
            <div class="lg:col-span-5">
                <div class="relative rounded-2xl overflow-hidden shadow-xl border border-brand-200 bg-brand-50 aspect-[4/3]">
                    <img 
                        src="{{ asset('img/cotiza-taller.jpg') }}" 
                        alt="Prendas y diseño en Creaciones Nayja"
                        class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-brand-900/80 via-brand-900/15 to-transparent flex items-end p-6">
                        <div class="text-white">
                            <span class="text-xs font-bold uppercase tracking-widest text-gold-500">Catálogo Transparente</span>
                            <p class="text-lg font-bold mt-0.5">Precios base por prenda y complejidad</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</section>

{{-- =====================================================================
    4. NUESTROS SERVICIOS DE COSTURA (con servicios-maquina.jpg de fondo)
    ===================================================================== --}}
<section id="servicios" class="relative py-20 sm:py-24 overflow-hidden border-b border-brand-200/60">
    {{-- Imagen de fondo de la máquina de coser en tono rosa --}}
    <div 
        class="absolute inset-0 bg-cover bg-center"
        style="background-image: url('{{ asset('img/servicios-maquina.jpg') }}');">
    </div>
    {{-- Velo cálido translúcido para que se aprecie la máquina de coser sin perder lectura --}}
    <div class="absolute inset-0 bg-brand-900/75 backdrop-blur-[2px]"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="max-w-2xl mb-14">
            <span class="text-xs font-bold uppercase tracking-widest text-gold-500">¿Qué hacemos?</span>
            <h2 class="text-3xl sm:text-4xl font-extrabold tracking-tight text-white mt-1">Nuestros Servicios de Costura</h2>
            <p class="text-brand-100/90 text-base mt-3">Cada prenda recibe atención personalizada para asegurar un calce perfecto y acabados de primera calidad.</p>
        </div>

        @php
            $estilos_tarjetas = [
                ['borde' => 'border-t-4 border-t-brand-600', 'icono' => 'bg-brand-100 text-brand-700'],
                ['borde' => 'border-t-4 border-t-gold-500',  'icono' => 'bg-gold-100 text-gold-600'],
                ['borde' => 'border-t-4 border-t-brand-800', 'icono' => 'bg-accent-100 text-brand-800'],
            ];
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach ($servicios as $i => $servicio)
                @php $estilo = $estilos_tarjetas[$i % 3]; @endphp
                <div class="bg-white/95 backdrop-blur-sm p-8 rounded-2xl border border-white/20 {{ $estilo['borde'] }} shadow-lg hover:shadow-xl transition-all flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 rounded-xl {{ $estilo['icono'] }} flex items-center justify-center mb-6">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.121 14.121L19 19m-7-7l7-7m-7 7l-2.879 2.879M12 12L9.121 9.121m0 5.758a3 3 0 10-4.243 4.243 3 3 0 004.243-4.243zm0-5.758a3 3 0 10-4.243-4.243 3 3 0 004.243 4.243z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-brand-900 mb-2">{{ $servicio['titulo'] }}</h3>
                        <p class="text-sm text-brand-900/75 leading-relaxed">{{ $servicio['descripcion'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- =====================================================================
    5. SECCIÓN DE CONTACTO Y UBICACIÓN (HU33)
    ===================================================================== --}}
<section id="contacto" class="py-20 sm:py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="max-w-4xl mx-auto bg-brand-50 border border-brand-200/80 rounded-3xl p-8 sm:p-12 shadow-sm">
            <div class="mb-10">
                <span class="text-xs font-bold uppercase tracking-widest text-brand-600">Ponte en Contacto</span>
                <h2 class="text-3xl font-extrabold tracking-tight text-brand-900 mt-1">Visítanos o Escríbenos</h2>
                <p class="text-brand-900/75 text-sm sm:text-base mt-2">Estamos listos para hacer realidad tu próxima prenda o ajustar tus piezas favoritas.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-sm">
                
                {{-- Teléfono / WhatsApp --}}
                <div class="p-5 bg-white rounded-2xl border border-brand-200/60 shadow-sm flex items-start gap-4">
                    <div class="p-3 bg-emerald-100 text-emerald-700 rounded-xl shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                    </div>
                    <div>
                        <span class="text-xs font-semibold text-brand-900/60 uppercase tracking-wider">Teléfono / WhatsApp</span>
                        <a href="https://wa.me/{{ $taller['whatsapp'] }}" class="block font-bold text-brand-900 hover:text-brand-600 transition-colors mt-0.5">
                            {{ $taller['telefono'] }}
                        </a>
                        <span class="text-xs text-brand-900/60">Atención rápida por chat</span>
                    </div>
                </div>

                {{-- Correo Electrónico --}}
                <div class="p-5 bg-white rounded-2xl border border-brand-200/60 shadow-sm flex items-start gap-4">
                    <div class="p-3 bg-accent-100 text-brand-800 rounded-xl shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <span class="text-xs font-semibold text-brand-900/60 uppercase tracking-wider">Correo Electrónico</span>
                        <a href="mailto:{{ $taller['correo'] }}" class="block font-bold text-brand-900 hover:text-brand-600 transition-colors mt-0.5">
                            {{ $taller['correo'] }}
                        </a>
                        <span class="text-xs text-brand-900/60">Consultas y cotizaciones</span>
                    </div>
                </div>

                {{-- Dirección Física --}}
                <div class="p-5 bg-white rounded-2xl border border-brand-200/60 shadow-sm flex items-start gap-4">
                    <div class="p-3 bg-brand-100 text-brand-600 rounded-xl shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <div>
                        <span class="text-xs font-semibold text-brand-900/60 uppercase tracking-wider">Ubicación del Taller</span>
                        <p class="font-bold text-brand-900 mt-0.5">{{ $taller['direccion'] }}</p>
                        <span class="text-xs text-brand-900/60">{{ $taller['ciudad'] }}</span>
                    </div>
                </div>

                {{-- Horario de Atención --}}
                <div class="p-5 bg-white rounded-2xl border border-brand-200/60 shadow-sm flex items-start gap-4">
                    <div class="p-3 bg-gold-100 text-gold-600 rounded-xl shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <span class="text-xs font-semibold text-brand-900/60 uppercase tracking-wider">Horario de Atención</span>
                        <p class="font-bold text-brand-900 mt-0.5">{{ $taller['horario'] }}</p>
                        <span class="text-xs text-brand-900/60">Pruebas con cita previa</span>
                    </div>
                </div>

            </div>

            {{-- Botón destacado inferior --}}
            <div class="mt-8">
                <a 
                    href="https://wa.me/{{ $taller['whatsapp'] }}?text={{ urlencode('Hola Creaciones Nayja, deseo información sobre sus servicios.') }}" 
                    target="_blank" 
                    rel="noopener noreferrer"
                    class="inline-flex items-center gap-2 px-8 py-3.5 bg-brand-600 text-white font-bold text-sm rounded-lg hover:bg-brand-700 transition-colors shadow">
                    Agendar una visita o cotización
                </a>
            </div>
        </div>

    </div>
</section>

@endsection
