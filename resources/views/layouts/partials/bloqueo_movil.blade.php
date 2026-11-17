{{--
    OPCA — Pantalla de Bloqueo en Dispositivos Móviles para Gestión Administrativa
    Se muestra únicamente en pantallas pequeñas (< 1024px / lg:hidden) cuando se intenta acceder al Login, Panel o Seguridad desde teléfono.
--}}
<div class="lg:hidden fixed inset-0 z-50 bg-[#2B2B33] text-white flex flex-col items-center justify-center p-6 text-center select-none">
    <div class="max-w-md w-full bg-white/[0.04] border border-white/15 rounded-2xl p-7 shadow-2xl backdrop-blur-md">
        <div class="flex items-center justify-center gap-3 mb-5">
            <img src="{{ asset('img/logo-opca.png') }}" alt="OPCA" class="h-11 w-11 object-contain drop-shadow">
            <span class="h-7 w-px bg-white/20"></span>
            <img src="{{ asset('img/logo-nayja.jpg') }}" alt="Creaciones Nayja" class="h-10 w-10 rounded-full object-cover ring-2 ring-[#C9A24B]/60">
        </div>

        <div class="w-12 h-12 mx-auto mb-4 rounded-xl bg-[#D6546A]/20 border border-[#D6546A]/50 text-[#D6546A] flex items-center justify-center">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25" />
            </svg>
        </div>

        <span class="text-[11px] font-bold uppercase tracking-widest text-[#C9A24B] block">
            Panel de Gestión OPCA
        </span>
        <h2 class="text-xl font-extrabold text-white mt-1">
            Acceso exclusivo desde computador
        </h2>

        <p class="mt-3 text-xs sm:text-sm text-slate-300 leading-relaxed">
            Para garantizar comodidad y precisión en el manejo del calendario, tablero Kanban, medidas corporales y finanzas del taller, el panel administrativo está habilitado únicamente en pantallas de computador o portátil.
        </p>

        <div class="mt-6 pt-5 border-t border-white/10">
            <a href="{{ route('sitio.index') }}"
               class="inline-flex items-center justify-center gap-2 w-full px-5 py-3 rounded-xl bg-[#D6546A] hover:bg-[#BD3F55] text-white font-bold text-xs sm:text-sm shadow-lg transition-colors">
                &larr; Volver al sitio público
            </a>
        </div>
    </div>
</div>
