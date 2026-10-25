
{{--
    Sidebar principal.
    Usa la ruta actual para resaltar el enlace activo.
--}}
<aside
    x-cloak
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
    class="fixed inset-y-0 left-0 z-40 w-64 bg-white text-neutral-900 border-r border-slate-500 transform transition-transform duration-200 ease-in-out lg:translate-x-0"
    aria-label="Menú principal">

    <div class="h-full flex flex-col">

        {{-- Logo --}}
        <div class="flex items-center gap-3 h-16 px-6 border-b border-slate-200">
            <div class="w-9 h-9 rounded-lg bg-blue-100 text-neutral-900 flex items-center justify-center font-bold">
                <span class="w-5 h-5 block">
                    @include('layouts.partials.icons', ['icon' => 'eye'])
                </span>
            </div>

            <span class="text-neutral-900 font-semibold text-lg tracking-tight">
                OPCA
            </span>
        </div>

        {{-- Navegación --}}
        <nav class="flex-1 overflow-y-auto px-3 py-6 space-y-1"
            aria-label="Navegación lateral">

            @php
                $links = [
                    ['label' => 'Publico',     'route' => 'sitio.index',     'icon' => 'home'],
                    ['label' => 'Calendario',    'route' => 'calendario.index',    'icon' => 'box'],
                    ['label' => 'Kanban',        'route' => 'pedidos.kanban',      'icon' => 'chart'],
                    ['label' => 'Pedidos',       'route' => 'pedidos.index',       'icon' => 'box'],
                    ['label' => 'Finanzas',      'route' => 'finanzas.index',      'icon' => 'shield'],
                    ['label' => 'Clientes',      'route' => 'clientes.index',      'icon' => 'users'],
                    ['label' => 'Servicios',     'route' => 'servicios.index',     'icon' => 'chart'],
                    ['label' => 'Precios base',  'route' => 'precio_bases.index',  'icon' => 'tag'],
                    ['label' => 'Tipo_servicio', 'route' => 'tipo_servicio.index', 'icon' => 'shield'],
                    ['label' => 'Inventario',    'route' => 'inventario.index',    'icon' => 'tag'],
                    ['label' => 'Trabajos',      'route' => 'galeria.index',       'icon' => 'chart'],
                    ['label' => 'Seguridad',      'route' => 'seguridad.permisos.index',       'icon' => 'chart'],

                    

                
                    ];
            @endphp

            @foreach ($links as $link)
                @php
                    $active = Route::has($link['route'])
                        && request()->routeIs(explode('.', $link['route'])[0] . '.*');
                @endphp

                <a
                    href="{{ Route::has($link['route']) ? route($link['route']) : '#' }}"
                    @if($active) aria-current="page" @endif
                    class="group flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                        {{ $active
                            ? 'bg-blue-100 text-neutral-900 shadow-sm'
                            : 'text-neutral-700 hover:bg-slate-100 hover:text-black' }}">

                    <span class="w-5 h-5 flex-shrink-0" aria-hidden="true">
                        @include('layouts.partials.icons', ['icon' => $link['icon']])
                    </span>

                    <span>{{ $link['label'] }}</span>
                </a>
            @endforeach
        </nav>

        {{-- Cerrar sesión --}}
        <div class="px-3 py-4 border-t border-slate-200">
            <form method="POST"
                action="{{ Route::has('logout') ? route('logout') : '#' }}">
                @csrf

                <button
                    type="submit"
                    class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-neutral-700 hover:bg-rose-50 hover:text-neutral-900 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-200"
                    aria-label="Cerrar sesión">

                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24"
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
