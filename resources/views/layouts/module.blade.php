{{--
    OPCA — Layout de Módulos del Panel (sin Sidebar)
    Estética arquitectónica y profesional:
    - Fondos y bordes neutros limpios (#F4F5F7, #EEF0F4, #E2E8F0) para tablas, tarjetas e inputs.
    - Colores de marca reservados para autoridad y acciones: Carbón (#2B2B33), Rosa coral (#D6546A), Azul marino (#2F4B7C) y Dorado (#C9A24B).
--}}
<!DOCTYPE html>
<html lang="es" class="h-full bg-[#F4F5F7]">
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
                            50:  '#F8FAFC', // Gris perla neutro muy limpio para fondos suaves
                            100: '#F1F5F9', // Gris neutro para cabeceras de tabla y hovers
                            200: '#E2E8F0', // Borde neutro arquitectónico (sin tinte rosado)
                            500: '#DF687C',
                            600: '#D6546A', // Acento principal (botones y acciones primarias)
                            700: '#BD3F55', // Hover de botones primarios
                            800: '#2F4B7C', // Azul profundo corporativo
                            900: '#2B2B33', // Carbón oscuro para textos y encabezados
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
                            50:  '#F8FAFC',
                            100: '#F1F5F9',
                            200: '#E2E8F0',
                            300: '#CBD5E1',
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
<body class="h-full bg-[#F4F5F7] text-brand-900 antialiased flex flex-col min-h-screen">

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
