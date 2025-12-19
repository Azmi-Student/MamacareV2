@extends('layouts.app')

@section('title', 'Rekap Medis Mama - Mamacare')

@section('content')
<div class="min-h-screen py-8 md:py-12 bg-white text-[#C21B75] font-sans selection:bg-[#FF3EA5] selection:text-white"
     x-data="{ selectedRekap: null, showModal: false }">
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- 1. HEADER --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 md:mb-12 gap-4 border-b-4 md:border-b-8 border-[#FF3EA5] pb-6 md:pb-10">
            <div>
                <h2 class="text-3xl md:text-5xl font-black uppercase tracking-tighter leading-none mb-2 md:mb-4">
                    Rekap Medis
                </h2>
                <div class="inline-block bg-[#FF3EA5] text-white px-3 py-1 md:px-4 md:py-2 border-2 md:border-4 border-[#C21B75] shadow-[4px_4px_0px_0px_#C21B75] rounded-full font-black text-[10px] md:text-sm uppercase tracking-widest">
                    Riwayat Kesehatan Mama
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 md:gap-10 items-start">
            
            {{-- 2. DAFTAR JADWAL (KIRI - 4 Kolom) --}}
            <div class="lg:col-span-4 space-y-4 md:space-y-6">
                <h3 class="text-lg md:text-xl font-black uppercase flex items-center gap-2 px-1">
                    <span class="w-7 h-7 md:w-8 md:h-8 bg-[#C21B75] text-white flex items-center justify-center rounded-lg text-sm">#</span>
                    Pilih Jadwal
                </h3>
                
                <div class="flex flex-col gap-4 max-h-[400px] lg:max-h-[600px] overflow-y-auto pr-2 custom-scrollbar">
                    @forelse ($rekaps as $rekap)
                        <button 
                            @click="selectedRekap = {{ $rekap }}; window.scrollTo({top: 0, behavior: 'smooth'})"
                            :class="selectedRekap && selectedRekap.id === {{ $rekap->id }} ? 'bg-[#FF3EA5] text-white shadow-none translate-x-1 translate-y-1 border-[#C21B75]' : 'bg-white text-[#C21B75] shadow-[4px_4px_0px_0px_#FF3EA5] border-[#C21B75]'"
                            class="w-full text-left p-4 md:p-6 border-2 md:border-4 rounded-[1.5rem] md:rounded-[2rem] transition-all duration-200 group">
                            <p class="text-[9px] md:text-[10px] font-black uppercase tracking-widest opacity-80" :class="selectedRekap && selectedRekap.id === {{ $rekap->id }} ? 'text-white' : 'text-[#FF3EA5]'">
                                {{ \Carbon\Carbon::parse($rekap->date)->isoFormat('dddd, D MMM Y') }}
                            </p>
                            <h4 class="text-base md:text-xl font-black uppercase leading-tight mt-1">Dr. {{ $rekap->doctor->user->name }}</h4>
                            <div class="mt-3 md:mt-4 flex justify-between items-center">
                                <span class="text-[10px] md:text-xs font-bold italic opacity-80">Pukul {{ $rekap->time }}</span>
                                <span class="text-[10px] font-black uppercase tracking-widest border-b-2 border-current" x-show="!(selectedRekap && selectedRekap.id === {{ $rekap->id }})">LIHAT</span>
                            </div>
                        </button>
                    @empty
                        <div class="p-8 border-4 border-dashed border-pink-100 rounded-[2rem] text-center italic font-bold opacity-40 uppercase text-[10px]">
                            Belum ada riwayat periksa.
                        </div>
                    @endforelse
                </div>

                <div class="mt-4">
                    {{ $rekaps->links() }}
                </div>
            </div>

            {{-- 3. DETAIL AREA (KANAN - 8 Kolom) --}}
            <div class="lg:col-span-8 order-first lg:order-last">
                {{-- State Belum Pilih --}}
                <div x-show="!selectedRekap" class="border-4 md:border-8 border-dashed border-pink-50 rounded-[2rem] md:rounded-[3rem] p-10 md:p-20 text-center flex flex-col items-center justify-center min-h-[300px] md:min-h-[500px]">
                    <div class="w-16 h-16 md:w-20 md:h-20 bg-pink-50 rounded-full flex items-center justify-center text-[#FF3EA5] mb-4 md:mb-6">
                        <svg class="w-8 h-8 md:w-10 md:h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5"></path></svg>
                    </div>
                    <h3 class="text-xl md:text-2xl font-black uppercase tracking-tight">Pilih riwayat jadwal</h3>
                    <p class="text-[10px] md:text-xs font-bold opacity-50 uppercase tracking-widest mt-2">Detail diagnosa akan muncul di sini</p>
                </div>

                {{-- State Detail Terpilih --}}
                <div x-show="selectedRekap" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     class="bg-white border-2 md:border-4 border-[#C21B75] rounded-[2rem] md:rounded-[3rem] shadow-[8px_8px_0px_0px_#FF3EA5] overflow-hidden">
                    
                    {{-- Status Banner --}}
                    <div class="bg-[#C21B75] text-white px-6 py-2 md:py-3 flex justify-between items-center border-b-2 md:border-b-4 border-[#C21B75]">
                        <span class="text-[9px] md:text-xs font-black uppercase tracking-widest">Informasi Medis</span>
                        <span class="text-[9px] md:text-xs font-black uppercase tracking-widest bg-white text-[#C21B75] px-2 py-0.5 rounded shadow-[2px_2px_0px_0px_#FF3EA5]">Selesai</span>
                    </div>

                    <div class="p-6 md:p-10">
                        <div class="flex flex-col sm:flex-row justify-between items-start border-b-2 md:border-b-4 border-dashed border-pink-100 pb-6 mb-8 gap-4">
                            <div>
                                <p class="text-[10px] font-black uppercase text-[#FF3EA5] mb-1">DOKTER</p>
                                <h3 class="text-2xl md:text-4xl font-black uppercase tracking-tighter" x-text="'DR. ' + selectedRekap.doctor.user.name"></h3>
                            </div>
                            <div class="bg-white text-[#C21B75] px-4 py-2 border-2 md:border-4 border-[#C21B75] rounded-xl font-black text-sm md:text-lg shadow-[4px_4px_0px_0px_#FF3EA5] uppercase whitespace-nowrap" 
                                 x-text="selectedRekap.date"></div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-10">
                            <div class="space-y-6 md:space-y-8">
                                <div>
                                    <label class="block text-[10px] font-black uppercase tracking-widest mb-2 text-[#FF3EA5]">DIAGNOSA</label>
                                    <div class="p-4 md:p-6 bg-pink-50 border-2 md:border-4 border-[#C21B75] rounded-[1.5rem] md:rounded-[2rem] font-bold text-sm md:text-base leading-relaxed" x-text="selectedRekap.diagnosis"></div>
                                </div>

                                <div>
                                    <label class="block text-[10px] font-black uppercase tracking-widest mb-2 text-[#FF3EA5]">RESEP & SARAN</label>
                                    <div class="p-4 md:p-6 bg-white border-2 md:border-4 border-[#C21B75] rounded-[1.5rem] md:rounded-[2rem] font-bold text-sm md:text-base shadow-[4px_4px_0px_0px_#FF3EA5] whitespace-pre-line leading-relaxed" x-text="selectedRekap.prescription"></div>
                                </div>
                            </div>

                            <div>
                                <label class="block text-[10px] font-black uppercase tracking-widest mb-2 text-[#FF3EA5]">LAMPIRAN USG</label>
                                <template x-if="selectedRekap.image">
                                    <div @click="showModal = true" class="cursor-pointer border-2 md:border-4 border-[#C21B75] rounded-[1.5rem] md:rounded-[2rem] overflow-hidden shadow-[6px_6px_0px_0px_#FF3EA5] transition-transform active:scale-95 group relative">
                                        <img :src="'/storage/' + selectedRekap.image" class="w-full h-48 md:h-64 object-cover" />
                                        <div class="absolute inset-0 bg-[#FF3EA5]/20 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-all">
                                            <span class="bg-white border-2 border-[#C21B75] px-3 py-1 font-black uppercase text-[9px] shadow-[2px_2px_0px_0px_#C21B75]">KLIK PERBESAR</span>
                                        </div>
                                    </div>
                                </template>
                                <template x-if="!selectedRekap.image">
                                    <div class="h-48 md:h-64 border-2 md:border-4 border-dashed border-pink-100 rounded-[1.5rem] md:rounded-[2rem] flex flex-col items-center justify-center text-pink-200 bg-gray-50/30">
                                        <svg class="w-10 h-10 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        <span class="font-black text-[9px] uppercase tracking-widest text-center px-4">Tidak ada lampiran</span>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL LIGHTBOX (PERBESAR GAMBAR) --}}
    <div x-show="showModal" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         class="fixed inset-0 z-[99] bg-[#C21B75]/90 backdrop-blur-sm p-4 md:p-10 flex items-center justify-center"
         style="display: none;">
        
        <div class="relative bg-white border-4 md:border-8 border-[#C21B75] rounded-[2rem] md:rounded-[3.5rem] p-3 md:p-6 shadow-[10px_10px_0px_0px_#FF3EA5] max-w-4xl w-full"
             @click.away="showModal = false">
            
            {{-- Tombol Close --}}
            <button @click="showModal = false" class="absolute -top-4 -right-4 md:-top-6 md:-right-6 w-10 h-10 md:w-14 md:h-14 bg-[#FF3EA5] border-2 md:border-4 border-[#C21B75] text-white font-black text-lg md:text-2xl rounded-full shadow-[4px_4px_0px_0px_#C21B75] hover:scale-110 active:scale-90 transition-all z-20">
                X
            </button>

            <div class="overflow-hidden rounded-[1.2rem] md:rounded-[2.5rem]">
                <img :src="'/storage/' + (selectedRekap ? selectedRekap.image : '')" class="w-full h-auto max-h-[70vh] object-contain mx-auto">
            </div>

            <div class="mt-4 text-center">
                <span class="inline-block bg-pink-50 border-2 border-[#C21B75] px-4 py-1 rounded-full text-[9px] md:text-xs font-black uppercase text-[#C21B75]">
                    Dokumentasi Hasil Pemeriksaan MamaCare
                </span>
            </div>
        </div>
    </div>
</div>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 5px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #FF3EA5; border-radius: 10px; }
</style>
@endsection