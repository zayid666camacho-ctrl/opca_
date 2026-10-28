{{--
    OPCA — Centro de Gestión y Configuración
    Diseño inspirado en la composición "Tu Espacio Personalizado" del autor + Paleta A.
    Reúne los módulos de configuración, consultas secundarias y herramientas avanzadas en un solo panel limpio.
--}}
@extends('layouts.module')

@section('title', 'Centro de Gestión y Configuración')
@section('page-title', 'OPCA: Centro de Gestión y Configuración')

@section('content')

<div class="max-w-6xl mx-auto">

    {{-- Bloque Principal Oscuro Cálido (misma composición que la imagen de referencia del autor) --}}
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-brand-900 via-brand-900 to-brand-800 text-white p-8 sm:p-12 lg:p-14 shadow-2xl border border-brand-200/20">

        {{-- Destello cálido decorativo superior (como en la imagen de referencia) --}}
        <div class="pointer-events-none absolute -top-28 left-1/3 w-96 h-96 rounded-full bg-brand-600/25 blur-3xl"></div>

        <div class="relative z-10">
            <h2 class="text-3xl sm:text-5xl font-extrabold tracking-tight text-white leading-tight">
                Panel de Gestión: Tu Espacio NAyJA
            </h2>

            <p class="mt-4 text-sm sm:text-base text-slate-200 max-w-4xl leading-relaxed">
                ¡Bienvenido/a a tu panel, <strong class="font-bold text-white">{{ auth()->user()->name ?? 'Administradora NAyJA' }}</strong>! Aquí puedes acceder a los catálogos de precios, el directorio de clientes, el historial completo de trabajos y los ajustes del taller. La perfección está a un clic.
            </p>

            {{-- Cuadrícula de 6 módulos en 3 columnas (idéntica en proporciones a la imagen guía) --}}
            <div class="mt-12 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-10 gap-y-10">

                {{-- 1. Catálogo de Precios Base --}}
                <a href="{{ route('precio_bases.index') }}" class="group flex items-start gap-4 p-4 -m-4 rounded-2xl hover:bg-white/5 transition-colors">
                    <div class="w-12 h-12 rounded-xl border-2 border-brand-500 text-brand-500 flex items-center justify-center shrink-0 group-hover:bg-brand-600 group-hover:border-brand-600 group-hover:text-white transition-all">
                        <span class="w-6 h-6">@include('layouts.partials.icons', ['icon' => 'tag'])</span>
                    </div>
                    <div>
                        <h3 class="text-xl font-extrabold text-white group-hover:text-brand-200 transition-colors">
                            Precios Base y Tarifas
                        </h3>
                        <p class="mt-2 text-xs sm:text-sm text-slate-300 leading-relaxed">
                            Configura el catálogo de prendas, niveles de complejidad y precios de referencia que se usan al cotizar y congelar pedidos.
                        </p>
                    </div>
                </a>

                {{-- 2. Directorio de Clientes y Medidas --}}
                <a href="{{ route('clientes.index') }}" class="group flex items-start gap-4 p-4 -m-4 rounded-2xl hover:bg-white/5 transition-colors">
                    <div class="w-12 h-12 rounded-xl border-2 border-brand-500 text-brand-500 flex items-center justify-center shrink-0 group-hover:bg-brand-600 group-hover:border-brand-600 group-hover:text-white transition-all">
                        <span class="w-6 h-6">@include('layouts.partials.icons', ['icon' => 'users'])</span>
                    </div>
                    <div>
                        <h3 class="text-xl font-extrabold text-white group-hover:text-brand-200 transition-colors">
                            Clientes y Medidas
                        </h3>
                        <p class="mt-2 text-xs sm:text-sm text-slate-300 leading-relaxed">
                            Consulta y actualiza los datos de contacto y las medidas corporales (camisa, pantalón y generales) de cada cliente.
                        </p>
                    </div>
                </a>

                {{-- 3. Nuevo Pedido (Flujo Guiado) --}}
                <a href="{{ route('pedidos.nuevo') }}" class="group flex items-start gap-4 p-4 -m-4 rounded-2xl hover:bg-white/5 transition-colors">
                    <div class="w-12 h-12 rounded-full border-2 border-brand-500 text-brand-500 flex items-center justify-center shrink-0 group-hover:bg-brand-600 group-hover:border-brand-600 group-hover:text-white transition-all text-2xl font-light">
                        +
                    </div>
                    <div>
                        <h3 class="text-xl font-extrabold text-white group-hover:text-brand-200 transition-colors">
                            Nuevo Pedido
                        </h3>
                        <p class="mt-2 text-xs sm:text-sm text-slate-300 leading-relaxed">
                            Inicia un nuevo encargo paso a paso de forma rápida y sencilla: cliente, prendas, medidas, entrega y abono inicial.
                        </p>
                    </div>
                </a>

                {{-- 4. Historial de Trabajos / Lista Completa de Pedidos --}}
                <a href="{{ route('pedidos.index') }}" class="group flex items-start gap-4 p-4 -m-4 rounded-2xl hover:bg-white/5 transition-colors">
                    <div class="w-12 h-12 rounded-xl border-2 border-brand-500 text-brand-500 flex items-center justify-center shrink-0 group-hover:bg-brand-600 group-hover:border-brand-600 group-hover:text-white transition-all">
                        <span class="w-6 h-6">@include('layouts.partials.icons', ['icon' => 'search'])</span>
                    </div>
                    <div>
                        <h3 class="text-xl font-extrabold text-white group-hover:text-brand-200 transition-colors">
                            Historial de Pedidos
                        </h3>
                        <p class="mt-2 text-xs sm:text-sm text-slate-300 leading-relaxed">
                            Accede al archivo completo de todos los pedidos recibidos, en proceso, entregados o cancelados con filtros avanzados.
                        </p>
                    </div>
                </a>

                {{-- 5. Estado de Cuenta y Finanzas --}}
                <a href="{{ route('finanzas.index') }}" class="group flex items-start gap-4 p-4 -m-4 rounded-2xl hover:bg-white/5 transition-colors">
                    <div class="w-12 h-12 rounded-xl border-2 border-brand-500 text-brand-500 flex items-center justify-center shrink-0 group-hover:bg-brand-600 group-hover:border-brand-600 group-hover:text-white transition-all font-extrabold text-lg">
                        $
                    </div>
                    <div>
                        <h3 class="text-xl font-extrabold text-white group-hover:text-brand-200 transition-colors">
                            Estado de Cuenta
                        </h3>
                        <p class="mt-2 text-xs sm:text-sm text-slate-300 leading-relaxed">
                            Revisa tus transacciones, abonos, saldos pendientes por pedido y exporta reportes financieros a Excel.
                        </p>
                    </div>
                </a>

                {{-- 6. Seguridad y Cuentas (Uso técnico / avanzado) --}}
                @if (Route::has('seguridad.cuentas.index'))
                    <a href="{{ route('seguridad.cuentas.index') }}" class="group flex items-start gap-4 p-4 -m-4 rounded-2xl hover:bg-white/5 transition-colors">
                        <div class="w-12 h-12 rounded-xl border-2 border-gold-500/80 text-gold-500 flex items-center justify-center shrink-0 group-hover:bg-gold-500 group-hover:text-brand-900 transition-all">
                            <span class="w-6 h-6">@include('layouts.partials.icons', ['icon' => 'shield'])</span>
                        </div>
                        <div>
                            <h3 class="text-xl font-extrabold text-white group-hover:text-gold-500 transition-colors">
                                Cuentas y Seguridad
                            </h3>
                            <p class="mt-2 text-xs sm:text-sm text-slate-300 leading-relaxed">
                                Ajustes avanzados de usuarios, contraseñas y permisos del sistema (se recomienda modificar solo cuando sea necesario).
                            </p>
                        </div>
                    </a>
                @endif

            </div>
        </div>
    </div>

</div>

@endsection
