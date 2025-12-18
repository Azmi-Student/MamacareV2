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
            {{-- STATE 2: RINGKASAN & CHECKLIST (PURE PINK & WHITE) --}}
<div class="space-y-5">

    {{-- Hero: Status Utama Kehamilan --}}
    <div class="bg-[#FF3EA5] rounded-[2rem] p-6 text-white relative overflow-hidden shadow-[6px_6px_0px_0px_#ff90c8] border-2 border-[#FF3EA5]">
        <div class="relative z-10">
            <p class="font-black uppercase tracking-widest text-[9px] opacity-90 mb-1">Usia Kehamilan Mama</p>
            <div class="flex items-baseline gap-2 mb-3">
                <h2 class="text-5xl font-black tracking-tighter leading-none">Minggu {{ $data['minggu'] }}</h2>
            </div>
            <div class="flex items-center gap-2">
                <span class="bg-white text-[#FF3EA5] px-3 py-1 rounded-lg font-black uppercase text-[10px] shadow-[2px_2px_0px_0px_rgba(0,0,0,0.1)]">
                    Hari Ke-{{ $data['hari'] }}
                </span>
                <span class="font-black uppercase tracking-tight text-[10px]">On Track! ✨</span>
            </div>
        </div>
        {{-- Pola Titik-titik Putih Halus --}}
        <div class="absolute inset-0 opacity-10 pointer-events-none" style="background-image: radial-gradient(circle, #fff 1px, transparent 1px); background-size: 10px 10px;"></div>
    </div>

    {{-- Grid: Info Penting (Variasi Shadow & Border Pink) --}}
    <div class="grid grid-cols-2 gap-4">
        {{-- Card Ukuran: Border Tebal --}}
        <div class="bg-white border-4 border-[#FF3EA5] rounded-3xl p-4 shadow-[4px_4px_0px_0px_#ff90c8] relative overflow-hidden">
            <p class="text-[8px] font-black text-[#FF3EA5] uppercase tracking-widest mb-1">Ukuran Janin</p>
            <h4 class="text-xs md:text-sm font-black text-[#FF3EA5] uppercase leading-tight line-clamp-2">Seukuran {{ $data['ukuran'] }}</h4>
            <div class="absolute -right-1 -bottom-1 opacity-10 text-3xl rotate-12 text-[#FF3EA5]">📏</div>
        </div>

        {{-- Card HPL: Border Tipis --}}
        <div class="bg-white border-2 border-[#FF3EA5] rounded-3xl p-4 shadow-[4px_4px_0px_0px_#ff90c8] relative overflow-hidden">
            <p class="text-[8px] font-black text-[#FF3EA5] uppercase tracking-widest mb-1 opacity-60">Estimasi Lahir</p>
            <h4 class="text-xs md:text-sm font-black text-[#FF3EA5] uppercase leading-tight">{{ $data['hpl'] }}</h4>
            <div class="absolute -right-1 -bottom-1 opacity-10 text-3xl -rotate-12 text-[#FF3EA5]">🗓️</div>
        </div>
    </div>

    {{-- DAILY CHECKLIST SECTION --}}
    <div class="bg-white border-2 border-[#FF3EA5] rounded-[2.5rem] p-5 shadow-[6px_6px_0px_0px_#ff90c8]">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="text-sm font-black text-[#FF3EA5] uppercase tracking-wider">Daily Checklist</h3>
                <p class="text-[8px] font-bold text-[#FF3EA5] opacity-50 uppercase mt-0.5">Disimpan otomatis</p>
            </div>
            <span class="text-xl">📝</span>
        </div>

        <div class="space-y-2.5">
            @foreach ($data['harian'] as $index => $tugas)
                @php $isDone = isset($data['checklist_status'][$index]) && $data['checklist_status'][$index]; @endphp

                <div x-data="{
                    checked: {{ $isDone ? 'true' : 'false' }},
                    toggle() {
                        this.checked = !this.checked;
                        fetch('{{ route('mama.kalender.update_checklist') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name=\'csrf-token\']').getAttribute('content')
                            },
                            body: JSON.stringify({ index: {{ $index }}, checked: this.checked })
                        });
                    }
                }" @click="toggle()"
                    class="flex items-center p-3 rounded-2xl border-2 border-[#FF3EA5] cursor-pointer transition-all active:scale-[0.98]"
                    :class="checked ? 'bg-pink-50 opacity-50 border-dashed shadow-none translate-x-1' : 'bg-white shadow-[3px_3px_0px_0px_#FF3EA5]'">

                    <div class="shrink-0 w-5 h-5 border-2 border-[#FF3EA5] rounded flex items-center justify-center transition-all"
                        :class="checked ? 'bg-[#FF3EA5]' : 'bg-white'">
                        <svg x-show="checked" class="w-3 h-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="5">
                            <path d="M5 13l4 4L19 7" />
                        </svg>
                    </div>

                    <span class="ml-3 font-black text-[#FF3EA5] uppercase text-[10px] tracking-tight leading-tight"
                        :class="checked ? 'line-through opacity-40' : ''">
                        {{ $tugas }}
                    </span>
                </div>
            @endforeach
        </div>
    </div>

    {{-- CTA: Tombol Detail --}}
    <a href="{{ route('mama.kalender.detail', ['hpht' => $data['hpht']]) }}"
        class="block bg-white border-2 border-[#FF3EA5] p-5 rounded-[2rem] shadow-[4px_4px_0px_0px_#FF3EA5] active:shadow-none active:translate-y-0.5 transition-all text-center group">
        <span class="text-base font-black text-[#FF3EA5] uppercase tracking-tighter block group-hover:scale-105 transition-transform">Lihat Detail Minggu Ini 📖</span>
        <p class="mt-1 text-[8px] font-bold text-[#FF3EA5] opacity-40 uppercase tracking-widest">Eksplor Nutrisi & Tips</p>
    </a>

    {{-- Action: Reset --}}
    <div class="text-center pt-2">
        <a href="{{ route('mama.kalender.reset') }}"
            class="text-[8px] font-black text-[#FF3EA5] uppercase underline underline-offset-4 tracking-widest opacity-30 hover:opacity-100 transition-all">
            ↺ Ganti Tanggal HPHT
        </a>
    </div>
</div>
        @endif
    </div>
@endsection
