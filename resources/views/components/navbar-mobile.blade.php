<nav class="fixed bottom-0 left-0 w-full bg-white border-t-2 border-[#FF3EA5] z-50 lg:hidden pb-safe" x-data="{ openMenu: null }">
    <div class="flex justify-around items-center h-16 px-2 relative">
        
        @php
            $dashboardRoute = 'dashboard';
            if(auth()->user()->role === 'admin') $dashboardRoute = 'admin.dashboard';
            elseif(auth()->user()->role === 'dokter') $dashboardRoute = 'dokter.dashboard';

            $isHomeActive = request()->routeIs('dashboard') || request()->routeIs('admin.dashboard') || request()->routeIs('dokter.dashboard');
        @endphp

        {{-- 1. MENU: HOME --}}
        <a href="{{ route($dashboardRoute) }}" 
           @click="openMenu = null"
           class="flex flex-col items-center justify-center w-full h-12 space-y-0.5 rounded-lg border-2 transition-all duration-200
           {{ $isHomeActive 
                ? 'bg-[#FF3EA5] border-[#FF3EA5] shadow-[2px_2px_0px_0px_#ff90c8]' 
                : 'border-transparent text-[#FF3EA5] hover:bg-pink-50' 
           }}">
            <svg class="w-5 h-5 stroke-[2.5px] {{ $isHomeActive ? 'text-white' : 'text-[#FF3EA5]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
            </svg>
            <span class="text-[9px] font-black uppercase tracking-wide {{ $isHomeActive ? 'text-white' : 'text-[#FF3EA5]' }}">Home</span>
        </a>

        {{-- 2. MENU KONDISIONAL --}}
        
        {{-- === ROLE: MAMA === --}}
        @if(auth()->user()->role === 'mama')
            
            {{-- ... (CODE MENU DOKTER/REKAP UNTUK MAMA TETAP SAMA SEPERTI SEBELUMNYA) ... --}}
            {{-- Saya persingkat bagian Mama agar fokus ke Dokter --}}
             @php 
                $isDoctorActive = request()->routeIs('mama.tanya-dokter*') || request()->routeIs('mama.reservasi*'); 
            @endphp
            <div class="relative w-full flex justify-center">
                <div x-show="openMenu === 'dokter'" @click.away="openMenu = null" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-4 scale-95" x-transition:enter-end="opacity-100 translate-y-0 scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0 scale-100" x-transition:leave-end="opacity-0 translate-y-4 scale-95" class="absolute bottom-16 left-1/2 -translate-x-1/2 w-48 bg-white border-2 border-[#FF3EA5] rounded-xl shadow-[4px_4px_0px_0px_#ff90c8] p-2 flex flex-col gap-1 z-50" style="display: none;">
                    <a href="{{ route('mama.reservasi') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-pink-50 text-[#FF3EA5]"><svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg><span class="text-xs font-black uppercase">Reservasi</span></a>
                    <div class="h-0.5 bg-pink-100 w-full"></div>
                    <a href="{{ Route::has('mama.tanya-dokter') ? route('mama.tanya-dokter') : '#' }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-pink-50 text-[#FF3EA5]"><svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg><span class="text-xs font-black uppercase">Chat</span></a>
                </div>
                <button @click="openMenu = (openMenu === 'dokter' ? null : 'dokter')" class="flex flex-col items-center justify-center w-full h-12 space-y-0.5 rounded-lg border-2 transition-all duration-200 {{ $isDoctorActive || request()->routeIs('mama.tanya-dokter*') ? 'bg-[#FF3EA5] border-[#FF3EA5] shadow-[2px_2px_0px_0px_#ff90c8]' : 'border-transparent text-[#FF3EA5] hover:bg-pink-50' }}">
                    <svg class="w-5 h-5 stroke-[2.5px] {{ $isDoctorActive ? 'text-white' : 'text-[#FF3EA5]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg><span class="text-[9px] font-black uppercase tracking-wide {{ $isDoctorActive ? 'text-white' : 'text-[#FF3EA5]' }}">Dokter</span>
                </button>
            </div>
            {{-- Menu Rekap Mama --}}
             @php $isRekapActive = request()->routeIs('mama.rekap-data*'); @endphp
            <a href="{{ route('mama.rekap-data') }}" @click="openMenu = null" class="flex flex-col items-center justify-center w-full h-12 space-y-0.5 rounded-lg border-2 transition-all duration-200 {{ $isRekapActive ? 'bg-[#FF3EA5] border-[#FF3EA5] shadow-[2px_2px_0px_0px_#ff90c8]' : 'border-transparent text-[#FF3EA5] hover:bg-pink-50' }}">
                <svg class="w-5 h-5 stroke-[2.5px] {{ $isRekapActive ? 'text-white' : 'text-[#FF3EA5]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg><span class="text-[9px] font-black uppercase tracking-wide {{ $isRekapActive ? 'text-white' : 'text-[#FF3EA5]' }}">Rekap</span>
            </a>

        {{-- === ROLE: DOKTER === --}}
        @elseif(auth()->user()->role === 'dokter')
            
            {{-- 1. TOMBOL TRIGGER MENU PASIEN (Sudah Ada) --}}
            @php 
                $isPasienActive = request()->routeIs('dokter.reservasi.*') || request()->routeIs('dokter.chat.*');
            @endphp
            <div class="relative w-full flex justify-center">
                {{-- Drop-Up Menu Pasien --}}
                <div x-show="openMenu === 'pasien'" 
                     @click.away="openMenu = null"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 translate-y-4 scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 scale-95"
                     class="absolute bottom-16 left-1/2 -translate-x-1/2 w-48 bg-white border-2 border-[#FF3EA5] rounded-xl shadow-[4px_4px_0px_0px_#ff90c8] p-2 flex flex-col gap-1 z-50"
                     style="display: none;">
                    
                    <a href="{{ route('dokter.reservasi.index') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-pink-50 text-[#FF3EA5]">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        <span class="text-xs font-black uppercase">List Pasien</span>
                    </a>
                    <div class="h-0.5 bg-pink-100 w-full"></div>
                    <a href="{{ Route::has('dokter.chat.index') ? route('dokter.chat.index') : '#' }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-pink-50 text-[#FF3EA5]">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                        <span class="text-xs font-black uppercase">Jawab Chat</span>
                    </a>
                </div>

                <button @click="openMenu = (openMenu === 'pasien' ? null : 'pasien')"
                        class="flex flex-col items-center justify-center w-full h-12 space-y-0.5 rounded-lg border-2 transition-all duration-200
                        {{ $isPasienActive 
                            ? 'bg-[#FF3EA5] border-[#FF3EA5] shadow-[2px_2px_0px_0px_#ff90c8]' 
                            : 'border-transparent text-[#FF3EA5] hover:bg-pink-50' 
                        }}">
                    <svg class="w-5 h-5 stroke-[2.5px] {{ $isPasienActive ? 'text-white' : 'text-[#FF3EA5]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <span class="text-[9px] font-black uppercase tracking-wide {{ $isPasienActive ? 'text-white' : 'text-[#FF3EA5]' }}">Pasien</span>
                </button>
            </div>

            {{-- 2. TOMBOL TRIGGER MENU ARTIKEL (BARU DITAMBAHKAN UNTUK DOKTER) --}}
            @php 
                // Sesuaikan route name untuk 'kelola' artikel jika berbeda
                // Misal: dokter.artikel.index atau dokter.artikel.manage
                $isArtikelDokterActive = request()->routeIs('dokter.artikel.*') || request()->routeIs('artikel.index');
            @endphp
            <div class="relative w-full flex justify-center">
                
                {{-- Drop-Up Menu Artikel --}}
                <div x-show="openMenu === 'artikel_dokter'" 
                     @click.away="openMenu = null"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 translate-y-4 scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 scale-95"
                     class="absolute bottom-16 left-1/2 -translate-x-1/2 w-48 bg-white border-2 border-[#FF3EA5] rounded-xl shadow-[4px_4px_0px_0px_#ff90c8] p-2 flex flex-col gap-1 z-50"
                     style="display: none;">
                    
                    {{-- Sub 1: Kelola Artikel --}}
                    {{-- Pastikan ganti route('dokter.artikel.index') sesuai route Anda --}}
                    <a href="{{ Route::has('dokter.kelola-artikel.index') ? route('dokter.kelola-artikel.index') : '#' }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-pink-50 text-[#FF3EA5]">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        <span class="text-xs font-black uppercase">Kelola</span>
                    </a>
                    
                    <div class="h-0.5 bg-pink-100 w-full"></div>

                    {{-- Sub 2: Lihat Artikel --}}
                    <a href="{{ route('artikel.index') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-pink-50 text-[#FF3EA5]">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        <span class="text-xs font-black uppercase">Lihat</span>
                    </a>
                </div>

                {{-- Trigger Button --}}
                <button @click="openMenu = (openMenu === 'artikel_dokter' ? null : 'artikel_dokter')"
                        class="flex flex-col items-center justify-center w-full h-12 space-y-0.5 rounded-lg border-2 transition-all duration-200
                        {{ $isArtikelDokterActive 
                            ? 'bg-[#FF3EA5] border-[#FF3EA5] shadow-[2px_2px_0px_0px_#ff90c8]' 
                            : 'border-transparent text-[#FF3EA5] hover:bg-pink-50' 
                        }}">
                    <svg class="w-5 h-5 stroke-[2.5px] {{ $isArtikelDokterActive ? 'text-white' : 'text-[#FF3EA5]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                    </svg>
                    <span class="text-[9px] font-black uppercase tracking-wide {{ $isArtikelDokterActive ? 'text-white' : 'text-[#FF3EA5]' }}">Artikel</span>
                </button>
            </div>

        {{-- === ROLE: ADMIN === --}}
        @elseif(auth()->user()->role === 'admin')
            <a href="{{ route('admin.dashboard') }}" 
               @click="openMenu = null"
               class="flex flex-col items-center justify-center w-full h-12 space-y-0.5 rounded-lg border-transparent text-[#FF3EA5] hover:bg-pink-50">
                <svg class="w-5 h-5 stroke-[2.5px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <span class="text-[9px] font-black uppercase tracking-wide">Users</span>
            </a>
        @endif

        {{-- 3. MENU: SETTINGS (UMUM) --}}
        @php $isProfileActive = request()->routeIs('profile.edit'); @endphp
        <a href="{{ route('profile.edit') }}" 
           @click="openMenu = null"
           class="flex flex-col items-center justify-center w-full h-12 space-y-0.5 rounded-lg border-2 transition-all duration-200
           {{ $isProfileActive 
                ? 'bg-[#FF3EA5] border-[#FF3EA5] shadow-[2px_2px_0px_0px_#ff90c8]' 
                : 'border-transparent text-[#FF3EA5] hover:bg-pink-50' 
           }}">
            <svg class="w-5 h-5 stroke-[2.5px] {{ $isProfileActive ? 'text-white' : 'text-[#FF3EA5]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
            </svg>
            <span class="text-[9px] font-black uppercase tracking-wide {{ $isProfileActive ? 'text-white' : 'text-[#FF3EA5]' }}">Settings</span>
        </a>
        
        {{-- MENU: ARTIKEL (UMUM / SELAIN DOKTER) --}}
        {{-- Tambahkan pengecekan if role != dokter agar tidak double --}}
        @if(auth()->user()->role !== 'dokter')
            @php $isArtikelActive = request()->routeIs('artikel.index'); @endphp
            <a href="{{ route('artikel.index') }}" 
               @click="openMenu = null"
               class="flex flex-col items-center justify-center w-full h-12 space-y-0.5 rounded-lg border-2 transition-all duration-200
               {{ $isArtikelActive 
                    ? 'bg-[#FF3EA5] border-[#FF3EA5] shadow-[2px_2px_0px_0px_#ff90c8]' 
                    : 'border-transparent text-[#FF3EA5] hover:bg-pink-50' 
               }}">
                <svg class="w-5 h-5 stroke-[2.5px] {{ $isArtikelActive ? 'text-white' : 'text-[#FF3EA5]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                </svg>
                <span class="text-[9px] font-black uppercase tracking-wide {{ $isArtikelActive ? 'text-white' : 'text-[#FF3EA5]' }}">Artikel</span>
            </a>
        @endif
    </div>
</nav>