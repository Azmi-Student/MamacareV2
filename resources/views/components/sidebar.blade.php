<div class="flex flex-col h-full bg-white">

    {{-- 1. LOGO AREA --}}
    <div class="h-20 flex items-center justify-center lg:justify-start lg:px-6 shrink-0 mt-2">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group">
            
            {{-- Icon Logo --}}
            <div class="w-10 h-10 bg-[#FF3EA5] rounded-lg border-2 border-[#FF3EA5] flex items-center justify-center shadow-[3px_3px_0px_0px_#ff90c8] group-hover:translate-x-1 group-hover:shadow-none transition-all">
                <img src="{{ asset('images/logo-icon.png') }}" alt="Icon" class="w-6 h-6 object-contain brightness-0 invert">
            </div>

            <span class="text-2xl font-black text-[#FF3EA5] hidden lg:block whitespace-nowrap tracking-tighter uppercase drop-shadow-sm">
                MamaCare
            </span>
        </a>
    </div>

    {{-- 2. NAVIGATION LINKS --}}
    <nav class="flex-1 overflow-y-auto py-4 px-4 space-y-3">

        {{-- LINK: DASHBOARD --}}
        <a href="{{ route('dashboard') }}"
            class="flex items-center p-3 rounded-xl border-2 transition-all duration-200 justify-center lg:justify-start group
            {{ request()->routeIs('dashboard') 
                ? 'bg-[#FF3EA5] border-[#FF3EA5] shadow-[4px_4px_0px_0px_#ff90c8] -translate-y-1' 
                : 'bg-white border-transparent text-[#FF3EA5] hover:border-[#FF3EA5] hover:shadow-[4px_4px_0px_0px_#FF3EA5] hover:-translate-y-1' 
            }}">

            <svg class="w-6 h-6 shrink-0 stroke-[2.5px] {{ request()->routeIs('dashboard') ? 'text-white' : 'text-[#FF3EA5]' }}"
                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
            </svg>
            
            <span class="ms-3 hidden lg:block font-black uppercase tracking-wide text-sm 
                {{ request()->routeIs('dashboard') ? 'text-white' : 'text-[#FF3EA5]' }}">
                Dashboard
            </span>
        </a>

        {{-- LINK: TANYA DOKTER --}}
        <a href="#"
            class="flex items-center p-3 rounded-xl border-2 transition-all duration-200 justify-center lg:justify-start group
            {{ request()->routeIs('doctor.*') 
                ? 'bg-[#FF3EA5] border-[#FF3EA5] shadow-[4px_4px_0px_0px_#ff90c8] -translate-y-1' 
                : 'bg-white border-transparent text-[#FF3EA5] hover:border-[#FF3EA5] hover:shadow-[4px_4px_0px_0px_#FF3EA5] hover:-translate-y-1' 
            }}">

            <svg class="w-6 h-6 shrink-0 stroke-[2.5px] {{ request()->routeIs('doctor.*') ? 'text-white' : 'text-[#FF3EA5]' }}"
                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z">
                </path>
            </svg>

            <span class="ms-3 hidden lg:block font-black uppercase tracking-wide text-sm 
                {{ request()->routeIs('doctor.*') ? 'text-white' : 'text-[#FF3EA5]' }}">
                Tanya Dokter
            </span>
        </a>

        {{-- LINK: SETTINGS --}}
        <a href="#"
            class="flex items-center p-3 rounded-xl border-2 transition-all duration-200 justify-center lg:justify-start group
            {{ request()->routeIs('settings') 
                ? 'bg-[#FF3EA5] border-[#FF3EA5] shadow-[4px_4px_0px_0px_#ff90c8] -translate-y-1' 
                : 'bg-white border-transparent text-[#FF3EA5] hover:border-[#FF3EA5] hover:shadow-[4px_4px_0px_0px_#FF3EA5] hover:-translate-y-1' 
            }}">

            <svg class="w-6 h-6 shrink-0 stroke-[2.5px] {{ request()->routeIs('settings') ? 'text-white' : 'text-[#FF3EA5]' }}"
                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>

            <span class="ms-3 hidden lg:block font-black uppercase tracking-wide text-sm 
                {{ request()->routeIs('settings') ? 'text-white' : 'text-[#FF3EA5]' }}">
                Settings
            </span>
        </a>

    </nav>
</div>