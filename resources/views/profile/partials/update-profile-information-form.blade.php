<section>
    <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
        @csrf
        @method('patch')

        {{-- Nama Lengkap --}}
        <div class="space-y-2">
            <label for="name" class="block text-[10px] font-black text-[#FF3EA5] uppercase tracking-[0.2em] ml-1">
                Nama Lengkap
            </label>
            <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required
                class="w-full border-2 border-[#FF3EA5] p-3.5 rounded-2xl font-bold text-[#FF3EA5] bg-white shadow-[4px_4px_0px_0px_#ff90c8] focus:ring-0 focus:border-[#FF3EA5] focus:shadow-none focus:translate-x-0.5 focus:translate-y-0.5 outline-none transition-all placeholder:text-pink-200">
            @error('name') 
                <p class="text-[9px] text-red-400 font-bold mt-2 ml-1 uppercase tracking-tight">{{ $message }}</p> 
            @enderror
        </div>

        {{-- Alamat Email --}}
        <div class="space-y-2">
            <label for="email" class="block text-[10px] font-black text-[#FF3EA5] uppercase tracking-[0.2em] ml-1">
                Alamat Email
            </label>
            <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required
                class="w-full border-2 border-[#FF3EA5] p-3.5 rounded-2xl font-bold text-[#FF3EA5] bg-white shadow-[4px_4px_0px_0px_#ff90c8] focus:ring-0 focus:border-[#FF3EA5] focus:shadow-none focus:translate-x-0.5 focus:translate-y-0.5 outline-none transition-all placeholder:text-pink-200">
            @error('email') 
                <p class="text-[9px] text-red-400 font-bold mt-2 ml-1 uppercase tracking-tight">{{ $message }}</p> 
            @enderror

            {{-- Verifikasi Email --}}
            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-4 p-4 bg-pink-50 rounded-2xl border-2 border-dashed border-[#FF3EA5]">
                    <p class="text-[10px] font-bold text-[#FF3EA5] uppercase leading-relaxed">
                        Alamat email Anda belum diverifikasi.
                        <button form="send-verification" class="underline decoration-2 underline-offset-4 hover:text-pink-600">
                            Klik di sini untuk mengirim ulang email verifikasi.
                        </button>
                    </p>
                </div>
            @endif
        </div>

        {{-- Tombol Simpan --}}
        <div class="flex items-center gap-4 pt-2">
            <button type="submit" 
                class="bg-[#FF3EA5] text-white font-black px-8 py-3.5 rounded-2xl uppercase text-[10px] tracking-widest shadow-[4px_4px_0px_0px_#ff90c8] hover:shadow-none hover:translate-x-0.5 hover:translate-y-0.5 active:scale-95 transition-all">
                Simpan Perubahan
            </button>

            @if (session('status') === 'profile-updated')
                <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" 
                   class="flex items-center gap-2 text-[10px] font-black text-[#FF3EA5] uppercase tracking-widest">
                   <span>✓ Tersimpan</span>
                </div>
            @endif
        </div>
    </form>
</section>