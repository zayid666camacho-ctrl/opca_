{{--
    OPCA — Layout Público
    Plantilla base para clientes y visitantes sin inicio de sesión.
    - HU34: Totalmente responsive (móvil, tablet y PC).
    - Paleta A (del logo original): Rosa coral (#D6546A), Azul marino (#2F4B7C), Dorado (#C9A24B), Carbón (#2B2B33) y Fondo crema cálido (#FFF8F5).
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
                            50:  '#FFF8F5', // Fondo crema cálido muy suave
                            100: '#FDE8EA', // Rosa pastel suave (fondos secundarios)
                            200: '#F8CFD4', // Bordes suaves
                            500: '#DF687C',
                            600: '#D6546A', // Rosa coral del logo (botones principales)
                            700: '#BD3F55', // Hover de botones
                            800: '#2F4B7C', // Azul marino del logo
                            900: '#2B2B33', // Carbón oscuro para textos y contraste
                        },
                        gold: {
                            50:  '#FBF7EE',
                            100: '#F5EBCD',
                            500: '#C9A24B', // Dorado de la máquina de coser
                            600: '#A88434',
                        },
                        accent: {
                            50:  '#EEF2F8',
                            100: '#DCE5F2',
                            400: '#4A6FA5',
                            500: '#2F4B7C', // Azul marino / denim del logo
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
<body class="h-full bg-brand-50 text-brand-900 flex flex-col antialiased" x-data="{ menuAbierto: false }">

    {{-- CABECERA / NAVBAR PÚBLICA --}}
    <header class="bg-white/95 backdrop-blur-sm sticky top-0 z-40 border-b border-brand-200/60 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                
                {{-- Logo e Identidad del Taller --}}
                <a href="{{ route('sitio.index') }}" class="flex items-center gap-3 group">
                    <img src="{{ asset('img/logo-nayja.jpg') }}" alt="Logo Creaciones Nayja" class="w-11 h-11 rounded-full object-cover shadow-sm ring-2 ring-brand-200 group-hover:scale-105 transition-transform">
                    <div>
                        <span class="text-xl font-bold tracking-tight text-brand-900 block leading-tight">Creaciones Nayja</span>
                        <span class="text-xs text-brand-800 font-medium">Taller de Modistería</span>
                    </div>
                </a>

                {{-- Acciones (sin enlaces redundantes: la página guía al visitante) --}}
                <div class="flex items-center gap-3">
                    @if (!request()->routeIs('sitio.index'))
                        <a href="{{ route('sitio.index') }}" class="px-3.5 py-2 text-xs font-semibold text-brand-900/75 hover:text-brand-600 transition-colors">
                            &larr; Inicio
                        </a>
                    @endif

                    {{-- Si ya hay sesión se va al panel; si no, al formulario de ingreso --}}
                    <a href="{{ auth()->check() ? route('calendario.index') : route('login') }}" class="px-4 py-2 text-xs font-semibold text-brand-800 border border-brand-200 hover:bg-brand-100/60 rounded-lg transition-colors">
                        {{ auth()->check() ? 'Ir al panel' : 'Acceso Taller' }}
                    </a>
                </div>
            </div>
        </div>
    </header>

    {{-- CONTENIDO PRINCIPAL --}}
    <main class="flex-1">
        @yield('content')
    </main>

    {{-- PIE DE PÁGINA PÚBLICO --}}
    <footer class="bg-brand-900 text-slate-200 py-12 border-t border-brand-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('img/logo-nayja.jpg') }}" alt="Logo Creaciones Nayja" class="w-10 h-10 rounded-full object-cover ring-2 ring-gold-500/50">
                    <div>
                        <span class="text-lg font-bold tracking-tight text-white block leading-tight">Creaciones Nayja</span>
                        <p class="text-xs text-slate-400 mt-0.5">Confección y arreglos de costura con dedicación y detalle.</p>
                    </div>
                </div>
                <div class="text-center md:text-right text-xs text-slate-400 space-y-1.5">
                    <div class="inline-flex items-center gap-2 justify-center md:justify-end">
                        <img src="{{ asset('img/logo-opca.png') }}" alt="OPCA" class="h-7 w-7 object-contain drop-shadow">
                        <span class="text-gold-500 font-bold tracking-wide">Impulsado por OPCA — Sistema de Gestión de Modistería</span>
                    </div>
                    <p>Proyecto de grado ADSO — SENA Colombia · &copy; {{ date('Y') }} Creaciones Nayja</p>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
