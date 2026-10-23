
<header class="sticky top-0 z-20 bg-neutral-700 border-b border-neutral-800 text-white">
    <div class="h-16 px-4 sm:px-6 lg:px-8 flex items-center justify-between gap-4">

        <div class="flex items-center gap-4 min-w-0">
            @if (request()->routeIs('sitio.index'))
                <button
                    @click="sidebarOpen = !sidebarOpen"
                    type="button"
                    class="lg:hidden p-2 rounded-lg text-neutral-300 hover:bg-neutral-800 hover:text-white focus:outline-none focus:ring-2 focus:ring-blue-300"
                    aria-label="Abrir menú lateral"
                >
                    <span class="w-6 h-6 block">@include('layouts.partials.icons', ['icon' => 'menu'])</span>
                </button>
            @endif

            <h1 class="text-lg sm:text-xl font-semibold text-white truncate">
                @yield('page-title', 'Dashboard')
            </h1>
        </div>

        <div class="flex items-center gap-2 sm:gap-4">

            @if (request()->routeIs('dashboard.index') || request()->routeIs('calendario.index') || request()->routeIs('pedidos.kanban'))

                {{-- Notificaciones --}}
                <div x-data="{ open: false }" class="relative">
                    <button
                        @click="open = !open"
                        @click.outside="open = false"
                        type="button"
                        class="relative p-2 rounded-lg text-neutral-300 hover:bg-neutral-800 hover:text-white focus:outline-none focus:ring-2 focus:ring-blue-300"
                        aria-label="Ver notificaciones"
                    >
                        <span class="w-5 h-5 block">@include('layouts.partials.icons', ['icon' => 'bell'])</span>
                        <span class="absolute top-1.5 right-1.5 w-2 h-2 rounded-full bg-rose-400 ring-2 ring-neutral-900"></span>
                    </button>

                    <div
                        x-show="open" x-cloak
                        x-transition
                        class="absolute right-0 mt-2 w-80 bg-neutral-800 rounded-xl shadow-lg border border-neutral-700 overflow-hidden"
                    >
                        <div class="px-4 py-3 border-b border-neutral-700 font-semibold text-sm text-white">
                            Notificaciones
                        </div>
                        <ul class="max-h-72 overflow-y-auto divide-y divide-neutral-700">
                            @forelse (($notifications ?? []) as $notification)
                                <li class="px-4 py-3 text-sm hover:bg-neutral-700">
                                    <p class="text-neutral-100">{{ $notification['message'] }}</p>
                                    <p class="text-xs text-neutral-400 mt-1">{{ $notification['time'] }}</p>
                                </li>
                            @empty
                                <li class="px-4 py-6 text-sm text-neutral-400 text-center">Sin notificaciones nuevas</li>
                            @endforelse
                        </ul>
                    </div>
                </div>

                {{-- Menú de usuario --}}
                <div x-data="{ open: false }" class="relative">
                    <button
                        @click="open = !open"
                        @click.outside="open = false"
                        type="button"
                        class="flex items-center gap-2 pl-1 pr-2 py-1 rounded-lg hover:bg-neutral-800 focus:outline-none focus:ring-2 focus:ring-blue-300"
                        aria-haspopup="true"
                        :aria-expanded="open.toString()"
                    >
                        <img
                            class="w-8 h-8 rounded-full object-cover ring-1 ring-neutral-600"
                            src="{{ auth()->user()->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name ?? 'Admin') }}"
                            alt="Avatar de {{ auth()->user()->name ?? 'Usuario' }}"
                        >
                        <span class="hidden sm:block text-sm font-medium text-neutral-100">
                            {{ auth()->user()->name ?? 'Administrador' }}
                        </span>
                        <span class="w-4 h-4 text-neutral-400 hidden sm:block">@include('layouts.partials.icons', ['icon' => 'chevron-down'])</span>
                    </button>

                    <div
                        x-show="open" x-cloak
                        x-transition
                        class="absolute right-0 mt-2 w-52 bg-neutral-800 rounded-xl shadow-lg border border-neutral-700 overflow-hidden py-1"
                    >
                        <a href="{{ Route::has('profile.edit') ? route('profile.edit') : '#' }}" class="block px-4 py-2 text-sm text-neutral-200 hover:bg-neutral-700 hover:text-white">Mi perfil</a>
                        <a href="{{ Route::has('configuracion.index') ? route('configuracion.index') : '#' }}" class="block px-4 py-2 text-sm text-neutral-200 hover:bg-neutral-700 hover:text-white">Configuración</a>
                        <hr class="my-1 border-neutral-700">
                        <form method="POST" action="{{ Route::has('logout') ? route('logout') : '#' }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-rose-300 hover:bg-neutral-700 hover:text-rose-200">
                                Cerrar sesión
                            </button>
                        </form>
                    </div>
                </div>

            @else

                @yield('header-actions')

                <div class="flex items-center gap-2">

                    @if (request()->routeIs('*create*', '*edit*', '*show*'))
                        {{-- Muestra SOLO Volver en subvistas de creación, edición o detalle --}}
                        <button onclick="window.history.back()"
                            type="button"
                            class="flex items-center gap-2 px-4 py-2 rounded-lg bg-neutral-800 border border-neutral-700 text-white hover:bg-neutral-700 hover:border-neutral-600 font-semibold text-sm transition shadow-sm cursor-pointer">
                            <svg class="w-4 h-4 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Volver
                        </button>
                    @else
                        {{-- Muestra SOLO Inicio en las demás vistas principales --}}
                        <a href="{{ route('sitio.index') }}"
                            class="flex items-center gap-2 px-4 py-2 rounded-lg bg-neutral-800 border border-neutral-700 text-white hover:bg-neutral-700 hover:border-neutral-600 font-semibold text-sm transition shadow-sm">
                            <svg class="w-4 h-4 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            Inicio
                        </a>
                    @endif

                </div>

            @endif
        </div>
    </div>
</header>
