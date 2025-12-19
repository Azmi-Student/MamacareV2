@extends('layouts.app')

@section('title', 'Detail Rekap Medis - Mamacare')

@section('content')
<div class="min-h-screen py-6 md:py-10 text-[#FF3EA5] font-sans selection:bg-[#FF3EA5] selection:text-white" x-data="{ showModal: false }">
    <div class="max-w-4xl mx-auto px-4 sm:px-6">
        
        {{-- 1. TOMBOL KEMBALI --}}
        <div class="mb-6">
            <a href="{{ route('mama.rekap-data') }}" 
               class="inline-flex items-center gap-2 px-4 py-2 bg-white border-2 border-[#FF3EA5] text-[#FF3EA5] font-black uppercase rounded-xl shadow-[3px_3px_0px_0px_#FF3EA5] hover:shadow-none hover:translate-x-[1px] hover:translate-y-[1px] transition-all text-[10px] md:text-xs">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"></path></svg>
                Kembali ke Daftar
            </a>
        </div>

        {{-- 2. KARTU DETAIL UTAMA --}}
        <div class="bg-white border-2 md:border-4 border-[#FF3EA5] rounded-[2rem] shadow-[8px_8px_0px_0px_#FF3EA5] overflow-hidden">
            
            {{-- Header Kartu (Info Dokter & Tanggal) --}}
            <div class="bg-white border-b-4 border-[#FF3EA5] p-6 md:p-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 md:w-16 md:h-16 rounded-full border-4 border-[#FF3EA5] flex items-center justify-center shrink-0 shadow-[3px_3px_0px_0px_#FF3EA5]">
                        <svg class="w-6 h-6 md:w-8 md:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                    <div class="min-w-0">
                        <p class="text-[9px] md:text-[10px] font-black uppercase tracking-widest opacity-60">Dokter Pemeriksa</p>
                        <h2 class="text-xl md:text-3xl font-black uppercase tracking-tighter leading-tight truncate">
                            {{ $rekap->doctor->name }}
                        </h2>
                        <p class="text-[10px] md:text-xs font-bold uppercase tracking-widest opacity-80 italic">{{ $rekap->time }} WIB</p>
                    </div>
                </div>

                <div class="w-full md:w-auto bg-white border-2 md:border-4 border-[#FF3EA5] px-5 py-3 rounded-2xl shadow-[4px_4px_0px_0px_#FF3EA5] text-center">
                    <p class="text-[8px] md:text-[10px] font-black uppercase opacity-60">Tanggal Periksa</p>
                    <p class="text-base md:text-lg font-black uppercase">{{ \Carbon\Carbon::parse($rekap->date)->isoFormat('D MMM YYYY') }}</p>
                </div>
            </div>

            {{-- Isi Detail --}}
            <div class="p-6 md:p-10">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12">
                    
                    {{-- Kolom Kiri: Diagnosa & Resep --}}
                    <div class="space-y-8">
                        {{-- Diagnosa --}}
                        <div>
                            <div class="inline-block bg-[#FF3EA5] text-white px-3 py-1 rounded-lg text-[9px] md:text-[10px] font-black uppercase tracking-widest mb-3">
                                Diagnosa
                            </div>
                            <div class="p-5 md:p-6 bg-white border-2 md:border-4 border-[#FF3EA5] rounded-[1.5rem] font-bold text-sm md:text-base leading-relaxed shadow-[4px_4px_0px_0px_#FF3EA5]">
                                {{ $rekap->diagnosis }}
                            </div>
                        </div>

                        {{-- Resep/Saran --}}
                        <div>
                            <div class="inline-block bg-white text-[#FF3EA5] border-2 border-[#FF3EA5] px-3 py-1 rounded-lg text-[9px] md:text-[10px] font-black uppercase tracking-widest mb-3">
                                Resep & Saran
                            </div>
                            <div class="p-5 md:p-6 bg-white border-2 md:border-4 border-[#FF3EA5] border-dashed rounded-[1.5rem] font-bold text-sm md:text-base leading-relaxed whitespace-pre-line">
                                {{ $rekap->prescription }}
                            </div>
                        </div>
                    </div>

                    {{-- Kolom Kanan: Lampiran USG --}}
                    <div>
                        <div class="inline-block bg-[#FF3EA5] text-white px-3 py-1 rounded-lg text-[9px] md:text-[10px] font-black uppercase tracking-widest mb-3">
                            Hasil Foto USG
                        </div>
                        
                        @if($rekap->image)
                            <div @click="showModal = true" class="group relative cursor-pointer border-2 md:border-4 border-[#FF3EA5] rounded-[2rem] overflow-hidden shadow-[6px_6px_0px_0px_#FF3EA5] transition-transform hover:scale-[1.01]">
                                <img src="{{ asset('storage/' . $rekap->image) }}" class="w-full h-64 md:h-80 object-cover" />
                                <div class="absolute inset-0 bg-[#FF3EA5]/10 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-all">
                                    <span class="bg-white border-2 border-[#FF3EA5] px-4 py-2 font-black uppercase text-[10px] shadow-[3px_3px_0px_0px_#FF3EA5]">Klik Perbesar</span>
                                </div>
                            </div>
                        @else
                            <div class="h-64 md:h-80 border-2 md:border-4 border-dashed border-[#FF3EA5] rounded-[2rem] flex flex-col items-center justify-center text-[#FF3EA5] opacity-40">
                                <svg class="w-12 h-12 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <p class="font-black text-[10px] uppercase tracking-widest text-center px-6 italic">Tidak ada lampiran foto</p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Footer Info --}}
                <div class="mt-12 pt-6 border-t-2 border-dashed border-[#FF3EA5] text-center">
                    <p class="text-[8px] md:text-[9px] font-black uppercase opacity-40 tracking-[0.3em]">Mamacare Digital Health Record System</p>
                </div>
            </div>
        </div>
    </div>

    {{-- 3. MODAL LIGHTBOX (PERBESAR GAMBAR) --}}
    <div x-show="showModal" x-transition.opacity 
         class="fixed inset-0 z-[100] bg-white/90 backdrop-blur-sm flex items-center justify-center p-4 md:p-10" 
         style="display: none;">
        <div class="relative bg-white border-4 border-[#FF3EA5] rounded-[2rem] md:rounded-[3rem] p-2 shadow-[12px_12px_0px_0px_#FF3EA5] max-w-5xl w-full" @click.away="showModal = false">
            {{-- Tombol Close --}}
            <button @click="showModal = false" class="absolute -top-4 -right-4 md:-top-6 md:-right-6 w-10 h-10 md:w-14 md:h-14 bg-white border-4 border-[#FF3EA5] text-[#FF3EA5] font-black text-lg md:text-2xl rounded-full shadow-[4px_4px_0px_0px_#FF3EA5] hover:rotate-90 transition-all">
                X
            </button>
            <img src="{{ asset('storage/' . $rekap->image) }}" class="w-full h-auto max-h-[70vh] md:max-h-[80vh] object-contain rounded-[1.5rem] md:rounded-[2.5rem]">
        </div>
    </div>
</div>
@endsection