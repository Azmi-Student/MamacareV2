<nav class="fixed bottom-0 left-0 w-full bg-white border-t-2 border-[#FF3EA5] z-50 lg:hidden pb-safe">
    {{-- Container: Tinggi standar (h-16), rata tengah (items-center) --}}
    <div class="flex justify-around items-center h-16 px-2">
        
        {{-- MENU: HOME --}}
        <a href="{{ route('dashboard') }}" 
           class="flex flex-col items-center justify-center w-full h-12 space-y-0.5 rounded-lg border-2 transition-all duration-200 group
           {{ request()->routeIs('dashboard') 
                ? 'bg-[#FF3EA5] border-[#FF3EA5] shadow-[2px_2px_0px_0px_#ff90c8]' 
                : 'border-transparent text-[#FF3EA5] hover:bg-pink-50' 
           }}">
            
            <svg class="w-5 h-5 stroke-[2.5px] {{ request()->routeIs('dashboard') ? 'text-white' : 'text-[#FF3EA5]' }}" 
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
            </svg>
            <span class="text-[9px] font-black uppercase tracking-wide {{ request()->routeIs('dashboard') ? 'text-white' : 'text-[#FF3EA5]' }}">
                Home
            </span>
        </a>

        {{-- MENU: DOKTER --}}
        <a href="#" 
           class="flex flex-col items-center justify-center w-full h-12 space-y-0.5 rounded-lg border-2 transition-all duration-200 group
           {{ request()->routeIs('doctor.*') 
                ? 'bg-[#FF3EA5] border-[#FF3EA5] shadow-[2px_2px_0px_0px_#ff90c8]' 
                : 'border-transparent text-[#FF3EA5] hover:bg-pink-50' 
           }}">
            
            <svg class="w-5 h-5 stroke-[2.5px] {{ request()->routeIs('doctor.*') ? 'text-white' : 'text-[#FF3EA5]' }}" 
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
            </svg>
            <span class="text-[9px] font-black uppercase tracking-wide {{ request()->routeIs('doctor.*') ? 'text-white' : 'text-[#FF3EA5]' }}">
                Dokter
            </span>
        </a>

        {{-- MENU: SETTINGS --}}
        <a href="#" 
           class="flex flex-col items-center justify-center w-full h-12 space-y-0.5 rounded-lg border-2 transition-all duration-200 group
           {{ request()->routeIs('settings') 
                ? 'bg-[#FF3EA5] border-[#FF3EA5] shadow-[2px_2px_0px_0px_#ff90c8]' 
                : 'border-transparent text-[#FF3EA5] hover:bg-pink-50' 
           }}">
            
            <svg class="w-5 h-5 stroke-[2.5px] {{ request()->routeIs('settings') ? 'text-white' : 'text-[#FF3EA5]' }}" 
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
            </svg>
            <span class="text-[9px] font-black uppercase tracking-wide {{ request()->routeIs('settings') ? 'text-white' : 'text-[#FF3EA5]' }}">
                Settings
            </span>
        </a>

    </div>
</nav>