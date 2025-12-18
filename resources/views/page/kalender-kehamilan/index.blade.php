@extends('layouts.app')

@section('title', 'Kalender Kehamilan - Mamacare')

@section('content')
    <div class="container mx-auto pt-4 pb-12 px-4 max-w-4xl">

        {{-- CSS Animasi & Gaya Minimalis --}}
        <style>
            @keyframes smooth-shine {
                0% {
                    left: -100%;
                    opacity: 0;
                }

                50% {
                    left: 200%;
                    opacity: 0.5;
                }

                100% {
                    left: 200%;
                    opacity: 0;
                }
            }

            .efek-gelas-premium {
                position: absolute;
                top: 0;
                left: 0;
                width: 50%;
                height: 100%;
                background: linear-gradient(to right, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.4) 50%, rgba(255, 255, 255, 0) 100%);
                transform: skewX(-25deg);
                animation: smooth-shine 8s infinite ease-in-out;
                pointer-events: none;
                z-index: 10;
            }

            .btn-disabled {
                opacity: 0.4;
                pointer-events: none;
                filter: grayscale(1);
            }

            /* Optimalisasi touch area untuk mobile */
            .checklist-item {
                -webkit-tap-highlight-color: transparent;
            }
        </style>

        {{-- Navigasi Top --}}
        <div class="flex items-center justify-between mb-6 md:mb-8">
            <a href="{{ route('dashboard') }}"
                class="bg-white border-2 md:border-4 border-[#FF3EA5] p-2 rounded-xl md:rounded-2xl shadow-[3px_3px_0px_0px_#FF3EA5] active:shadow-none active:translate-x-1 active:translate-y-1 transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 md:w-6 md:h-6 text-[#FF3EA5]" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <h2 class="text-base md:text-xl font-black text-[#FF3EA5] uppercase italic tracking-widest leading-none">
                Pregnancy Summary</h2>
        </div>

        @if (!$data)
            {{-- STATE 1: INPUT HPHT --}}
            <div class="flex items-center justify-center min-h-[60vh] px-2">
                <div x-data="{ hpht: '' }"
                    class="bg-white p-6 md:p-10 rounded-[2rem] md:rounded-[2.5rem] border-4 border-[#FF3EA5] shadow-[8px_8px_0px_0px_#ff90c8] md:shadow-[12px_12px_0px_0px_#ff90c8] max-w-md w-full relative overflow-hidden">
                    <div class="efek-gelas-premium"></div>
                    <div class="text-center mb-8 relative z-10">
                        <div class="inline-block p-3 bg-pink-50 rounded-full mb-4 border-2 border-[#FF3EA5]">
                            <span class="text-3xl md:text-4xl">✨</span>
                        </div>
                        <h3
                            class="text-3xl md:text-4xl font-black uppercase italic tracking-tighter text-[#FF3EA5] leading-none mb-2">
                            Halo Mama!</h3>
                        <p
                            class="font-bold text-[#FF3EA5] opacity-60 text-[10px] uppercase tracking-widest italic leading-none">
                            Kapan Hari Pertama Haid Terakhirmu?</p>
                    </div>
                    <form action="{{ route('mama.kalender') }}" method="GET" class="space-y-6 relative z-10">
                        <div>
                            <label
                                class="block text-[10px] font-black text-[#FF3EA5] uppercase mb-3 ml-1 italic tracking-widest">Pilih
                                Tanggal HPHT</label>
                            <input type="date" name="hpht" x-model="hpht" required
                                class="w-full border-4 border-[#FF3EA5] p-4 bg-white font-black text-xl md:text-2xl text-[#FF3EA5] outline-none shadow-[4px_4px_0px_0px_#ff90c8] rounded-2xl appearance-none">
                        </div>
                        <button type="submit" :class="!hpht ? 'btn-disabled' : ''"
                            class="w-full bg-[#FF3EA5] text-white font-black py-4 md:py-5 uppercase italic text-lg md:text-xl shadow-[4px_4px_0px_0px_#ff90c8] active:shadow-none active:translate-x-1 active:translate-y-1 transition-all rounded-2xl text-center">
                            Cek Sekarang ✨
                        </button>
                    </form>
                </div>
            </div>
        @else
            {{-- STATE 2: RINGKASAN & CHECKLIST --}}
            <div class="space-y-6 md:space-y-8">

                {{-- Hero: Status Utama Kehamilan --}}
                <div
                    class="bg-[#FF3EA5] rounded-[2rem] md:rounded-[3rem] p-8 md:p-12 text-white relative overflow-hidden shadow-[8px_8px_0px_0px_#ff90c8] md:shadow-[15px_15px_0px_0px_#ff90c8] border-4 border-[#FF3EA5]">
                    <div class="efek-gelas-premium opacity-20"></div>
                    <div class="relative z-10">
                        <p
                            class="font-black uppercase tracking-[0.2em] text-[9px] md:text-[10px] opacity-90 mb-3 md:mb-4 italic">
                            Usia Kehamilan Mama</p>
                        <h2 class="text-5xl sm:text-7xl md:text-9xl font-black italic tracking-tighter leading-none mb-4">
                            Minggu {{ $data['minggu'] }}</h2>
                        <div class="flex flex-wrap items-center gap-3 md:gap-4">
                            <span
                                class="bg-white text-[#FF3EA5] px-4 md:px-6 py-1.5 md:py-2 rounded-xl font-black uppercase text-sm md:text-lg italic shadow-[3px_3px_0px_0px_rgba(0,0,0,0.1)]">
                                Hari Ke-{{ $data['hari'] }}
                            </span>
                            <span class="font-black italic uppercase tracking-tighter opacity-90 text-sm md:text-xl">On
                                Track! 🏃‍♀️</span>
                        </div>
                    </div>
                </div>

                {{-- Grid: Info Penting --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 md:gap-8">
                    {{-- Card Ukuran --}}
                    <div
                        class="bg-white border-4 border-[#FF3EA5] rounded-[2rem] p-6 md:p-10 shadow-[6px_6px_0px_0px_#ff90c8] relative overflow-hidden group">
                        <p
                            class="text-[9px] md:text-[10px] font-black text-[#FF3EA5] uppercase tracking-widest mb-3 opacity-60">
                            Ukuran Janin</p>
                        <h4
                            class="text-2xl md:text-4xl font-black text-[#FF3EA5] italic uppercase tracking-tighter leading-tight">
                            Seukuran {{ $data['ukuran'] }}</h4>
                        <div
                            class="absolute -right-2 -bottom-2 opacity-10 text-6xl md:text-8xl font-black italic text-[#FF3EA5] rotate-12">
                            📏</div>
                    </div>

                    {{-- Card HPL --}}
                    <div
                        class="bg-white border-4 border-[#FF3EA5] rounded-[2rem] p-6 md:p-10 shadow-[6px_6px_0px_0px_#ff90c8] flex flex-col justify-center relative overflow-hidden group">
                        <p
                            class="text-[9px] md:text-[10px] font-black text-[#FF3EA5] uppercase tracking-widest mb-3 opacity-60">
                            Estimasi Lahir</p>
                        <h4
                            class="text-xl md:text-3xl font-black text-[#FF3EA5] italic uppercase tracking-tighter leading-tight">
                            {{ $data['hpl'] }}</h4>
                        <div
                            class="absolute -right-2 -bottom-2 opacity-10 text-6xl md:text-8xl font-black italic text-[#FF3EA5] -rotate-12">
                            🗓️</div>
                    </div>
                </div>

                {{-- DAILY CHECKLIST SECTION --}}
                <div
                    class="bg-white border-4 border-[#FF3EA5] rounded-[2rem] md:rounded-[2.5rem] p-6 md:p-10 shadow-[6px_6px_0px_0px_#ff90c8] md:shadow-[10px_10px_0px_0px_#ff90c8]">
                    <div class="flex items-center justify-between mb-6 md:mb-8">
                        <div>
                            <h3 class="text-xl md:text-2xl font-black text-[#FF3EA5] uppercase italic tracking-tighter">
                                Daily Checklist</h3>
                            <p class="text-[9px] md:text-[10px] font-bold text-[#FF3EA5] opacity-60 uppercase mt-1 italic">
                                Tersimpan otomatis di sistem</p>
                        </div>
                        <span class="text-3xl md:text-4xl">📝</span>
                    </div>

                    <div class="grid grid-cols-1 gap-3 md:gap-4">
                        @php
                            $harian = $data['harian'] ?? [];
                            $status = $data['checklist_status'] ?? [];
                        @endphp

                        @foreach ($harian as $index => $tugas)
                            @php $isDone = isset($status[$index]) && $status[$index] == true; @endphp

                            <div x-data="{
                                checked: {{ $isDone ? 'true' : 'false' }},
                                toggle() {
                                    this.checked = !this.checked;
                                    fetch('{{ route('mama.kalender.update_checklist') }}', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': document.querySelector('meta[name=&quot;csrf-token&quot;]').getAttribute('content')
                                        },
                                        body: JSON.stringify({ index: {{ $index }}, checked: this.checked })
                                    });
                                }
                            }" @click="toggle()"
                                class="checklist-item flex items-center p-4 rounded-xl md:rounded-2xl border-2 md:border-4 border-[#FF3EA5] cursor-pointer transition-all active:scale-[0.98]"
                                :class="checked ? 'bg-pink-50 opacity-60 border-dashed shadow-none' :
                                    'bg-white shadow-[3px_3px_0px_0px_#FF3EA5] md:shadow-[4px_4px_0px_0px_#FF3EA5]'">

                                <div class="shrink-0 w-6 h-6 md:w-8 md:h-8 border-2 md:border-4 border-[#FF3EA5] rounded-lg flex items-center justify-center transition-all"
                                    :class="checked ? 'bg-[#FF3EA5]' : 'bg-white'">
                                    <svg x-show="checked" class="w-4 h-4 md:w-5 md:h-5 text-white" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>

                                <span
                                    class="ml-3 md:ml-4 font-black text-[#FF3EA5] uppercase italic text-xs md:text-sm tracking-tight leading-tight"
                                    :class="checked ? 'line-through opacity-50' : ''">
                                    {{ $tugas }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- CTA: Tombol Panduan Lengkap --}}
                <a href="{{ route('mama.kalender.detail', ['hpht' => $data['hpht']]) }}"
                    class="group block bg-white border-4 border-[#FF3EA5] p-8 md:p-10 rounded-[2rem] md:rounded-[2.5rem] shadow-[6px_6px_0px_0px_#FF3EA5] md:shadow-[12px_12px_0px_0px_#FF3EA5] active:shadow-none active:translate-x-1 active:translate-y-1 transition-all relative overflow-hidden text-center">
                    <div class="efek-gelas-premium opacity-5 group-hover:opacity-20 transition-opacity"></div>
                    <div class="relative z-10">
                        <span
                            class="text-2xl md:text-4xl font-black text-[#FF3EA5] uppercase italic tracking-tighter leading-none block">Lihat
                            Panduan Lengkap Mama 📖</span>
                        <p
                            class="mt-3 text-[10px] font-bold text-[#FF3EA5] opacity-60 uppercase tracking-widest italic leading-none">
                            Eksplor tugas harian, nutrisi, & pantangan AI</p>
                    </div>
                </a>

                {{-- Action: Reset --}}
                <div class="text-center pb-6">
                    <a href="{{ route('mama.kalender.reset') }}"
                        class="text-[9px] md:text-[10px] font-black text-[#FF3EA5] uppercase underline underline-offset-4 tracking-widest italic opacity-40 hover:opacity-100 transition-all">
                        ↺ Ganti Tanggal HPHT Mama
                    </a>
                </div>
            </div>
        @endif
    </div>
@endsection
