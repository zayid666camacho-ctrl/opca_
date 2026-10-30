{{--
    OPCA — Solicitud de Recuperación de Contraseña por Correo
--}}
<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña — {{ config('app.name', 'OPCA') }}</title>

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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="min-h-screen relative flex items-center bg-brand-900 text-white antialiased overflow-x-hidden">

    <img 
        src="{{ asset('img/servicios-maquina.jpg') }}" 
        alt="" 
        class="fixed inset-0 w-full h-full object-cover object-center opacity-35 pointer-events-none select-none">

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

        <div class="max-w-md bg-brand-900/60 backdrop-blur-md border border-white/15 rounded-2xl p-6 sm:p-8 shadow-2xl">
            <h1 class="text-2xl font-extrabold text-white">Recuperar Contraseña</h1>
            <p class="text-sm text-slate-300 mt-1.5 mb-6 leading-relaxed">
                Ingresa el correo electrónico de tu cuenta administrativa y te enviaremos un enlace seguro para restablecer tu contraseña.
            </p>

            @if (session('status'))
                <div class="mb-5 rounded-lg bg-emerald-500/20 border border-emerald-400/40 px-4 py-3 text-xs font-semibold text-emerald-200">
                    {{ session('status') }}
                </div>
            @endif

            <form action="{{ route('password.email') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-bold text-white mb-1.5">
                        Correo electrónico registrado:
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

                <div class="pt-2 flex flex-wrap items-center gap-3">
                    <button 
                        type="submit" 
                        class="px-6 py-3 rounded-lg bg-brand-600 hover:bg-brand-700 text-white font-bold text-sm shadow-lg transition-all cursor-pointer">
                        Enviar enlace al correo
                    </button>

                    <a 
                        href="{{ route('login') }}" 
                        class="px-5 py-3 rounded-lg border border-brand-500/80 text-brand-100 hover:bg-brand-600/20 hover:border-brand-200 font-semibold text-sm transition-all">
                        &larr; Volver al login
                    </a>
                </div>
            </form>
        </div>

    </main>

</body>
</html>
