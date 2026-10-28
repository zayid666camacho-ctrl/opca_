{{--
    OPCA — Layout Principal del Panel (con Sidebar)
    Usado en Calendario y Kanban.
    - Paleta A: Carbón (#2B2B33), Rosa coral (#D6546A), Azul marino (#2F4B7C), Dorado (#C9A24B) y Crema cálido (#FFF8F5).
--}}
<!DOCTYPE html>
<html lang="es" class="h-full bg-brand-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Panel') — {{ config('app.name', 'OPCA') }}</title>

    {{-- Tailwind CSS vía CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50:  '#FFF8F5', // Fondo crema cálido
                            100: '#FDE8EA', // Rosa pastel suave
                            200: '#F8CFD4', // Bordes suaves
                            500: '#DF687C',
                            600: '#D6546A', // Rosa coral principal
                            700: '#BD3F55', // Hover rosa coral
                            800: '#2F4B7C', // Azul marino
                            900: '#2B2B33', // Carbón oscuro
                        },
                        gold: {
                            50:  '#FBF7EE',
                            100: '#F5EBCD',
                            500: '#C9A24B',
                            600: '#A88434',
                        },
                        accent: {
                            50:  '#EEF2F8',
                            100: '#DCE5F2',
                            400: '#4A6FA5',
                            500: '#2F4B7C',
                        },
                        primary: {
                            50:  '#FFF8F5',
                            100: '#FDE8EA',
                            200: '#F8CFD4',
                            300: '#F0959B',
                            400: '#DF687C',
                            500: '#D6546A',
                            600: '#BD3F55',
                            700: '#2F4B7C',
                            800: '#2B2B33',
                            900: '#2B2B33'
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif']
                    }
                }
            }
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Chart.js (solo se usa donde se necesita) --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js" defer></script>

    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Inter', ui-sans-serif, system-ui, sans-serif; }
    </style>

    @stack('styles')
</head>
<body class="h-full bg-brand-50 text-brand-900 antialiased">

    <div x-data="{ sidebarOpen: false }" class="min-h-screen flex">

        {{-- Overlay móvil --}}
        <div
            x-show="sidebarOpen"
            x-cloak
            @click="sidebarOpen = false"
            class="fixed inset-0 z-30 bg-brand-900/60 backdrop-blur-xs lg:hidden"
            aria-hidden="true"
        ></div>

        @include('layouts.partials.sidebar')

        <div class="flex-1 flex flex-col min-w-0 lg:pl-64">
            @include('layouts.partials.navbar')

            <main class="flex-1 p-4 sm:p-6 lg:p-8">
                @if (session('success'))
                    <x-alert type="success" class="mb-6">{{ session('success') }}</x-alert>
                @endif
                @if (session('error'))
                    <x-alert type="error" class="mb-6">{{ session('error') }}</x-alert>
                @endif

                @yield('content')
            </main>

            @include('layouts.partials.footer')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js" defer></script>

    @stack('scripts')
</body>
</html>
