@extends('layouts.app')

@section('title', 'Reservasi Dokter & Bidan')

@section('content')
    <div class="container mx-auto px-4 pt-4 pb-24" x-data="{
        isModalOpen: false,
        selectedDoctor: null,
        selectedDate: '',
        selectedTime: '',
        selectedService: '',
    
        openBooking(doctor) {
            this.selectedDoctor = doctor;
            this.isModalOpen = true;
            this.selectedTime = '';
            this.selectedDate = '';
            this.selectedService = '';
            document.body.style.overflow = 'hidden';
        },
    
        closeBooking() {
            this.isModalOpen = false;
            document.body.style.overflow = 'auto';
        },
    
        get isFormComplete() {
            return this.selectedDate !== '' && this.selectedTime !== '' && this.selectedService !== '';
        }
    }" @keydown.escape.window="closeBooking()">

        {{-- 1. TOMBOL KEMBALI --}}
        <div class="mb-6">
            <a href="{{ route('dashboard') }}"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border-2 border-[#FF3EA5] text-[#FF3EA5] font-black uppercase rounded-xl shadow-[3px_3px_0px_0px_#FF3EA5] hover:shadow-none hover:translate-x-[1px] hover:translate-y-[1px] transition-all text-xs md:text-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                    </path>
                </svg>
                Kembali ke Dashboard
            </a>
        </div>

        {{-- 2. HEADER SECTION --}}
        <div class="mb-10 text-center">
            <h1 class="text-3xl md:text-5xl font-black text-[#FF3EA5] uppercase tracking-tight mb-3 drop-shadow-sm">
                Jadwal Dokter
            </h1>
            <div class="inline-block bg-white border-2 border-[#FF3EA5] p-3 rounded-2xl shadow-[4px_4px_0px_0px_#FF3EA5]">
                <p class="text-sm font-bold text-[#C21B75]">
                    Pilih layanan terbaik untuk memantau perkembangan Si Kecil.
                </p>
            </div>
        </div>

        {{-- 3. FLASH MESSAGE --}}
        @if (session('success'))
            <div
                class="mb-8 bg-pink-50 border-2 border-[#FF3EA5] text-[#C21B75] p-4 rounded-2xl font-bold flex items-center gap-3 shadow-[4px_4px_0px_0px_#FF3EA5]">
                <div class="bg-[#FF3EA5] text-white rounded-full p-1">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                {{ session('success') }}
            </div>
        @endif

        {{-- 4. GRID DOKTER --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
            @forelse ($doctors as $doctor)
                <div
                    class="group bg-white rounded-3xl border-2 border-[#FF3EA5] shadow-[6px_6px_0px_0px_#FF3EA5] overflow-hidden hover:-translate-y-1 hover:shadow-[8px_8px_0px_0px_#FF3EA5] transition-all duration-300 flex flex-col h-full">

                    {{-- Header Kartu --}}
                    <div class="bg-pink-50 p-5 flex items-center gap-4 border-b-2 border-[#FF3EA5]">
                        <img src="{{ $doctor->image }}" alt="{{ $doctor->name }}"
                            class="w-16 h-16 rounded-full border-2 border-[#FF3EA5] object-cover bg-white shadow-sm flex-none">

                        <div class="flex-1 min-w-0">
                            <h3 class="text-lg font-black text-[#C21B75] uppercase leading-tight truncate mb-1">
                                {{ $doctor->name }}
                            </h3>
                            <span
                                class="inline-block bg-[#FF3EA5] text-white text-[10px] font-bold px-2 py-0.5 rounded-lg border-2 border-[#FF3EA5]">
                                {{ $doctor->specialist }}
                            </span>
                        </div>
                    </div>

                    {{-- Body Kartu --}}
                    <div class="p-5 flex-1 flex flex-col">
                        <div
                            class="flex items-center gap-2 mb-4 text-xs font-bold text-[#FF3EA5] bg-white border-2 border-[#FF3EA5] p-3 rounded-xl w-max">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                </path>
                            </svg>
                            Pengalaman {{ $doctor->experience }} Tahun
                        </div>

                        <div class="mb-6 flex-1">
                            <p class="text-sm font-bold text-[#C21B75]/80 leading-relaxed italic">
                                "{{ $doctor->description }}"
                            </p>
                        </div>

                        <button @click="openBooking({{ $doctor }})"
                            class="mt-auto w-full py-3 bg-[#FF3EA5] text-white text-sm font-black uppercase tracking-wider rounded-xl border-2 border-[#FF3EA5] shadow-[4px_4px_0px_0px_#ff90c8] hover:shadow-none hover:translate-x-[2px] hover:translate-y-[2px] transition-all">
                            Buat Janji Temu
                        </button>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12 bg-white rounded-3xl border-2 border-[#FF3EA5] border-dashed">
                    <p class="text-[#FF3EA5] font-bold">Belum ada data dokter tersedia.</p>
                </div>
            @endforelse
        </div>

        {{-- 5. BAGIAN STATUS ANTRIAN SAYA --}}
        <div class="mt-20 border-t-4 border-dashed border-pink-200 pt-10">
            <h2 class="text-2xl md:text-3xl font-black text-[#FF3EA5] uppercase mb-8 tracking-tight">
                Antrian Aktif Saya
            </h2>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                @forelse ($userAppointments as $app)
                    <div
                        class="bg-white border-2 border-[#C21B75] rounded-[2rem] overflow-hidden shadow-[6px_6px_0px_0px_#FF3EA5] flex flex-col sm:flex-row items-stretch transition-transform hover:scale-[1.01]">

                        {{-- Sisi Kiri: Waktu & Tanggal --}}
                        <div
                            class="bg-pink-50 border-b-2 sm:border-b-0 sm:border-r-2 border-[#C21B75] p-6 flex flex-col items-center justify-center min-w-[140px] shrink-0 text-center">
                            <p class="text-[10px] font-black uppercase text-[#C21B75] opacity-60">Waktu</p>
                            <p class="text-2xl font-black text-[#FF3EA5] leading-none my-1">{{ $app->time }}</p>
                            <p class="text-[10px] font-bold text-[#C21B75] uppercase whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($app->date)->isoFormat('D MMM YYYY') }}</p>
                        </div>

                        {{-- Sisi Kanan: Info Lengkap --}}
                        <div class="p-6 flex-1 flex flex-col justify-between gap-4">
                            <div>
                                <p class="text-[10px] font-black uppercase text-[#FF3EA5] tracking-widest mb-1">Dokter
                                    Pemeriksa</p>
                                <h4 class="text-xl font-black uppercase text-[#C21B75] leading-tight">
                                    {{ $app->doctor->name }}
                                </h4>
                                <p class="text-xs font-bold opacity-60 mt-1 uppercase italic tracking-tight">
                                    {{ $app->notes }}</p>
                            </div>

                            <div class="flex items-center justify-between mt-2">
                                {{-- Logika Status Sama Seperti Sebelumnya --}}
                                @php
                                    $statusStyle = match ($app->status) {
                                        'confirmed' => 'bg-[#FF3EA5] text-white border-[#C21B75]',
                                        'cancelled' => 'bg-gray-100 text-gray-400 border-gray-300',
                                        default => 'bg-white text-[#FF3EA5] border-[#FF3EA5] border-dashed',
                                    };
                                    $statusLabel = match ($app->status) {
                                        'confirmed' => 'SIAP DATANG',
                                        'cancelled' => 'DIBATALKAN',
                                        default => 'MENUNGGU',
                                    };
                                @endphp
                                <div class="flex flex-col">
                                    <span class="text-[9px] font-black uppercase mb-1 opacity-50 text-[#C21B75]">Status
                                        Antrian</span>
                                    <span
                                        class="{{ $statusStyle }} px-4 py-1.5 border-2 rounded-full font-black text-[10px] uppercase shadow-[3px_3px_0px_0px_#C21B75]">
                                        {{ $statusLabel }}
                                    </span>
                                </div>

                                <div
                                    class="w-10 h-10 rounded-2xl bg-white flex items-center justify-center text-[#FF3EA5] border-2 border-[#FF3EA5]">
                                    @if ($app->status == 'confirmed')
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    @else
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div
                        class="col-span-full bg-pink-50 border-2 border-dashed border-[#FF3EA5] rounded-[2rem] p-12 text-center shadow-[4px_4px_0px_0px_#FF3EA5]">
                        <p class="text-sm font-bold text-[#C21B75] opacity-50 uppercase tracking-widest leading-loose">
                            Mama belum memiliki antrian aktif.
                        </p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- 6. MODAL FORM --}}
        <div x-show="isModalOpen" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center p-4"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

            <div class="absolute inset-0 bg-[#FF3EA5]/80 backdrop-blur-sm" @click="closeBooking()"></div>

            <div class="bg-white w-full max-w-lg rounded-3xl border-4 border-white shadow-2xl relative z-10 flex flex-col max-h-[85vh]"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-10 scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 scale-100">

                <div
                    class="bg-pink-50 p-6 border-b-2 border-pink-100 flex justify-between items-start flex-none rounded-t-3xl">
                    <div>
                        <h2 class="text-xl md:text-2xl font-black text-[#FF3EA5] uppercase leading-none mb-1">Form Reservasi
                        </h2>
                        <p class="text-[10px] md:text-xs font-bold text-[#C21B75]">Lengkapi data di bawah ini</p>
                    </div>
                    <button @click="closeBooking()"
                        class="text-[#FF3EA5] hover:text-[#C21B75] hover:rotate-90 transition-all bg-white p-2 rounded-xl border-2 border-pink-100 hover:border-[#FF3EA5] hover:shadow-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <div class="p-6 overflow-y-auto flex-1">
                    <form action="{{ route('mama.reservasi.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="doctor_id" :value="selectedDoctor?.id">

                        <div
                            class="flex items-center gap-3 mb-6 p-3 bg-white border-2 border-[#FF3EA5] rounded-2xl border-dashed">
                            <div
                                class="w-10 h-10 flex-none rounded-full bg-pink-100 flex items-center justify-center text-[#FF3EA5]">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <p class="text-[10px] font-bold text-pink-400 uppercase">Dokter Tujuan</p>
                                <p class="text-sm font-black text-[#C21B75] truncate" x-text="selectedDoctor?.name"></p>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-xs font-black uppercase text-[#FF3EA5] mb-2 ml-1">Tanggal
                                Kunjungan</label>
                            <input type="date" name="date" required min="{{ date('Y-m-d') }}"
                                x-model="selectedDate"
                                class="w-full bg-pink-50 border-2 border-pink-100 rounded-xl p-3 font-bold text-sm text-[#C21B75] focus:outline-none focus:border-[#FF3EA5] focus:bg-white focus:ring-4 focus:ring-pink-100 transition-all">
                        </div>

                        <div class="mb-4">
                            <label class="block text-xs font-black uppercase text-[#FF3EA5] mb-2 ml-1">Layanan</label>
                            <div class="relative">
                                <select name="notes" x-model="selectedService" required
                                    class="w-full bg-pink-50 border-2 border-pink-100 rounded-xl p-3 font-bold text-sm text-[#C21B75] focus:outline-none focus:border-[#FF3EA5] focus:bg-white focus:ring-4 focus:ring-pink-100 transition-all appearance-none cursor-pointer">
                                    <option value="" disabled selected class="text-pink-300">Pilih Layanan...
                                    </option>
                                    <option value="Kontrol Kandungan Rutin">Kontrol Kandungan Rutin</option>
                                    <option value="USG 2D/4D">USG 2D / 4D</option>
                                    <option value="Cek Detak Jantung Janin">Cek Detak Jantung Janin</option>
                                    <option value="Konsultasi Keluhan">Konsultasi Keluhan</option>
                                    <option value="Program Hamil">Program Hamil</option>
                                </select>
                                <div
                                    class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-[#FF3EA5]">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                            d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="mb-8">
                            <label class="block text-xs font-black uppercase text-[#FF3EA5] mb-2 ml-1">Pilih Waktu</label>
                            <div class="grid grid-cols-4 gap-2">
                                @foreach (['09:00', '10:00', '11:00', '13:00', '14:00', '16:00', '19:00', '20:00'] as $time)
                                    <label class="cursor-pointer group">
                                        <input type="radio" name="time" value="{{ $time }}"
                                            class="peer sr-only" x-model="selectedTime">
                                        <div
                                            class="text-center py-2.5 border-2 border-pink-100 bg-white rounded-xl text-xs font-bold text-pink-300 
                                                    peer-checked:bg-[#FF3EA5] peer-checked:text-white peer-checked:border-[#FF3EA5] peer-checked:shadow-md
                                                    hover:border-pink-300 transition-all">
                                            {{ $time }}
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <button type="submit" :disabled="!isFormComplete"
                            :class="isFormComplete ?
                                'bg-[#FF3EA5] text-white shadow-[0px_4px_0px_0px_#c21b75] hover:shadow-[0px_2px_0px_0px_#c21b75] hover:translate-y-[2px] cursor-pointer' :
                                'bg-pink-100 text-white border-pink-100 cursor-not-allowed shadow-none'"
                            class="w-full py-4 font-black uppercase rounded-xl border-2 border-transparent transition-all duration-300 mb-2">
                            <span x-text="isFormComplete ? 'Konfirmasi Booking' : 'Lengkapi Data Dulu'"></span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
