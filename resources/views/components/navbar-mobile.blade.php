<nav class="fixed bottom-0 left-0 w-full bg-white border-t-2 border-[#FF3EA5] z-50 lg:hidden pb-safe">
    <div class="flex justify-around items-center h-16 px-2">
        
        @php
            $dashboardRoute = 'dashboard';
            if(auth()->user()->role === 'admin') $dashboardRoute = 'admin.dashboard';
            elseif(auth()->user()->role === 'dokter') $dashboardRoute = 'dokter.dashboard';

            $isHomeActive = request()->routeIs('dashboard') || request()->routeIs('admin.dashboard') || request()->routeIs('dokter.dashboard');
        @endphp

        {{-- MENU: HOME --}}
        <a href="{{ route($dashboardRoute) }}" 
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

        {{-- MENU KONDISIONAL BERDASARKAN ROLE --}}
        @if(auth()->user()->role === 'mama')
            {{-- MENU: DOKTER (Link Kosong Dulu) --}}
            <a href="#" 
               class="flex flex-col items-center justify-center w-full h-12 space-y-0.5 rounded-lg border-2 border-transparent text-[#FF3EA5] opacity-50 cursor-not-allowed">
                <svg class="w-5 h-5 stroke-[2.5px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                </svg>
                <span class="text-[9px] font-black uppercase tracking-wide">Dokter</span>
            </a>

            {{-- MENU: REKAP DATA (SUDAH AKTIF) --}}
            @php $isRekapActive = request()->routeIs('mama.rekap-data*'); @endphp
            <a href="{{ route('mama.rekap-data') }}" 
               class="flex flex-col items-center justify-center w-full h-12 space-y-0.5 rounded-lg border-2 transition-all duration-200
               {{ $isRekapActive 
                    ? 'bg-[#FF3EA5] border-[#FF3EA5] shadow-[2px_2px_0px_0px_#ff90c8]' 
                    : 'border-transparent text-[#FF3EA5] hover:bg-pink-50' 
               }}">
                <svg class="w-5 h-5 stroke-[2.5px] {{ $isRekapActive ? 'text-white' : 'text-[#FF3EA5]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <span class="text-[9px] font-black uppercase tracking-wide {{ $isRekapActive ? 'text-white' : 'text-[#FF3EA5]' }}">Rekap</span>
            </a>

        @elseif(auth()->user()->role === 'admin')
            <a href="{{ route('admin.dashboard') }}" class="flex flex-col items-center justify-center w-full h-12 space-y-0.5 rounded-lg border-transparent text-[#FF3EA5]">
                <svg class="w-5 h-5 stroke-[2.5px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <span class="text-[9px] font-black uppercase tracking-wide">Users</span>
            </a>
        @endif

        {{-- MENU: SETTINGS --}}
        @php $isProfileActive = request()->routeIs('profile.edit'); @endphp
        <a href="{{ route('profile.edit') }}" 
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
    </div>
</nav>