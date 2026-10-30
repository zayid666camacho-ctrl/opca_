{{--
    OPCA — Barra Superior Unificada del Panel (Navbar)
    - Sin redundancia de botones: los módulos viven en el Hub principal del Calendario.
    - Desplegable de la administradora: únicamente Perfil del Taller, Ver Sitio Público y Cerrar sesión.
--}}
<header class="sticky top-0 z-30 bg-brand-900 border-b border-white/10 text-white shadow-sm">
    <div class="max-w-7xl mx-auto h-16 px-4 sm:px-6 lg:px-8 flex items-center justify-between gap-4">

        {{-- Izquierda: Emblema OPCA + Título de la pantalla --}}
        <div class="flex items-center gap-3 min-w-0">
            <a href="{{ route('calendario.index') }}" class="flex items-center gap-2.5 group shrink-0" title="Ir al Panel Principal y Calendario">
                <img src="{{ asset('img/logo-opca.png') }}" alt="OPCA" class="h-10 w-10 object-contain drop-shadow group-hover:scale-105 transition-transform">
                <div class="hidden sm:block leading-tight pr-2.5 border-r border-white/15">
                    <span class="font-extrabold text-base tracking-tight text-white block">OPCA</span>
                    <span class="text-[10px] text-gold-500 font-semibold block">Creaciones Nayja</span>
                </div>
            </a>

            <h1 class="text-base sm:text-lg font-bold text-slate-100 truncate">
                @yield('page-title', 'Panel de Administración')
            </h1>
        </div>

        {{-- Derecha: Acción principal + Avatar de la Administradora --}}
        <div class="flex items-center gap-2.5 sm:gap-3">

            @yield('header-actions')

            @if (!request()->routeIs('calendario.index'))
                <a href="{{ route('calendario.index') }}"
                    class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-lg bg-brand-600 hover:bg-brand-700 text-white font-semibold text-xs transition shadow-xs">
                    <span class="w-4 h-4">@include('layouts.partials.icons', ['icon' => 'home'])</span>
                    <span>Panel y Calendario</span>
                </a>
            @else
                <a href="{{ route('pedidos.nuevo') }}"
                    class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg bg-brand-600 hover:bg-brand-700 text-white text-xs font-semibold shadow-xs transition-colors">
                    <span class="w-4 h-4">@include('layouts.partials.icons', ['icon' => 'plus-circle'])</span>
                    <span>Nuevo Pedido</span>
                </a>
            @endif

            {{-- Menú desplegable de la Administradora (Solo Perfil del Taller, Ver Sitio Público y Cerrar sesión) --}}
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
                        class="w-8 h-8 rounded-full object-cover ring-1 ring-gold-500/70"
                        src="{{ asset('img/logo-nayja.jpg') }}"
                        alt="Avatar de {{ auth()->user()->name ?? 'Administradora' }}"
                    >
                    <span class="hidden md:block text-xs font-semibold text-slate-100">
                        {{ auth()->user()->name ?? 'Administradora' }}
                    </span>
                    <span class="w-3.5 h-3.5 text-slate-400 hidden sm:block">@include('layouts.partials.icons', ['icon' => 'chevron-down'])</span>
                </button>

                <div
                    x-show="open" x-cloak
                    x-transition
                    class="absolute right-0 mt-2 w-56 bg-brand-900 rounded-lg shadow-2xl border border-white/15 overflow-hidden py-1.5 z-50"
                >
                    <a href="{{ route('taller.perfil') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-xs font-medium text-slate-200 hover:bg-white/10 hover:text-white transition-colors">
                        <span class="w-4 h-4 text-brand-500 shrink-0">@include('layouts.partials.icons', ['icon' => 'store'])</span>
                        <span>Perfil del Taller</span>
                    </a>

                    <a href="{{ route('sitio.index') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-xs font-medium text-slate-200 hover:bg-white/10 hover:text-white transition-colors">
                        <span class="w-4 h-4 text-gold-500 shrink-0">@include('layouts.partials.icons', ['icon' => 'eye'])</span>
                        <span>Ver Sitio Público</span>
                    </a>

                    <hr class="my-1 border-white/10">

                    <form method="POST" action="{{ Route::has('logout') ? route('logout') : '#' }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-2.5 text-left px-4 py-2.5 text-xs font-semibold text-brand-200 hover:bg-brand-600/20 hover:text-white cursor-pointer transition-colors">
                            <span>Cerrar sesión</span>
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</header>
