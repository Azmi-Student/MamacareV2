@extends('layouts.app')

@section('title', 'Daftar Pasien - Mamacare')

@section('content')
{{-- Background Putih Bersih --}}
<div class="min-h-screen py-12 bg-white text-[#C21B75] font-sans selection:bg-[#FF3EA5] selection:text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- 1. HEADER SECTION (Neo Brutalist Curvy) --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-12 gap-6 border-b-8 border-[#FF3EA5] pb-10">
            <div>
                <h2 class="text-5xl font-black uppercase tracking-tighter leading-none mb-4">
                    Daftar Pasien
                </h2>
                <div class="inline-block bg-[#FF3EA5] text-white px-4 py-2 border-4 border-[#C21B75] shadow-[6px_6px_0px_0px_#C21B75] rounded-full font-black text-sm uppercase tracking-widest">
                    Jadwal Praktik Dokter
                </div>
            </div>
            
            {{-- Statistik Box --}}
            <div class="bg-white border-4 border-[#C21B75] p-6 rounded-2xl shadow-[8px_8px_0px_0px_#FF3EA5] flex items-center gap-6 min-w-[240px]">
                <div class="bg-[#FF3EA5] text-white w-14 h-14 rounded-xl flex items-center justify-center font-black text-3xl border-2 border-[#C21B75] shadow-[4px_4px_0px_0px_#C21B75]">
                    #
                </div>
                <div>
                    <p class="text-xs font-black uppercase tracking-widest text-[#FF3EA5]">Total Pasien</p>
                    <p class="text-4xl font-black leading-none">{{ $appointments->total() }}</p>
                </div>
            </div>
        </div>

        {{-- 2. TABLE CONTAINER (The Main Brutalist Card) --}}
        <div class="border-4 border-[#C21B75] bg-white shadow-[12px_12px_0px_0px_#FF3EA5] rounded-3xl overflow-hidden mb-10">
            <div class="overflow-x-auto p-4">
                <table class="w-full text-left border-separate border-spacing-y-4">
                    
                    {{-- Table Head --}}
                    <thead>
                        <tr class="text-[#C21B75]">
                            <th scope="col" class="px-6 py-4 font-black uppercase tracking-widest text-sm text-center">No</th>
                            <th scope="col" class="px-6 py-4 font-black uppercase tracking-widest text-sm whitespace-nowrap">Waktu</th>
                            <th scope="col" class="px-6 py-4 font-black uppercase tracking-widest text-sm whitespace-nowrap">Nama Pasien</th>
                            <th scope="col" class="px-6 py-4 font-black uppercase tracking-widest text-sm">Keluhan</th>
                            <th scope="col" class="px-6 py-4 font-black uppercase tracking-widest text-sm text-center">Status</th>
                            <th scope="col" class="px-6 py-4 font-black uppercase tracking-widest text-sm text-center">Aksi</th>
                        </tr>
                    </thead>

                    {{-- Table Body --}}
                    <tbody>
                        @forelse ($appointments as $appointment)
                        <tr class="group">
                            {{-- Kolom Nomor --}}
                            <td class="px-6 py-6 bg-white border-y-4 border-l-4 border-[#C21B75] rounded-l-2xl text-center font-black text-xl group-hover:bg-pink-50 transition-colors">
                                {{ ($appointments->currentPage() - 1) * $appointments->perPage() + $loop->iteration }}
                            </td>

                            {{-- Kolom Waktu --}}
                            <td class="px-6 py-6 bg-white border-y-4 border-[#C21B75] group-hover:bg-pink-50 transition-colors">
                                <div class="flex flex-col">
                                    <span class="text-3xl font-black text-[#FF3EA5] leading-none">{{ $appointment->time }}</span>
                                    <span class="text-xs font-black uppercase text-[#C21B75] mt-2">
                                        {{ \Carbon\Carbon::parse($appointment->date)->isoFormat('dddd, D MMM') }}
                                    </span>
                                </div>
                            </td>

                            {{-- Kolom Pasien --}}
                            <td class="px-6 py-6 bg-white border-y-4 border-[#C21B75] group-hover:bg-pink-50 transition-colors">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-white border-4 border-[#FF3EA5] rounded-full flex items-center justify-center text-lg font-black text-[#FF3EA5] shadow-[3px_3px_0px_0px_#C21B75]">
                                        {{ substr($appointment->user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="font-black text-xl uppercase leading-tight">{{ $appointment->user->name }}</div>
                                        <div class="text-xs font-bold text-[#FF3EA5] tracking-tight uppercase">{{ $appointment->user->email }}</div>
                                    </div>
                                </div>
                            </td>

                            {{-- Kolom Catatan --}}
                            <td class="px-6 py-6 bg-white border-y-4 border-[#C21B75] group-hover:bg-pink-50 transition-colors min-w-[200px]">
                                @if($appointment->notes)
                                    <div class="text-sm font-bold italic border-l-4 border-[#FF3EA5] pl-4 text-[#C21B75] py-1 uppercase">
                                        "{{ Str::limit($appointment->notes, 40) }}"
                                    </div>
                                @else
                                    <span class="text-[10px] font-black text-pink-200 uppercase tracking-widest tracking-[0.2em]">[KOSONG]</span>
                                @endif
                            </td>

                            {{-- Kolom Status --}}
                            <td class="px-6 py-6 bg-white border-y-4 border-[#C21B75] text-center group-hover:bg-pink-50 transition-colors">
                                @php
                                    $statusStyle = match($appointment->status) {
                                        'completed' => 'bg-[#FF3EA5] text-white border-2 border-[#C21B75] shadow-[4px_4px_0px_0px_#C21B75]',
                                        'confirmed' => 'bg-white text-[#FF3EA5] border-2 border-[#FF3EA5] shadow-[4px_4px_0px_0px_#C21B75]',
                                        'cancelled' => 'bg-white text-gray-400 border-2 border-gray-300 opacity-50',
                                        default => 'bg-white text-[#C21B75] border-2 border-dashed border-[#C21B75]', // pending
                                    };
                                @endphp
                                <span class="{{ $statusStyle }} text-[10px] font-black px-4 py-2 rounded-full uppercase tracking-widest inline-block">
                                    {{ $appointment->status }}
                                </span>
                            </td>

                            {{-- Kolom Aksi --}}
                            <td class="px-6 py-6 bg-white border-y-4 border-r-4 border-[#C21B75] rounded-r-2xl text-center group-hover:bg-pink-50 transition-colors">
                                <a href="{{ route('dokter.reservasi.edit', $appointment->id) }}" 
                                   class="inline-block bg-[#FF3EA5] text-white border-2 border-[#C21B75] px-6 py-3 font-black uppercase text-xs rounded-full shadow-[4px_4px_0px_0px_#C21B75] hover:shadow-none hover:translate-x-[2px] hover:translate-y-[2px] active:translate-x-[4px] active:translate-y-[4px] transition-all">
                                    PERIKSA &rarr;
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-20 text-center">
                                <div class="inline-block border-4 border-dashed border-[#FF3EA5] p-10 rounded-3xl bg-pink-50">
                                    <p class="text-2xl font-black uppercase text-[#C21B75] tracking-tighter">Tidak Ada Pasien</p>
                                    <p class="text-sm font-bold text-[#FF3EA5] mt-2 uppercase tracking-widest">Jadwal hari ini kosong!</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- 3. PAGINATION --}}
        <div class="mt-12 flex justify-center">
            <div class="bg-white p-4 border-4 border-[#C21B75] shadow-[8px_8px_0px_0px_#FF3EA5] rounded-2xl">
                {{ $appointments->links() }}
            </div>
        </div>

    </div>
</div>

<style>
    .pagination svg { width: 1.5rem; height: 1.5rem; }
    nav[role="navigation"] span[aria-current="page"] span {
        background-color: #FF3EA5 !important;
        border-color: #C21B75 !important;
        color: white !important;
        border-radius: 9999px !important;
        font-weight: 900 !important;
    }
</style>
@endsection