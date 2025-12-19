@extends('layouts.app')

@section('title', 'Periksa Pasien - Mamacare')

@section('content')
{{-- Background Putih Polos dengan Tipografi Pink Tua --}}
<div class="min-h-screen py-8 md:py-12 bg-white text-[#C21B75] font-sans selection:bg-[#FF3EA5] selection:text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- 1. HEADER SECTION --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10 border-b-8 border-[#FF3EA5] pb-10">
            <div class="flex items-center gap-6">
                {{-- Back Button: Bulat Tebal 3D --}}
                <a href="{{ route('dokter.reservasi.index') }}" 
                   class="flex-shrink-0 w-14 h-14 flex items-center justify-center bg-white border-4 border-[#C21B75] text-[#C21B75] font-black text-3xl rounded-full shadow-[4px_4px_0px_0px_#FF3EA5] hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-none transition-all">
                    &larr;
                </a>
                
                <div>
                    <h2 class="text-3xl md:text-5xl font-black uppercase tracking-tighter leading-none">
                        Pemeriksaan
                    </h2>
                    <div class="mt-2 inline-block bg-[#FF3EA5] text-white px-3 py-1 border-2 border-[#C21B75] shadow-[3px_3px_0px_0px_#C21B75] rounded-full text-xs md:text-sm font-black tracking-widest uppercase">
                        Manajemen Rekam Medis
                    </div>
                </div>
            </div>

            {{-- Status Badge (Desktop Only) --}}
            <div class="hidden md:block">
                <div class="bg-white border-4 border-[#C21B75] px-6 py-3 rounded-2xl shadow-[6px_6px_0px_0px_#FF3EA5]">
                    <span class="block text-[10px] font-black uppercase tracking-[0.2em] mb-1 opacity-60">Status DB</span>
                    <div class="text-xl font-black uppercase italic">{{ $appointment->status == 'pending' ? 'Menunggu' : $appointment->status }}</div>
                </div>
            </div>
        </div>

        {{-- 2. GRID LAYOUT --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            
            {{-- KOLOM KIRI: Data Pasien --}}
            <div class="lg:col-span-1">
                <div class="bg-white border-4 border-[#C21B75] p-8 rounded-[2.5rem] shadow-[10px_10px_0px_0px_#FF3EA5] lg:sticky lg:top-8">
                    
                    {{-- Avatar & Name --}}
                    <div class="flex flex-col items-center mb-8 pb-8 border-b-4 border-dashed border-pink-100">
                        <div class="w-24 h-24 bg-white border-4 border-[#FF3EA5] rounded-full flex items-center justify-center text-4xl font-black text-[#FF3EA5] mb-4 shadow-[4px_4px_0px_0px_#C21B75]">
                            {{ substr($appointment->user->name, 0, 1) }}
                        </div>
                        <h3 class="text-2xl font-black text-center uppercase tracking-tight leading-tight px-2">
                            {{ $appointment->user->name }}
                        </h3>
                        <p class="mt-1 text-sm font-bold text-[#FF3EA5] tracking-wide">{{ $appointment->user->email }}</p>
                    </div>

                    {{-- Info List --}}
                    <div class="space-y-6">
                        <div>
                            <label class="text-[10px] font-black uppercase tracking-widest bg-[#FF3EA5] text-white px-2 py-0.5 rounded-md">Jadwal Periksa</label>
                            <div class="mt-2 text-lg font-black">{{ \Carbon\Carbon::parse($appointment->date)->isoFormat('dddd, D MMMM Y') }}</div>
                            <div class="text-[#FF3EA5] font-black italic">Pukul {{ $appointment->time }} WIB</div>
                        </div>

                        <div>
                            <label class="text-[10px] font-black uppercase tracking-widest bg-[#C21B75] text-white px-2 py-0.5 rounded-md">Keluhan Awal</label>
                            <div class="mt-2 p-4 bg-pink-50 border-2 border-[#C21B75] rounded-2xl text-sm font-bold italic leading-relaxed">
                                "{{ $appointment->notes ?? 'Tidak ada keluhan spesifik.' }}"
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- KOLOM KANAN: Form Update --}}
            <div class="lg:col-span-2">
                {{-- FORM START: Enctype ditambahkan --}}
                <form action="{{ route('dokter.reservasi.update', $appointment->id) }}" method="POST" enctype="multipart/form-data"
                      x-data="{ status: '{{ old('status', $appointment->status) }}' }"> 
                    @csrf
                    @method('PATCH')
                    
                    @php $isCompleted = $appointment->status == 'completed'; @endphp

                    <div class="bg-white border-4 border-[#C21B75] p-6 md:p-10 rounded-[3rem] shadow-[15px_15px_0px_0px_#FF3EA5]">
                        
                        <h3 class="text-2xl md:text-3xl font-black uppercase mb-10 border-b-4 border-[#FF3EA5] pb-4 inline-block tracking-tighter">
                            Update Status
                        </h3>

                        {{-- Timeline Radio --}}
                        <div class="flex flex-col gap-6 mb-10">
                            <label class="relative cursor-pointer group {{ $isCompleted ? 'opacity-40 grayscale pointer-events-none' : '' }}">
                                <input type="radio" name="status" value="pending" x-model="status" class="peer sr-only" {{ $isCompleted ? 'disabled' : '' }}>
                                <div class="flex items-center p-5 border-4 border-[#C21B75] rounded-3xl bg-white group-hover:translate-x-[-4px] group-hover:translate-y-[-4px] group-hover:shadow-[6px_6px_0px_0px_#FF3EA5] transition-all
                                            peer-checked:bg-[#FF3EA5] peer-checked:text-white peer-checked:border-[#C21B75] peer-checked:shadow-[8px_8px_0px_0px_#C21B75]">
                                    <div class="w-10 h-10 border-4 border-current rounded-full flex items-center justify-center font-black mr-4 bg-white text-[#C21B75]">1</div>
                                    <div class="font-black uppercase text-lg tracking-tight">Menunggu (Pending)</div>
                                </div>
                            </label>

                            <label class="relative cursor-pointer group {{ $isCompleted ? 'opacity-40 grayscale pointer-events-none' : '' }}">
                                <input type="radio" name="status" value="confirmed" x-model="status" class="peer sr-only" {{ $isCompleted ? 'disabled' : '' }}>
                                <div class="flex items-center p-5 border-4 border-[#C21B75] rounded-3xl bg-white group-hover:translate-x-[-4px] group-hover:translate-y-[-4px] group-hover:shadow-[6px_6px_0px_0px_#FF3EA5] transition-all
                                            peer-checked:bg-[#FF3EA5] peer-checked:text-white peer-checked:border-[#C21B75] peer-checked:shadow-[8px_8px_0px_0px_#C21B75]">
                                    <div class="w-10 h-10 border-4 border-current rounded-full flex items-center justify-center font-black mr-4 bg-white text-[#C21B75]">2</div>
                                    <div class="font-black uppercase text-lg tracking-tight">Konfirmasi (Confirmed)</div>
                                </div>
                            </label>

                            <label class="relative cursor-pointer group">
                                <input type="radio" name="status" value="completed" x-model="status" class="peer sr-only">
                                <div class="flex items-center p-5 border-4 border-[#C21B75] rounded-3xl bg-white group-hover:translate-x-[-4px] group-hover:translate-y-[-4px] group-hover:shadow-[6px_6px_0px_0px_#FF3EA5] transition-all
                                            peer-checked:bg-[#FF3EA5] peer-checked:text-white peer-checked:border-[#C21B75] peer-checked:shadow-[8px_8px_0px_0px_#C21B75]">
                                    <div class="w-10 h-10 border-4 border-current rounded-full flex items-center justify-center font-black mr-4 bg-white text-[#C21B75]">3</div>
                                    <div class="font-black uppercase text-lg tracking-tight text-left">Selesai & Input Hasil (Completed)</div>
                                </div>
                            </label>
                        </div>

                        <div class="mb-10 pl-2">
                            <label class="inline-flex items-center gap-3 cursor-pointer group">
                                <input type="radio" name="status" value="cancelled" x-model="status" class="w-6 h-6 accent-[#C21B75] border-4 border-[#C21B75]">
                                <span class="font-black text-sm uppercase tracking-widest text-[#C21B75] group-hover:underline">[X] Batalkan Janji Temu</span>
                            </label>
                        </div>

                        {{-- INPUT FORM (Show when Completed) --}}
                        <div x-show="status === 'completed'" 
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0 translate-y-8"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             class="space-y-8 border-t-8 border-[#C21B75] pt-10 mt-10">
                            
                            <h4 class="text-2xl font-black uppercase bg-[#FF3EA5] text-white inline-block px-4 py-1 rounded-lg shadow-[4px_4px_0px_0px_#C21B75]">
                                Rekam Medis Pasien
                            </h4>

                            {{-- Diagnosa --}}
                            <div>
                                <label class="block font-black uppercase text-sm mb-3 ml-1">Diagnosa Dokter <span class="text-[#FF3EA5]">*</span></label>
                                <textarea name="diagnosis" rows="4" 
                                          class="w-full bg-white border-4 border-[#C21B75] rounded-[2rem] p-6 font-bold text-lg focus:ring-0 focus:border-[#FF3EA5] shadow-[6px_6px_0px_0px_#FF3EA5] transition-all placeholder-pink-200"
                                          placeholder="Tuliskan diagnosa pemeriksaan di sini...">{{ old('diagnosis', $appointment->diagnosis) }}</textarea>
                                @error('diagnosis') <p class="mt-3 text-sm font-black text-[#FF3EA5] bg-pink-50 px-2 py-1 inline-block border-2 border-[#FF3EA5] rounded-md uppercase">! {{ $message }}</p> @enderror
                            </div>

                            {{-- Resep --}}
                            <div>
                                <label class="block font-black uppercase text-sm mb-3 ml-1">Resep & Saran Medik</label>
                                <textarea name="prescription" rows="4" 
                                          class="w-full bg-white border-4 border-[#C21B75] rounded-[2rem] p-6 font-bold text-lg focus:ring-0 focus:border-[#FF3EA5] shadow-[6px_6px_0px_0px_#FF3EA5] transition-all placeholder-pink-200"
                                          placeholder="Tuliskan daftar obat atau saran tindakan...">{{ old('prescription', $appointment->prescription) }}</textarea>
                            </div>

                            {{-- UPLOAD GAMBAR --}}
                            <div class="pt-4">
                                <label class="block font-black uppercase text-sm mb-4 ml-1 text-[#C21B75]">Upload Gambar (USG / Lampiran)</label>
                                
                                @if($appointment->image)
                                    <div class="mb-6 p-4 border-4 border-[#FF3EA5] rounded-[2rem] inline-block bg-white shadow-[6px_6px_0px_0px_#C21B75]">
                                        <p class="text-[10px] font-black uppercase mb-2">Lampiran Saat Ini:</p>
                                        <img src="{{ asset('storage/' . $appointment->image) }}" class="w-48 h-48 object-cover rounded-2xl border-2 border-[#C21B75]">
                                    </div>
                                @endif

                                <div class="relative group">
                                    <input type="file" name="image" 
                                           class="w-full bg-white border-4 border-[#C21B75] rounded-full p-4 font-bold text-sm
                                                  file:mr-4 file:py-2 file:px-6 file:rounded-full file:border-0 
                                                  file:text-xs file:font-black file:bg-[#FF3EA5] file:text-white 
                                                  hover:file:bg-[#C21B75] transition-all cursor-pointer shadow-[6px_6px_0px_0px_#FF3EA5]">
                                </div>
                                <p class="mt-3 text-[10px] font-black uppercase text-[#FF3EA5] ml-4 italic">* Maksimal 10MB (JPG, PNG)</p>
                                @error('image') <p class="mt-3 text-sm font-black text-[#FF3EA5] bg-pink-50 px-2 py-1 inline-block border-2 border-[#FF3EA5] rounded-md uppercase">! {{ $message }}</p> @enderror
                            </div>
                        </div>

                        {{-- FOOTER ACTION --}}
                        <div class="mt-12 pt-8 border-t-4 border-[#FF3EA5] flex flex-col-reverse md:flex-row justify-end gap-5">
                            <a href="{{ route('dokter.reservasi.index') }}" 
                               class="text-center px-10 py-4 font-black uppercase border-4 border-[#C21B75] text-[#C21B75] rounded-2xl hover:bg-pink-50 transition-colors tracking-widest">
                                Batal
                            </a>
                            <button type="submit" 
                                    class="text-center px-10 py-4 font-black uppercase bg-[#C21B75] text-white border-4 border-[#C21B75] rounded-2xl shadow-[6px_6px_0px_0px_#FF3EA5] hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-none active:translate-x-[4px] active:translate-y-[4px] transition-all tracking-widest">
                                Simpan Rekam Medis
                            </button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection