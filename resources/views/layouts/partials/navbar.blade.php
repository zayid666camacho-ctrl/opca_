{{--
    OPCA — Barra Superior Unificada del Panel (Navbar)
    - Sin sidebar lateral: toda la navegación principal vive en el Hub superior del Calendario y en esta barra.
--}}
<header class="sticky top-0 z-30 bg-brand-900 border-b border-white/10 text-white shadow-sm">
    <div class="max-w-7xl mx-auto h-16 px-4 sm:px-6 lg:px-8 flex items-center justify-between gap-4">

        {{-- Izquierda: Emblema OPCA + Título de la pantalla --}}
        <div class="flex items-center gap-3 min-w-0">
            <a href="{{ route('calendario.index') }}" class="flex items-center gap-2.5 group shrink-0" title="Ir al Panel Principal y Calendario">
                <img src="{{ asset('img/logo-opca.png') }}" alt="OPCA" class="h-10 w-10 object-contain drop-shadow group-hover:scale-105 transition-transform">
                <div class="hidden sm:block leading-tight pr-2 border-r border-white/15">
                    <span class="font-extrabold text-base tracking-tight text-white block">OPCA</span>
                    <span class="text-[10px] text-gold-500 font-semibold block">Creaciones Nayja</span>
                </div>
            </a>

            <h1 class="text-base sm:text-lg font-bold text-slate-100 truncate">
                @yield('page-title', 'Panel de Administración')
            </h1>
        </div>

        {{-- Derecha: Accesos rápidos + Volver/Inicio + Usuario --}}
        <div class="flex items-center gap-2 sm:gap-3">

            @yield('header-actions')

            {{-- Si NO estamos en el Calendario, mostramos los botones Volver y Panel Principal --}}
            @if (!request()->routeIs('calendario.index'))
                @if (request()->routeIs('*create*', '*edit*', '*show*', 'pedidos.nuevo'))
                    <button onclick="window.history.back()"
                        type="button"
                        class="flex items-center gap-1.5 px-3.5 py-2 rounded-lg bg-white/10 border border-white/15 text-white hover:bg-white/20 font-semibold text-xs transition cursor-pointer">
                        <svg class="w-4 h-4 text-brand-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Volver
                    </button>
                @endif

                <a href="{{ route('calendario.index') }}"
                    class="flex items-center gap-1.5 px-3.5 py-2 rounded-lg bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs transition shadow-sm">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <span>Panel y Calendario</span>
                </a>
            @else
                {{-- En el Calendario, accesos directos discretos a las vistas de consulta y precios --}}
                <div class="hidden lg:flex items-center gap-1.5">
                    <a href="{{ route('clientes.index') }}" class="px-3 py-1.5 rounded-lg bg-white/5 hover:bg-white/15 text-xs font-medium text-slate-200 transition">
                        Clientes
                    </a>
                    <a href="{{ route('pedidos.index') }}" class="px-3 py-1.5 rounded-lg bg-white/5 hover:bg-white/15 text-xs font-medium text-slate-200 transition">
                        Historial Pedidos
                    </a>
                    <a href="{{ route('precio_bases.index') }}" class="px-3 py-1.5 rounded-lg bg-white/5 hover:bg-white/15 text-xs font-medium text-slate-200 transition">
                        Precios Base
                    </a>
                </div>

                <a href="{{ route('pedidos.nuevo') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-lg bg-brand-600 hover:bg-brand-700 text-white text-xs font-bold shadow-sm transition-colors">
                    + Nuevo Pedido
                </a>
            @endif

            {{-- Menú desplegable de la Administradora (siempre visible) --}}
            <div x-data="{ open: false }" class="relative">
                <button
                    @click="open = !open"
                    @click.outside="open = false"
                    type="button"
                    class="flex items-center gap-2 pl-2 pr-2.5 py-1.5 rounded-lg hover:bg-white/10 focus:outline-none cursor-pointer"
                    aria-haspopup="true"
                    :aria-expanded="open.toString()"
                >
                    <img
                        class="w-8 h-8 rounded-full object-cover ring-2 ring-gold-500/60"
                        src="{{ asset('img/logo-nayja.jpg') }}"
                        alt="Avatar de {{ auth()->user()->name ?? 'Administradora' }}"
                    >
                    <span class="hidden md:block text-xs font-semibold text-slate-100">
                        {{ auth()->user()->name ?? 'Administradora' }}
                    </span>
                    <span class="w-4 h-4 text-slate-400 hidden sm:block">@include('layouts.partials.icons', ['icon' => 'chevron-down'])</span>
                </button>

                <div
                    x-show="open" x-cloak
                    x-transition
                    class="absolute right-0 mt-2 w-56 bg-brand-900 rounded-xl shadow-2xl border border-white/15 overflow-hidden py-1.5 z-50"
                >
                    <a href="{{ route('calendario.index') }}" class="block px-4 py-2 text-xs font-medium text-slate-200 hover:bg-white/10 hover:text-white">
                        📅 Panel y Calendario
                    </a>
                    <a href="{{ route('clientes.index') }}" class="block px-4 py-2 text-xs font-medium text-slate-200 hover:bg-white/10 hover:text-white">
                        👥 Clientes y Medidas
                    </a>
                    <a href="{{ route('pedidos.index') }}" class="block px-4 py-2 text-xs font-medium text-slate-200 hover:bg-white/10 hover:text-white">
                        📋 Historial de Pedidos
                    </a>
                    <a href="{{ route('precio_bases.index') }}" class="block px-4 py-2 text-xs font-medium text-slate-200 hover:bg-white/10 hover:text-white">
                        🏷️ Catálogo de Precios Base
                    </a>
                    <a href="{{ route('configuracion.index') }}" class="block px-4 py-2 text-xs font-medium text-slate-200 hover:bg-white/10 hover:text-white">
                        ⚙️ Centro de Configuración
                    </a>
                    <a href="{{ route('sitio.index') }}" class="block px-4 py-2 text-xs font-medium text-gold-500 hover:bg-white/10">
                        🌐 Ver Sitio Público
                    </a>
                    <hr class="my-1 border-white/10">
                    <form method="POST" action="{{ Route::has('logout') ? route('logout') : '#' }}">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 text-xs font-semibold text-brand-200 hover:bg-brand-600/20 hover:text-white cursor-pointer">
                            Cerrar sesión
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</header>
