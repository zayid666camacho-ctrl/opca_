{{--
    OPCA — Layout de Módulos del Panel (sin Sidebar)
    Usado en Pedidos, Clientes, Finanzas, Inventario, Galería, Precios Base, etc.
    - Paleta A: Carbón (#2B2B33), Rosa coral (#D6546A), Azul marino (#2F4B7C), Dorado (#C9A24B) y Crema cálido (#FFF8F5).
--}}
<!DOCTYPE html>
<html lang="es" class="h-full bg-brand-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'OPCA') — {{ config('app.name', 'OPCA') }}</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50:  '#FFF8F5',
                            100: '#FDE8EA',
                            200: '#F8CFD4',
                            500: '#DF687C',
                            600: '#D6546A',
                            700: '#BD3F55',
                            800: '#2F4B7C',
                            900: '#2B2B33',
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

    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Inter', ui-sans-serif, system-ui, sans-serif; }
    </style>

    @stack('styles')
</head>
<body class="h-full bg-brand-50 text-brand-900 antialiased flex flex-col min-h-screen">

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

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js" defer></script>

    @stack('scripts')
</body>
</html>
