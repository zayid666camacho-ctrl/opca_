{{--
    OPCA — Vista de Inicio de Sesión (HU_01)
    Diseño editorial guiado por la composición del autor + Paleta A (Rosa coral #D6546A, Carbón #2B2B33, Crema #FFF8F5).
    - Fondo con ilustración de la máquina de coser del taller (public/img/servicios-maquina.jpg).
    - Solo inicio de sesión para la administradora (sin registro público).
--}}
<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accede a tu Cuenta NAyJA — {{ config('app.name', 'OPCA') }}</title>

    {{-- Tailwind CSS vía CDN --}}
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
                            600: '#D6546A', // Rosa coral principal
                            700: '#BD3F55',
                            800: '#2F4B7C',
                            900: '#2B2B33', // Carbón oscuro
                        },
                        gold: {
                            500: '#C9A24B',
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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="min-h-screen relative flex items-center bg-brand-900 text-white antialiased overflow-x-hidden">

    {{-- Imagen de fondo de la máquina de coser del taller --}}
    <img 
        src="{{ asset('img/servicios-maquina.jpg') }}" 
        alt="" 
        class="fixed inset-0 w-full h-full object-cover object-center opacity-35 pointer-events-none select-none">

    {{-- Superposición oscura cálida para contraste perfecto del texto --}}
    <div class="fixed inset-0 bg-gradient-to-r from-brand-900/95 via-brand-900/85 to-brand-900/75 pointer-events-none"></div>

    <main class="relative z-10 w-full max-w-5xl mx-auto px-6 sm:px-10 lg:px-12 py-14">

        {{-- Identidad superior: Software OPCA + Taller Creaciones Nayja --}}
        <div class="flex flex-wrap items-center gap-4 mb-8">
            <a href="{{ route('sitio.index') }}" class="inline-flex items-center gap-3 group">
                <img src="{{ asset('img/logo-opca.png') }}" alt="Logo OPCA" class="h-12 w-12 object-contain drop-shadow-md group-hover:scale-105 transition-transform">
                <div>
                    <span class="text-xl font-extrabold tracking-tight text-white block leading-tight">OPCA</span>
                    <span class="text-xs text-brand-200 font-medium">Gestión de Pedidos, Confecciones y Arreglos</span>
                </div>
            </a>
            <span class="hidden sm:inline-block h-7 w-px bg-white/20"></span>
            <div class="inline-flex items-center gap-2.5">
                <img src="{{ asset('img/logo-nayja.jpg') }}" alt="Logo Creaciones Nayja" class="w-9 h-9 rounded-full object-cover ring-1 ring-white/40">
                <div class="text-xs">
                    <span class="text-slate-300 block">Taller activo:</span>
                    <span class="font-bold text-white">Creaciones Nayja</span>
                </div>
            </div>
        </div>

        {{-- Título y subtítulo principal (igual a la composición guía) --}}
        <div class="max-w-3xl mb-10">
            <h1 class="text-3xl sm:text-5xl font-extrabold tracking-tight text-white leading-tight">
                Accede a tu Cuenta OPCA · NAyJA
            </h1>
            <p class="mt-4 text-sm sm:text-base text-slate-200 leading-relaxed">
                Gestiona tus pedidos, clientes, medidas, agenda e inventario con facilidad. Ingresa tus credenciales de administración para continuar al taller.
            </p>
        </div>

        {{-- Bloque de Iniciar Sesión --}}
        <div class="max-w-md bg-brand-900/60 backdrop-blur-md border border-white/15 rounded-2xl p-6 sm:p-8 shadow-2xl">
            <h2 class="text-2xl font-extrabold text-white">Iniciar Sesión</h2>
            <p class="text-sm text-slate-300 mt-1 mb-6">Ingresa tus credenciales para continuar:</p>

            <form action="{{ route('login.store') }}" method="POST" class="space-y-5">
                @csrf

                {{-- Correo electrónico --}}
                <div>
                    <label for="email" class="block text-sm font-bold text-white mb-1.5">
                        Correo electrónico:
                    </label>
                    <input 
                        type="email" 
                        name="email" 
                        id="email" 
                        value="{{ old('email') }}" 
                        required 
                        autofocus 
                        autocomplete="email"
                        placeholder="correo@creacionesnayja.com"
                        class="w-full rounded-lg bg-white/10 border {{ $errors->has('email') ? 'border-rose-400' : 'border-white/25' }} px-3.5 py-2.5 text-sm text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition">
                    @error('email')
                        <p class="mt-1.5 text-xs font-medium text-rose-300">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Contraseña --}}
                <div>
                    <label for="password" class="block text-sm font-bold text-white mb-1.5">
                        Contraseña:
                    </label>
                    <input 
                        type="password" 
                        name="password" 
                        id="password" 
                        required 
                        autocomplete="current-password"
                        placeholder="••••••••"
                        class="w-full rounded-lg bg-white/10 border {{ $errors->has('password') ? 'border-rose-400' : 'border-white/25' }} px-3.5 py-2.5 text-sm text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition">
                    @error('password')
                        <p class="mt-1.5 text-xs font-medium text-rose-300">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Recordarme --}}
                <label class="flex items-center gap-2.5 text-sm text-slate-200 cursor-pointer select-none">
                    <input type="checkbox" name="remember" value="1" class="rounded border-white/30 bg-white/10 text-brand-600 focus:ring-brand-500 h-4 w-4">
                    Recordar mi sesión en este equipo
                </label>

                {{-- Botones de acción (misma disposición que la imagen guía) --}}
                <div class="pt-2 flex flex-wrap items-center gap-3">
                    <button 
                        type="submit" 
                        class="px-7 py-3 rounded-lg bg-brand-600 hover:bg-brand-700 text-white font-bold text-sm shadow-lg transition-all cursor-pointer">
                        Acceder
                    </button>

                    <a 
                        href="{{ route('sitio.index') }}" 
                        class="px-5 py-3 rounded-lg border border-brand-500/80 text-brand-100 hover:bg-brand-600/20 hover:border-brand-200 font-semibold text-sm transition-all">
                        &larr; Volver al sitio
                    </a>
                </div>
            </form>
        </div>

    </main>

</body>
</html>
