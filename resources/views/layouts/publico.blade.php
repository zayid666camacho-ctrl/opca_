{{--
    OPCA — Layout Público
    Plantilla base para clientes y visitantes sin inicio de sesión.
    - HU34: Totalmente responsive (móvil, tablet y PC).
    - Paleta con fondo claro y acentos cálidos según el Documento Maestro.
--}}
<!DOCTYPE html>
<html lang="es" class="h-full scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Creaciones Nayja') — Taller de Modistería</title>

    {{-- Tailwind CSS vía CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#fff1f2',
                            100: '#ffe4e6',
                            200: '#fecdd3',
                            500: '#f43f5e',
                            600: '#e11d48',
                            900: '#881337',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif']
                    }
                }
            }
        }
    </script>

    {{-- Tipografía Inter --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Alpine.js vía CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js" defer></script>

    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="h-full bg-slate-50 text-neutral-800 flex flex-col antialiased" x-data="{ menuAbierto: false }">

    {{-- CABECERA / NAVBAR PÚBLICA --}}
    <header class="bg-white/95 backdrop-blur-sm sticky top-0 z-40 border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                
                {{-- Logo e Identidad del Taller --}}
                <a href="{{ route('sitio.index') }}" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 rounded-xl bg-neutral-900 text-white flex items-center justify-center font-bold text-lg shadow-sm group-hover:scale-105 transition-transform">
                        N
                    </div>
                    <div>
                        <span class="text-xl font-bold tracking-tight text-neutral-900 block leading-tight">Creaciones Nayja</span>
                        <span class="text-xs text-neutral-500 font-medium">Taller de Modistería</span>
                    </div>
                </a>

                {{-- Enlaces de navegación (Escritorio) --}}
                <nav class="hidden md:flex items-center gap-8 text-sm font-medium text-neutral-600">
                    <a href="#inicio" class="hover:text-neutral-900 transition-colors">Inicio</a>
                    <a href="#servicios" class="hover:text-neutral-900 transition-colors">Servicios</a>
                    <a href="#contacto" class="hover:text-neutral-900 transition-colors">Contacto</a>
                </nav>

                {{-- Acciones (Escritorio) --}}
                <div class="hidden md:flex items-center gap-3">
                    <a href="{{ route('calendario.index') }}" class="px-3.5 py-2 text-xs font-semibold text-neutral-600 hover:text-neutral-900 hover:bg-slate-100 rounded-lg transition-colors">
                        Acceso Taller
                    </a>
                    <a href="#contacto" class="px-4 py-2 bg-neutral-900 hover:bg-neutral-800 text-white text-xs font-semibold rounded-lg shadow-sm transition-all hover:shadow">
                        Cotizar Prenda
                    </a>
                </div>

                {{-- Botón Menú Móvil (Hamburguesa) --}}
                <div class="flex md:hidden">
                    <button 
                        @click="menuAbierto = !menuAbierto" 
                        type="button" 
                        class="p-2 text-neutral-600 hover:text-neutral-900 focus:outline-none" 
                        aria-label="Abrir menú">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path x-show="!menuAbierto" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path x-show="menuAbierto" x-cloak stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- Menú desplegable Móvil (HU34) --}}
        <div x-show="menuAbierto" x-cloak @click.away="menuAbierto = false" class="md:hidden border-b border-slate-200 bg-white px-4 pt-3 pb-6 space-y-3">
            <a href="#inicio" @click="menuAbierto = false" class="block py-2 text-base font-medium text-neutral-700 hover:text-neutral-900">Inicio</a>
            <a href="#servicios" @click="menuAbierto = false" class="block py-2 text-base font-medium text-neutral-700 hover:text-neutral-900">Servicios</a>
            <a href="#contacto" @click="menuAbierto = false" class="block py-2 text-base font-medium text-neutral-700 hover:text-neutral-900">Contacto</a>
            <div class="pt-3 border-t border-slate-100 flex flex-col gap-2">
                <a href="#contacto" @click="menuAbierto = false" class="w-full text-center py-2.5 bg-neutral-900 text-white text-sm font-semibold rounded-lg">
                    Cotizar Prenda
                </a>
                <a href="{{ route('calendario.index') }}" class="w-full text-center py-2 text-xs font-medium text-neutral-500 hover:text-neutral-800">
                    Acceso Administradora
                </a>
            </div>
        </div>
    </header>

    {{-- CONTENIDO PRINCIPAL --}}
    <main class="flex-1">
        @yield('content')
    </main>

    {{-- PIE DE PÁGINA PÚBLICO --}}
    <footer class="bg-neutral-900 text-neutral-300 py-12 border-t border-neutral-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                <div>
                    <span class="text-xl font-bold tracking-tight text-white block">Creaciones Nayja</span>
                    <p class="text-xs text-neutral-400 mt-1">Confección y arreglos de costura con dedicación y detalle.</p>
                </div>
                <div class="text-center md:text-right text-xs text-neutral-500 space-y-1">
                    <p>Proyecto de grado ADSO — SENA Colombia</p>
                    <p>&copy; {{ date('Y') }} Creaciones Nayja. Todos los derechos reservados.</p>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>