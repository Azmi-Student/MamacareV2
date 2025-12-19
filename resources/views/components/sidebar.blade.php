<div class="flex flex-col h-full bg-white">

    {{-- 1. LOGO AREA --}}
    <div class="h-20 flex items-center justify-center lg:justify-start lg:px-6 shrink-0 mt-2">
        {{-- Redirect logo disesuaikan role --}}
        @php
            $dashboardRoute = 'dashboard';
            if (auth()->user()->role === 'admin') {
                $dashboardRoute = 'admin.dashboard';
            } elseif (auth()->user()->role === 'dokter') {
                $dashboardRoute = 'dokter.dashboard';
            }
        @endphp

        <a href="{{ route($dashboardRoute) }}" class="flex items-center gap-3 group">
            <div
                class="w-10 h-10 bg-[#FF3EA5] rounded-lg border-2 border-[#FF3EA5] flex items-center justify-center shadow-[3px_3px_0px_0px_#ff90c8] group-hover:translate-x-1 group-hover:shadow-none transition-all">
                <img src="{{ asset('images/logo-icon.png') }}" alt="Icon"
                    class="w-6 h-6 object-contain brightness-0 invert">
            </div>
            <span
                class="text-2xl font-black text-[#FF3EA5] hidden lg:block whitespace-nowrap tracking-tighter uppercase drop-shadow-sm">
                MamaCare
            </span>
        </a>
    </div>

    {{-- 2. NAVIGATION LINKS --}}
    <nav class="flex-1 overflow-y-auto py-4 px-4 space-y-3">

        {{-- LINK: DASHBOARD (Dynamic based on Role) --}}
        @php
            $isDashboardActive =
                request()->routeIs('dashboard') ||
                request()->routeIs('admin.dashboard') ||
                request()->routeIs('dokter.dashboard');
        @endphp

        <a href="{{ route($dashboardRoute) }}"
            class="flex items-center p-3 rounded-xl border-2 transition-all duration-200 justify-center lg:justify-start group
            {{ $isDashboardActive
                ? 'bg-[#FF3EA5] border-[#FF3EA5] shadow-[4px_4px_0px_0px_#ff90c8] -translate-y-1'
                : 'bg-white border-transparent text-[#FF3EA5] hover:border-[#FF3EA5] hover:shadow-[4px_4px_0px_0px_#FF3EA5] hover:-translate-y-1' }}">

            <svg class="w-6 h-6 shrink-0 stroke-[2.5px] {{ $isDashboardActive ? 'text-white' : 'text-[#FF3EA5]' }}"
                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
            </svg>

            <span
                class="ms-3 hidden lg:block font-black uppercase tracking-wide text-sm {{ $isDashboardActive ? 'text-white' : 'text-[#FF3EA5]' }}">
                Dashboard
            </span>
        </a>

        {{-- === MENU KHUSUS MAMA === --}}
        @if (auth()->user()->role === 'mama')
            {{-- LINK: TANYA DOKTER --}}
            @php
                // Cek apakah route saat ini adalah 'mama.tanya-dokter' atau sub-halamannya
                $isTanyaActive = request()->routeIs('mama.tanya-dokter*');
            @endphp
            <a href="{{ Route::has('mama.tanya-dokter.index') ? route('mama.tanya-dokter.index') : '#' }}"
                class="flex items-center p-3 rounded-xl border-2 transition-all duration-200 justify-center lg:justify-start group
                {{ $isTanyaActive
                    ? 'bg-[#FF3EA5] border-[#FF3EA5] shadow-[4px_4px_0px_0px_#ff90c8] -translate-y-1'
                    : 'bg-white border-transparent text-[#FF3EA5] hover:border-[#FF3EA5] hover:shadow-[4px_4px_0px_0px_#FF3EA5] hover:-translate-y-1' }}">

                <svg class="w-6 h-6 shrink-0 stroke-[2.5px] {{ $isTanyaActive ? 'text-white' : 'text-[#FF3EA5]' }}"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                </svg>

                <span
                    class="ms-3 hidden lg:block font-black uppercase tracking-wide text-sm {{ $isTanyaActive ? 'text-white' : 'text-[#FF3EA5]' }}">
                    Tanya Dokter
                </span>
            </a>

            {{-- LINK: REKAP DATA --}}
            @php
                $isRekapActive = request()->routeIs('mama.rekap-data*');
            @endphp
            <a href="{{ Route::has('mama.rekap-data') ? route('mama.rekap-data') : '#' }}"
                class="flex items-center p-3 rounded-xl border-2 transition-all duration-200 justify-center lg:justify-start group
                {{ $isRekapActive
                    ? 'bg-[#FF3EA5] border-[#FF3EA5] shadow-[4px_4px_0px_0px_#ff90c8] -translate-y-1'
                    : 'bg-white border-transparent text-[#FF3EA5] hover:border-[#FF3EA5] hover:shadow-[4px_4px_0px_0px_#FF3EA5] hover:-translate-y-1' }}">

                <svg class="w-6 h-6 shrink-0 stroke-[2.5px] {{ $isRekapActive ? 'text-white' : 'text-[#FF3EA5]' }}"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>

                <span
                    class="ms-3 hidden lg:block font-black uppercase tracking-wide text-sm {{ $isRekapActive ? 'text-white' : 'text-[#FF3EA5]' }}">
                    Rekap Data
                </span>
            </a>
        @endif

        {{-- === MENU KHUSUS DOKTER === --}}
        @if (auth()->user()->role === 'dokter')
            @php
                $isReservasiActive = request()->routeIs('dokter.reservasi.*');
            @endphp
            <a href="{{ route('dokter.reservasi.index') }}"
                class="flex items-center p-3 rounded-xl border-2 transition-all duration-200 justify-center lg:justify-start group
                {{ $isReservasiActive
                    ? 'bg-[#FF3EA5] border-[#FF3EA5] shadow-[4px_4px_0px_0px_#ff90c8] -translate-y-1'
                    : 'bg-white border-transparent text-[#FF3EA5] hover:border-[#FF3EA5] hover:shadow-[4px_4px_0px_0px_#FF3EA5] hover:-translate-y-1' }}">

                {{-- Icon Clipboard --}}
                <svg class="w-6 h-6 shrink-0 stroke-[2.5px] {{ $isReservasiActive ? 'text-white' : 'text-[#FF3EA5]' }}"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                </svg>

                <span
                    class="ms-3 hidden lg:block font-black uppercase tracking-wide text-sm {{ $isReservasiActive ? 'text-white' : 'text-[#FF3EA5]' }}">
                    Daftar Pasien
                </span>
            </a>
        @endif

        {{-- === MENU KHUSUS ADMIN === --}}
        @if (auth()->user()->role === 'admin')
            @php
                $isUserMgmtActive = request()->routeIs('admin.dashboard');
            @endphp
            <a href="{{ route('admin.dashboard') }}"
                class="flex items-center p-3 rounded-xl border-2 transition-all duration-200 justify-center lg:justify-start group
                {{ $isUserMgmtActive
                    ? 'bg-[#FF3EA5] border-[#FF3EA5] shadow-[4px_4px_0px_0px_#ff90c8] -translate-y-1'
                    : 'bg-white border-transparent text-[#FF3EA5] hover:border-[#FF3EA5] hover:shadow-[4px_4px_0px_0px_#FF3EA5] hover:-translate-y-1' }}">
                <svg class="w-6 h-6 shrink-0 stroke-[2.5px] {{ $isUserMgmtActive ? 'text-white' : 'text-[#FF3EA5]' }}"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <span
                    class="ms-3 hidden lg:block font-black uppercase tracking-wide text-sm {{ $isUserMgmtActive ? 'text-white' : 'text-[#FF3EA5]' }}">
                    Data Pengguna
                </span>
            </a>
        @endif

        {{-- LINK: SETTINGS (Semua Role) --}}
        <a href="{{ route('profile.edit') }}"
            class="flex items-center p-3 rounded-xl border-2 transition-all duration-200 justify-center lg:justify-start group
            {{ request()->routeIs('profile.edit')
                ? 'bg-[#FF3EA5] border-[#FF3EA5] shadow-[4px_4px_0px_0px_#ff90c8] -translate-y-1'
                : 'bg-white border-transparent text-[#FF3EA5] hover:border-[#FF3EA5] hover:shadow-[4px_4px_0px_0px_#FF3EA5] hover:-translate-y-1' }}">

            <svg class="w-6 h-6 shrink-0 stroke-[2.5px] {{ request()->routeIs('profile.edit') ? 'text-white' : 'text-[#FF3EA5]' }}"
                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>

            <span
                class="ms-3 hidden lg:block font-black uppercase tracking-wide text-sm {{ request()->routeIs('profile.edit') ? 'text-white' : 'text-[#FF3EA5]' }}">
                Settings
            </span>
        </a>

    </nav>

    {{-- 3. LOGOUT BUTTON AREA --}}
    <div class="p-4">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="w-full flex items-center p-3 rounded-xl border-2 border-transparent text-[#FF3EA5] hover:bg-pink-50 hover:border-[#FF3EA5] hover:shadow-[4px_4px_0px_0px_#FF3EA5] hover:-translate-y-1 transition-all duration-200 justify-center lg:justify-start group">
                <svg class="w-6 h-6 shrink-0 stroke-[2.5px] text-[#FF3EA5]" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                <span class="ms-3 hidden lg:block font-black uppercase tracking-wide text-sm text-[#FF3EA5]">
                    Keluar
                </span>
            </button>
        </form>
    </div>
</div>
