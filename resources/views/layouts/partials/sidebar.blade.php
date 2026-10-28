{{--
    OPCA — Sidebar principal del Panel de Administración.
    - Enfoque operativo limpio: los 5 módulos principales arriba + acceso rápido a Clientes, Historial de Pedidos y Configuración.
    - Los módulos de uso esporádico o técnico (Precios Base, Seguridad, etc.) viven dentro de Configuración.
--}}
<aside
    x-cloak
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
    class="fixed inset-y-0 left-0 z-40 w-64 bg-brand-900 text-white border-r border-white/10 transform transition-transform duration-200 ease-in-out lg:translate-x-0 shadow-xl"
    aria-label="Menú principal">

    <div class="h-full flex flex-col">

        {{-- Logo del software OPCA + taller activo --}}
        <div class="flex items-center gap-3 h-16 px-5 border-b border-white/10">
            <img src="{{ asset('img/logo-opca.png') }}" alt="Logo OPCA" class="h-10 w-10 object-contain drop-shadow">
            <div class="leading-tight min-w-0">
                <span class="text-white font-extrabold text-lg tracking-tight block">
                    OPCA
                </span>
                <span class="text-[11px] text-gold-500 font-semibold truncate block">
                    Creaciones Nayja
                </span>
            </div>
        </div>

        {{-- Navegación principal (los 5 módulos clave del taller) --}}
        <nav class="flex-1 overflow-y-auto px-3 py-5 space-y-6"
            aria-label="Navegación lateral">

            @php
                $principales = [
                    ['label' => 'Calendario',        'route' => 'calendario.index', 'icon' => 'calendar'],
                    ['label' => 'Kanban de Pedidos', 'route' => 'pedidos.kanban',   'icon' => 'chart'],
                    ['label' => 'Finanzas',          'route' => 'finanzas.index',   'icon' => 'tag'],
                    ['label' => 'Inventario',        'route' => 'inventario.index', 'icon' => 'box'],
                    ['label' => 'Galería',           'route' => 'galeria.index',    'icon' => 'eye'],
                ];

                $accesos_rapidos = [
                    ['label' => 'Clientes y Medidas',  'route' => 'clientes.index',      'icon' => 'users'],
                    ['label' => 'Lista de Pedidos',    'route' => 'pedidos.index',       'icon' => 'search'],
                    ['label' => 'Configuración y Más', 'route' => 'configuracion.index', 'icon' => 'cog'],
                ];
            @endphp

            {{-- Bloque 1: Gestión Diaria --}}
            <div class="space-y-1">
                <span class="px-3.5 text-[10px] font-bold uppercase tracking-widest text-slate-400">
                    Gestión Principal
                </span>

                @foreach ($principales as $link)
                    @php
                        $active = Route::has($link['route']) && request()->routeIs($link['route']);
                    @endphp

                    <a
                        href="{{ Route::has($link['route']) ? route($link['route']) : '#' }}"
                        @if($active) aria-current="page" @endif
                        class="group flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all
                            {{ $active
                                ? 'bg-brand-600 text-white font-semibold shadow-sm'
                                : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">

                        <span class="w-5 h-5 flex-shrink-0 {{ $active ? 'text-white' : 'text-slate-400 group-hover:text-brand-200' }}" aria-hidden="true">
                            @include('layouts.partials.icons', ['icon' => $link['icon']])
                        </span>

                        <span>{{ $link['label'] }}</span>
                    </a>
                @endforeach
            </div>

            {{-- Bloque 2: Consultas y Configuración --}}
            <div class="space-y-1 pt-3 border-t border-white/10">
                <span class="px-3.5 text-[10px] font-bold uppercase tracking-widest text-slate-400">
                    Directorio y Ajustes
                </span>

                @foreach ($accesos_rapidos as $link)
                    @php
                        $active = Route::has($link['route']) && request()->routeIs($link['route']);
                    @endphp

                    <a
                        href="{{ Route::has($link['route']) ? route($link['route']) : '#' }}"
                        @if($active) aria-current="page" @endif
                        class="group flex items-center gap-3 px-3.5 py-2 rounded-xl text-xs font-medium transition-all
                            {{ $active
                                ? 'bg-brand-600 text-white font-semibold shadow-sm'
                                : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">

                        <span class="w-4 h-4 flex-shrink-0 {{ $active ? 'text-white' : 'text-slate-400 group-hover:text-brand-200' }}" aria-hidden="true">
                            @include('layouts.partials.icons', ['icon' => $link['icon']])
                        </span>

                        <span>{{ $link['label'] }}</span>
                    </a>
                @endforeach
            </div>

        </nav>

        {{-- Pie del Sidebar: Sitio público + Cerrar sesión --}}
        <div class="px-3 py-4 border-t border-white/10 space-y-1">
            <a href="{{ route('sitio.index') }}"
                class="w-full flex items-center gap-3 px-3.5 py-2 rounded-xl text-xs font-medium text-slate-300 hover:bg-white/10 hover:text-white transition-colors">
                <span class="w-4 h-4 text-gold-500">
                    @include('layouts.partials.icons', ['icon' => 'home'])
                </span>
                Ver sitio público
            </a>

            <form method="POST"
                action="{{ Route::has('logout') ? route('logout') : '#' }}">
                @csrf

                <button
                    type="submit"
                    class="w-full flex items-center gap-3 px-3.5 py-2 rounded-xl text-xs font-medium text-slate-300 hover:bg-brand-600/20 hover:text-brand-200 transition-colors focus:outline-none cursor-pointer"
                    aria-label="Cerrar sesión">

                    <svg class="w-4 h-4 text-brand-500" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>

                    Cerrar sesión
                </button>
            </form>
        </div>
    </div>
</aside>
