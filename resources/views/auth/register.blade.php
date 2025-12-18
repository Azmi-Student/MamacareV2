@extends('layouts.guest')

@section('title', 'Daftar - Mamacare')

@section('content')
    {{-- SISI KIRI: SIMPEL (Pink) --}}
    <div class="hidden lg:flex lg:w-1/2 bg-primary flex-col h-screen">
        {{-- Logo + Judul --}}
        <div class="p-6 md:p-10 flex items-center gap-4">
            <img src="{{ asset('images/logo-icon.png') }}" alt="Logo" class="w-12 h-12 object-contain bg-white rounded-xl p-2 shadow-[3px_3px_0px_0px_#ff90c8]">
            <h1 class="text-2xl font-black text-white uppercase tracking-tighter">Mamacare</h1>
        </div>
        
        {{-- Paragraf di Tengah --}}
        <div class="flex-1 flex items-center px-16">
            <p class="text-3xl font-bold text-white leading-tight max-w-lg">
                Bergabunglah bersama ribuan orang tua lainnya untuk perjalanan kehamilan yang lebih sehat, cerdas, dan terpantau dengan baik.
            </p>
        </div>
    </div>

    {{-- SISI KANAN: PUTIH --}}
    <div class="w-full lg:w-1/2 bg-white h-screen overflow-hidden flex flex-col relative">
        
        {{-- Tombol Kembali --}}
        <div class="p-6 md:p-8 flex items-center">
            <a href="/" class="flex items-center gap-3 group">
                <div class="w-8 h-8 bg-white border-2 border-primary rounded-xl flex items-center justify-center shadow-[3px_3px_0px_0px_#FF3EA5] group-active:shadow-none group-active:translate-x-0.5 group-active:translate-y-0.5 transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                </div>
                <span class="text-[10px] font-black text-primary uppercase tracking-[0.2em]">Kembali</span>
            </a>
        </div>

        {{-- AREA FORM (Dioptimalkan agar tidak mepet) --}}
        <div class="flex-1 flex items-center justify-center p-6 md:p-8 -mt-12">
            <div class="w-full max-w-md text-center">
                
                {{-- Logo diperkecil dikit biar lega --}}
                <div class="flex justify-center mb-4">
                    <img src="{{ asset('images/logo-icon.png') }}" alt="Mamacare Logo" class="w-14 h-14 object-contain">
                </div>

                <div class="mb-5">
                    <h2 class="text-3xl font-black text-primary uppercase tracking-tighter leading-none mb-2">Daftar Akun</h2>
                    <p class="text-[10px] font-bold text-pink-300 uppercase tracking-[0.2em]">Lengkapi data diri Anda</p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-3.5 text-left">
                    @csrf

                    {{-- Nama --}}
                    <div class="space-y-1">
                        <label class="block text-[10px] font-black text-primary uppercase tracking-[0.2em] ml-1">Nama Lengkap</label>
                        <input type="text" name="name" :value="old('name')" required autofocus placeholder="Masukkan nama"
                            class="w-full border-2 border-primary p-3 rounded-2xl font-bold text-primary shadow-[4px_4px_0px_0px_#ff90c8] focus:ring-0 focus:border-primary outline-none transition-all placeholder:text-pink-100 bg-white text-xs">
                        <x-input-error :messages="$errors->get('name')" class="mt-1 text-[8px] font-bold text-red-400 uppercase ml-1" />
                    </div>

                    {{-- Email --}}
                    <div class="space-y-1">
                        <label class="block text-[10px] font-black text-primary uppercase tracking-[0.2em] ml-1">Email</label>
                        <input type="email" name="email" :value="old('email')" required placeholder="nama@email.com"
                            class="w-full border-2 border-primary p-3 rounded-2xl font-bold text-primary shadow-[4px_4px_0px_0px_#ff90c8] focus:ring-0 focus:border-primary outline-none transition-all placeholder:text-pink-100 bg-white text-xs">
                        <x-input-error :messages="$errors->get('email')" class="mt-1 text-[8px] font-bold text-red-400 uppercase ml-1" />
                    </div>

                    {{-- Password Grid --}}
                    <div class="grid grid-cols-2 gap-3">
                        <div class="space-y-1">
                            <label class="block text-[10px] font-black text-primary uppercase tracking-[0.2em] ml-1">Kata Sandi</label>
                            <input type="password" name="password" required placeholder="••••••••"
                                class="w-full border-2 border-primary p-3 rounded-2xl font-bold text-primary shadow-[4px_4px_0px_0px_#ff90c8] focus:ring-0 focus:border-primary outline-none transition-all bg-white text-xs">
                        </div>
                        <div class="space-y-1">
                            <label class="block text-[10px] font-black text-primary uppercase tracking-[0.2em] ml-1">Konfirmasi</label>
                            <input type="password" name="password_confirmation" required placeholder="••••••••"
                                class="w-full border-2 border-primary p-3 rounded-2xl font-bold text-primary shadow-[4px_4px_0px_0px_#ff90c8] focus:ring-0 focus:border-primary outline-none transition-all bg-white text-xs">
                        </div>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-1 text-[8px] font-bold text-red-400 uppercase ml-1" />

                    {{-- Tombol Register Utama --}}
                    <div class="pt-2">
                        <button type="submit" 
                            class="w-full bg-primary text-white font-black py-3.5 rounded-2xl uppercase text-[10px] tracking-[0.2em] shadow-[4px_4px_0px_0px_#ff90c8] hover:shadow-none hover:translate-x-1 hover:translate-y-1 active:scale-95 transition-all">
                            Daftar Sekarang 🚀
                        </button>
                    </div>

                    {{-- Atau Google (Padding dikecilkan) --}}
                    <div class="relative flex py-1 items-center">
                        <div class="flex-grow border-t-2 border-pink-50"></div>
                        <span class="flex-shrink mx-4 text-[8px] font-black text-pink-200 uppercase tracking-widest">Atau</span>
                        <div class="flex-grow border-t-2 border-pink-50"></div>
                    </div>

                    {{-- Tombol Google --}}
                    <a href="{{ url('auth/google') }}" 
                        class="w-full bg-white border-2 border-primary text-primary font-black py-3 rounded-2xl uppercase text-[9px] tracking-[0.2em] shadow-[4px_4px_0px_0px_#ff90c8] hover:shadow-none hover:translate-x-1 hover:translate-y-1 active:scale-95 transition-all flex items-center justify-center gap-3">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                            <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                            <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                            <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                        </svg>
                        Daftar dengan Google
                    </a>

                    {{-- Login Link --}}
                    <div class="text-center mt-2">
                        <p class="text-[9px] font-bold text-pink-200 uppercase tracking-widest">
                            Sudah punya akun? <a href="{{ route('login') }}" class="text-primary font-black underline decoration-2 underline-offset-4">Masuk</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection