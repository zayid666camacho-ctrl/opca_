{{--
    OPCA — Formulario para Definir Nueva Contraseña (desde enlace del correo)
--}}
<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer Contraseña — {{ config('app.name', 'OPCA') }}</title>

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

        {{-- Identidad superior --}}
        <div class="flex flex-wrap items-center gap-4 mb-8">
            <a href="{{ route('sitio.index') }}" class="inline-flex items-center gap-3 group">
                <img src="{{ asset('img/logo-opca.png') }}" alt="Logo OPCA" class="h-12 w-12 object-contain drop-shadow-md group-hover:scale-105 transition-transform">
                <div>
                    <span class="text-xl font-extrabold tracking-tight text-white block leading-tight">OPCA</span>
                    <span class="text-xs text-brand-200 font-medium">Gestión de Pedidos, Confecciones y Arreglos</span>
                </div>
            </a>
        </div>

        <div class="max-w-md bg-brand-900/60 backdrop-blur-md border border-white/15 rounded-2xl p-6 sm:p-8 shadow-2xl">
            <h1 class="text-2xl font-extrabold text-white">Nueva Contraseña</h1>
            <p class="text-sm text-slate-300 mt-1.5 mb-6">
                Escribe y confirma tu nueva contraseña de acceso al taller.
            </p>

            <form action="{{ route('password.update') }}" method="POST" class="space-y-5">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                <div>
                    <label for="email" class="block text-sm font-bold text-white mb-1.5">
                        Correo electrónico:
                    </label>
                    <input 
                        type="email" 
                        name="email" 
                        id="email" 
                        value="{{ old('email', $email) }}" 
                        required 
                        autocomplete="email"
                        class="w-full rounded-lg bg-white/10 border {{ $errors->has('email') ? 'border-rose-400' : 'border-white/25' }} px-3.5 py-2.5 text-sm text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-brand-500">
                    @error('email')
                        <p class="mt-1.5 text-xs font-medium text-rose-300">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-bold text-white mb-1.5">
                        Nueva contraseña (mínimo 8 caracteres):
                    </label>
                    <input 
                        type="password" 
                        name="password" 
                        id="password" 
                        required 
                        autofocus
                        autocomplete="new-password"
                        placeholder="••••••••"
                        class="w-full rounded-lg bg-white/10 border {{ $errors->has('password') ? 'border-rose-400' : 'border-white/25' }} px-3.5 py-2.5 text-sm text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-brand-500">
                    @error('password')
                        <p class="mt-1.5 text-xs font-medium text-rose-300">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-bold text-white mb-1.5">
                        Confirmar nueva contraseña:
                    </label>
                    <input 
                        type="password" 
                        name="password_confirmation" 
                        id="password_confirmation" 
                        required 
                        autocomplete="new-password"
                        placeholder="••••••••"
                        class="w-full rounded-lg bg-white/10 border border-white/25 px-3.5 py-2.5 text-sm text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-brand-500">
                </div>

                <div class="pt-2">
                    <button 
                        type="submit" 
                        class="w-full px-6 py-3 rounded-lg bg-brand-600 hover:bg-brand-700 text-white font-bold text-sm shadow-lg transition-all cursor-pointer">
                        Guardar nueva contraseña
                    </button>
                </div>
            </form>
        </div>

    </main>

</body>
</html>
