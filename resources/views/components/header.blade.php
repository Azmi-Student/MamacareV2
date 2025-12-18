<div class="flex items-center gap-4">
    
    <div x-data="{ open: false }" class="relative">
        
        <button @click="open = !open" class="flex items-center gap-2 focus:outline-none group">
            <div class="text-right hidden md:block">
                <p class="text-sm font-semibold text-gray-700 group-hover:text-blue-600 transition">
                    {{ Auth::user()->name ?? 'Guest User' }}
                </p>
                <p class="text-xs text-gray-500">
                    {{ ucfirst(Auth::user()->role ?? 'Guest') }}
                </p>
            </div>
            
            <img class="h-9 w-9 rounded-full object-cover border border-gray-200 group-hover:border-blue-400 transition" 
                 src="https://ui-avatars.com/api/?name={{ Auth::user()->name ?? 'Guest' }}&background=0D8ABC&color=fff" 
                 alt="Avatar">
                 
            <svg class="w-4 h-4 text-gray-400 group-hover:text-blue-600 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </button>

        <div x-show="open" 
             @click.away="open = false"
             x-transition:enter="transition ease-out duration-100"
             x-transition:enter-start="transform opacity-0 scale-95"
             x-transition:enter-end="transform opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-75"
             x-transition:leave-start="transform opacity-100 scale-100"
             x-transition:leave-end="transform opacity-0 scale-95"
             class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 border border-gray-100 z-50"
             style="display: none;">
            
            <div class="px-4 py-2 border-b border-gray-100 md:hidden">
                <p class="text-sm font-semibold text-gray-700">{{ Auth::user()->name ?? 'Guest' }}</p>
                <p class="text-xs text-gray-500">{{ ucfirst(Auth::user()->role ?? 'Guest') }}</p>
            </div>

            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition">
                Profile Saya
            </a>
            
            <div class="border-t border-gray-100 my-1"></div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition">
                    Logout
                </button>
            </form>
        </div>
    </div>
</div>