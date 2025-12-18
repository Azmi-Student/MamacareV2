@extends('layouts.app')

@section('title', 'Dashboard Mamacare')

@section('content')
    <div class="container mx-auto pt-2 pb-8">

        {{-- CSS Efek Gelas (Tetap dipakai biar manis) --}}
        <style>
            @keyframes smooth-shine {
                0% {
                    left: -100%;
                    opacity: 0;
                }

                10% {
                    opacity: 1;
                }

                50% {
                    left: 200%;
                    opacity: 1;
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
                background: linear-gradient(to right, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.2) 30%, rgba(255, 255, 255, 0.6) 50%, rgba(255, 255, 255, 0.2) 70%, rgba(255, 255, 255, 0) 100%);
                transform: skewX(-25deg);
                animation: smooth-shine 6s infinite ease-in-out;
                pointer-events: none;
                z-index: 30;
            }
        </style>

        {{-- Hero Section: Neo Brutalism Pink --}}
        <section
            class="bg-[#FF3EA5] rounded-xl border-2 border-[#FF3EA5] shadow-[6px_6px_0px_0px_#ff90c8] overflow-hidden flex md:flex-row items-center relative mb-6 isolate">

            {{-- 1. Efek Gelas --}}
            <div class="efek-gelas-premium"></div>

            {{-- 2. Pattern Background --}}
            <div class="absolute inset-0 pointer-events-none opacity-10"
                style="background-image: url('{{ asset('images/puzzle-pattern.png') }}'); background-repeat: repeat; background-size: 100px;">
            </div>

            {{-- KONTEN KIRI --}}
            <div class="w-full md:w-3/5 p-6 md:p-8 z-10 relative">

                {{-- Sapaan --}}
                <h1
                    class="text-2xl md:text-4xl font-black text-white mb-2 uppercase tracking-tight drop-shadow-md leading-none">
                    Selamat Datang, <br>
                    <span
                        class="bg-white text-[#FF3EA5] px-2 rounded-md shadow-[3px_3px_0px_0px_rgba(0,0,0,0.1)] inline-block mt-1 transform -rotate-1">
                        {{ Auth::user()->name ?? 'BUNDA' }}!
                    </span>
                </h1>

                <p class="text-pink-100 text-sm md:text-base mb-8 font-bold max-w-md border-l-4 border-white pl-3 mt-3">
                    Menemani setiap langkah indah menanti kehadiran sang buah hati.
                </p>

                {{-- Menu Grid: Gaya Tombol Neo Brutal --}}
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">

                    {{-- Tombol 1: KALENDER KEHAMILAN --}}
                    <a href="{{ route('mama.kalender') }}"
                        class="bg-white p-2 rounded-lg border-2 border-white shadow-[3px_3px_0px_0px_#ff90c8] flex flex-col items-center justify-center gap-2 group transition-all hover:-translate-y-1 hover:shadow-[5px_5px_0px_0px_#ff90c8] active:translate-y-0 active:shadow-none h-full">

                        <img src="{{ asset('images/fitur-kalender.png') }}"
                            class="w-8 h-8 object-contain transition group-hover:scale-110">

                        <span
                            class="font-black text-[9px] md:text-[10px] text-[#FF3EA5] uppercase text-center leading-3 max-w-[80px]">
                            Kalender Kehamilan
                        </span>
                    </a>

                    {{-- Tombol 2: RESERVASI DOKTER --}}
                    <a href="#"
                        class="bg-white p-2 rounded-lg border-2 border-white shadow-[3px_3px_0px_0px_#ff90c8] flex flex-col items-center justify-center gap-2 group transition-all hover:-translate-y-1 hover:shadow-[5px_5px_0px_0px_#ff90c8] active:translate-y-0 active:shadow-none h-full">
                        <img src="{{ asset('images/fitur-reservasi.png') }}"
                            class="w-8 h-8 object-contain transition group-hover:scale-110">
                        <span
                            class="font-black text-[9px] md:text-[10px] text-[#FF3EA5] uppercase text-center leading-3 max-w-[80px]">
                            Reservasi Dokter
                        </span>
                    </a>

                    {{-- Tombol 3: CHAT MAMA.AI --}}
<a href="{{ route('mama.ai') }}"
    class="bg-white p-2 rounded-lg border-2 border-white shadow-[3px_3px_0px_0px_#ff90c8] flex flex-col items-center justify-center gap-2 group transition-all hover:-translate-y-1 hover:shadow-[5px_5px_0px_0px_#ff90c8] active:translate-y-0 active:shadow-none h-full">
    <img src="{{ asset('images/fitur-chat.png') }}"
        class="w-8 h-8 object-contain transition group-hover:scale-110">
    <span
        class="font-black text-[9px] md:text-[10px] text-[#FF3EA5] uppercase text-center leading-3 max-w-[80px]">
        Chat Mama.ai
    </span>
</a>

                    {{-- Tombol 4: LAINNYA --}}
                    <a href="#"
                        class="bg-white p-2 rounded-lg border-2 border-white shadow-[3px_3px_0px_0px_#ff90c8] flex flex-col items-center justify-center gap-2 group transition-all hover:-translate-y-1 hover:shadow-[5px_5px_0px_0px_#ff90c8] active:translate-y-0 active:shadow-none h-full">
                        <img src="{{ asset('images/fitur-lainnya.png') }}"
                            class="w-8 h-8 object-contain transition group-hover:scale-110">
                        <span class="font-black text-[9px] md:text-[10px] text-[#FF3EA5] uppercase text-center leading-3">
                            Lainnya
                        </span>
                    </a>

                </div>
            </div>

            {{-- KONTEN KANAN (Gambar) --}}
            <div class="hidden md:flex md:w-2/5 h-auto relative items-center justify-center z-10 pr-6">
                <div
                    class="absolute w-40 h-40 bg-white/20 rounded-full border-2 border-white/30 border-dashed animate-spin-slow">
                </div>
                <img src="{{ asset('images/ibu-hamil.png') }}" alt="Ilustrasi"
                    class="relative z-10 w-3/4 max-w-[220px] object-contain transition duration-500 hover:scale-105"
                    style="filter: drop-shadow(4px 4px 0px rgba(255,255,255,0.4));">
            </div>
        </section>


        <section class="grid grid-cols-1 lg:grid-cols-3 gap-4">

            <div
                class="lg:col-span-2 bg-white rounded-xl p-4 border-2 border-[#FF3EA5] shadow-[4px_4px_0px_0px_#FF3EA5] h-full flex flex-col justify-between">

                {{-- Logika Ambil Data AI --}}
                @php
                    // Ambil data dari relasi user ke kehamilan
                    $dataKehamilan = auth()->user()->kehamilan;
                    $aiData = $dataKehamilan ? json_decode($dataKehamilan->ai_data, true) : null;

                    $harian = $aiData['harian'] ?? [
                        'Istirahat cukup (Tidur 8 jam)',
                        'Minum air putih (2-3 Liter)',
                        'Makan buah & sayur',
                    ];
                    $status = $aiData['checklist_status'] ?? [];

                    // Item 1 sebagai Highlight, sisanya sebagai agenda lainnya
                    $highlight = $harian[0] ?? 'Istirahat Cukup';
                    $agendas = array_slice($harian, 1, 2); // Ambil 2 agenda berikutnya
                @endphp

                {{-- Layout Grid: Kiri (Highlight), Kanan (List) --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 flex-1">

                    {{-- 1. KARTU HIGHLIGHT (Tugas Pertama / Index 0) --}}
                    @php $isDoneH = isset($status[0]) && $status[0] == true; @endphp
                    <div x-data="{
                        checked: {{ $isDoneH ? 'true' : 'false' }},
                        toggle() {
                            this.checked = !this.checked;
                            fetch('{{ route('mama.kalender.update_checklist') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name=&quot;csrf-token&quot;]').getAttribute('content')
                                },
                                body: JSON.stringify({ index: 0, checked: this.checked })
                            });
                        }
                    }" @click="toggle()"
                        class="cursor-pointer rounded-xl p-5 flex flex-col justify-between border-2 border-[#FF3EA5] shadow-[4px_4px_0px_0px_#ff90c8] relative overflow-hidden group hover:-translate-y-1 transition-all duration-200 min-h-[200px]"
                        :class="checked ? 'bg-pink-400 opacity-80' : 'bg-[#FF3EA5]'">

                        {{-- Dekorasi Glossy --}}
                        <div class="absolute right-0 top-0 w-24 h-24 bg-white opacity-10 rounded-full blur-xl -mr-6 -mt-6">
                        </div>

                        <div class="relative z-10 flex flex-col h-full">
                            {{-- Badge Status --}}
                            <div class="mb-4">
                                <span
                                    class="inline-block px-3 py-1 bg-white border-2 border-white rounded-md text-[10px] font-black text-[#FF3EA5] shadow-[2px_2px_0px_0px_rgba(255,255,255,0.5)]">
                                    <span x-text="checked ? 'SELESAI' : 'SELANJUTNYA'"></span>
                                </span>
                            </div>

                            <div class="flex items-start gap-4 flex-1">
                                {{-- Icon Box --}}
                                <div
                                    class="shrink-0 w-12 h-12 bg-white rounded-lg border-2 border-white flex items-center justify-center text-[#FF3EA5] shadow-[3px_3px_0px_0px_rgba(255,255,255,0.3)]">
                                    <template x-if="!checked">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                        </svg>
                                    </template>
                                    <template x-if="checked">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                            stroke-width="4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </template>
                                </div>

                                {{-- Text Area --}}
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-black text-white text-lg md:text-xl leading-tight mb-1 uppercase tracking-tight line-clamp-3 break-words"
                                        :class="checked ? 'line-through opacity-70' : ''">
                                        {{ $highlight }}
                                    </h4>
                                    <p class="text-[10px] text-pink-100 font-bold italic"
                                        x-text="checked ? 'Hebat, Mama luar biasa!' : 'Ketuk jika sudah dilakukan'"></p>
                                </div>
                            </div>

                            {{-- Footer Kartu --}}
                            <div class="mt-4 pt-3 border-t-2 border-white/30 flex items-center gap-2">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-[10px] font-black text-white tracking-wider uppercase">Fokus Utama
                                    Mama</span>
                            </div>
                        </div>
                    </div>

                    {{-- 2. KARTU LIST (Agenda Lainnya / Index 1 & 2) --}}
                    <div class="flex flex-col gap-3">
                        <p class="text-[10px] font-black text-[#FF3EA5] uppercase tracking-widest mb-0 ml-1">AGENDA LAINNYA
                        </p>

                        @foreach ($agendas as $index => $tugas)
                            @php
                                $actualIndex = $index + 1; // Karena item pertama adalah index 0
                                $isDone = isset($status[$actualIndex]) && $status[$actualIndex] == true;
                            @endphp
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
                                        body: JSON.stringify({ index: {{ $actualIndex }}, checked: this.checked })
                                    });
                                }
                            }" @click="toggle()"
                                class="flex items-center gap-3 p-3 rounded-xl border-2 border-[#FF3EA5] transition-all cursor-pointer active:translate-y-0.5 active:shadow-none"
                                :class="checked ? 'bg-pink-50 opacity-60 border-dashed' :
                                    'bg-white hover:bg-pink-50 hover:shadow-[2px_2px_0px_0px_#FF3EA5]'">

                                <div class="w-10 h-10 shrink-0 rounded-lg border-2 flex items-center justify-center transition-all"
                                    :class="checked ? 'bg-[#FF3EA5] border-[#FF3EA5] text-white' :
                                        'bg-white border-[#FF3EA5] text-[#FF3EA5]'">
                                    <template x-if="!checked">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M7 17l9.2-9.2M17 17V7H7" />
                                        </svg>
                                    </template>
                                    <template x-if="checked">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                            stroke-width="4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7">
                                            </path>
                                        </svg>
                                    </template>
                                </div>

                                <div class="flex-1 min-w-0">
                                    <h4 class="font-black text-xs text-[#FF3EA5] uppercase truncate"
                                        :class="checked ? 'line-through' : ''">
                                        {{ $tugas }}
                                    </h4>
                                    <p class="text-[10px] font-bold text-pink-400 truncate"
                                        x-text="checked ? 'Selesai' : 'Belum selesai'"></p>
                                </div>
                            </div>
                        @endforeach

                        {{-- Link Lihat Semua --}}
                        <div class="mt-auto text-right">
                            <a href="{{ route('mama.kalender') }}"
                                class="inline-block px-3 py-1 rounded-md border-2 border-[#FF3EA5] text-[10px] font-black text-[#FF3EA5] hover:bg-[#FF3EA5] hover:text-white transition-colors uppercase tracking-wide">
                                LIHAT SEMUA &rarr;
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Container Utama: Border Pink + Shadow Pink Solid --}}
            <div
                class="lg:col-span-1 bg-white rounded-xl p-3 border-2 border-[#FF3EA5] shadow-[4px_4px_0px_0px_#FF3EA5] h-full flex flex-col transition-transform hover:-translate-y-1">

                {{-- Header Mini --}}
                <div class="flex items-center justify-between mb-3">
                    {{-- Tombol Previous: Border Pink, Icon Pink --}}
                    <button
                        class="w-6 h-6 flex items-center justify-center rounded-md border-2 border-[#FF3EA5] text-[#FF3EA5] hover:bg-[#FF3EA5] hover:text-white hover:shadow-[1px_1px_0px_0px_#FF3EA5] active:translate-y-0.5 active:shadow-none transition-all">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7">
                            </path>
                        </svg>
                    </button>

                    {{-- Bulan & Tahun: Text Pink Tebal --}}
                    <span class="font-black text-xs text-[#FF3EA5] uppercase tracking-widest">
                        {{ now()->format('F Y') }}
                    </span>

                    {{-- Tombol Next --}}
                    <button
                        class="w-6 h-6 flex items-center justify-center rounded-md border-2 border-[#FF3EA5] text-[#FF3EA5] hover:bg-[#FF3EA5] hover:text-white hover:shadow-[1px_1px_0px_0px_#FF3EA5] active:translate-y-0.5 active:shadow-none transition-all">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                    </button>
                </div>

                {{-- Nama Hari: Pink BG + White Text + Pink Border + Pink Shadow --}}
                <div class="grid grid-cols-7 text-center mb-1 gap-1">
                    <div
                        class="text-[8px] font-black text-white bg-[#FF3EA5] rounded py-0.5 border-2 border-[#FF3EA5] shadow-[1.5px_1.5px_0px_0px_#ff90c8]">
                        MIN</div>
                    <div
                        class="text-[8px] font-black text-white bg-[#FF3EA5] rounded py-0.5 border-2 border-[#FF3EA5] shadow-[1.5px_1.5px_0px_0px_#ff90c8]">
                        SEN</div>
                    <div
                        class="text-[8px] font-black text-white bg-[#FF3EA5] rounded py-0.5 border-2 border-[#FF3EA5] shadow-[1.5px_1.5px_0px_0px_#ff90c8]">
                        SEL</div>
                    <div
                        class="text-[8px] font-black text-white bg-[#FF3EA5] rounded py-0.5 border-2 border-[#FF3EA5] shadow-[1.5px_1.5px_0px_0px_#ff90c8]">
                        RAB</div>
                    <div
                        class="text-[8px] font-black text-white bg-[#FF3EA5] rounded py-0.5 border-2 border-[#FF3EA5] shadow-[1.5px_1.5px_0px_0px_#ff90c8]">
                        KAM</div>
                    <div
                        class="text-[8px] font-black text-white bg-[#FF3EA5] rounded py-0.5 border-2 border-[#FF3EA5] shadow-[1.5px_1.5px_0px_0px_#ff90c8]">
                        JUM</div>
                    <div
                        class="text-[8px] font-black text-white bg-[#FF3EA5] rounded py-0.5 border-2 border-[#FF3EA5] shadow-[1.5px_1.5px_0px_0px_#ff90c8]">
                        SAB</div>
                </div>

                {{-- Tanggal --}}
                <div class="grid grid-cols-7 gap-y-1 gap-x-0.5 text-center flex-1 place-content-start mt-2">
                    <div class="w-5 h-5"></div>
                    <div class="w-5 h-5"></div>

                    @for ($i = 1; $i <= 30; $i++)
                        {{-- 
                Normal: Text Pink, Border Transparent
                Hover: Border Pink
                Active (17): Full Pink Block, Shadow Lighter Pink (#ff90c8) biar kelihatan timbul
                --}}
                        <div
                            class="w-6 h-6 flex items-center justify-center text-[10px] rounded cursor-pointer mx-auto font-black border-2 transition-all duration-100
                            {{ $i == 17
                                ? 'bg-[#FF3EA5] text-white border-[#FF3EA5] shadow-[2px_2px_0px_0px_#ff90c8] -translate-y-0.5'
                                : 'text-[#FF3EA5] border-transparent hover:border-[#FF3EA5] hover:bg-pink-50' }}">
                            {{ $i }}
                        </div>
                    @endfor
                </div>

                {{-- Footer Agenda Mini: Garis Pemisah Pink --}}
                <div class="mt-auto pt-2 border-t-2 border-[#FF3EA5]">
                    <div class="flex items-center gap-2">
                        <div
                            class="w-6 h-6 rounded bg-[#FF3EA5] border-2 border-[#FF3EA5] flex items-center justify-center text-white shadow-[1.5px_1.5px_0px_0px_#ff90c8]">
                            <span class="font-black text-[9px]">17</span>
                        </div>
                        <div class="min-w-0">
                            <p class="text-[8px] font-bold text-pink-300 uppercase leading-none mb-0.5">Hari ini</p>
                            <p class="text-[9px] font-black text-[#FF3EA5] truncate leading-none">SENAM HAMIL</p>
                        </div>
                    </div>
                </div>
            </div>

        </section>

    </div>
@endsection
