@extends('layouts.app')

@section('title', 'Tambah User - Mamacare')

@section('content')
<div class="py-12">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Card Container --}}
        <div class="bg-white overflow-hidden rounded-3xl border-2 border-[#FF3EA5] shadow-[6px_6px_0px_0px_#FF3EA5]">
            <div class="p-8">
                
                {{-- Header --}}
                <div class="flex justify-between items-center mb-8 border-b-2 border-pink-100 pb-4">
                    <h3 class="text-2xl font-black text-[#FF3EA5] uppercase">Tambah Pengguna Baru</h3>
                    <a href="{{ route('admin.dashboard') }}" class="text-sm font-bold text-pink-400 hover:text-[#C21B75] hover:underline transition">
                        &larr; Kembali
                    </a>
                </div>

                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf
                    
                    {{-- Nama --}}
                    <div class="mb-5">
                        <label class="block text-xs font-black text-[#C21B75] uppercase mb-2">Nama Lengkap</label>
                        <input type="text" name="name" 
                            class="w-full rounded-xl border-2 border-pink-200 focus:border-[#FF3EA5] focus:ring-[#FF3EA5] text-gray-700 font-medium placeholder-pink-200" 
                            placeholder="Masukkan nama lengkap"
                            value="{{ old('name') }}" required>
                        @error('name') <span class="text-red-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    {{-- Email --}}
                    <div class="mb-5">
                        <label class="block text-xs font-black text-[#C21B75] uppercase mb-2">Email Address</label>
                        <input type="email" name="email" 
                            class="w-full rounded-xl border-2 border-pink-200 focus:border-[#FF3EA5] focus:ring-[#FF3EA5] text-gray-700 font-medium placeholder-pink-200" 
                            placeholder="contoh@email.com"
                            value="{{ old('email') }}" required>
                        @error('email') <span class="text-red-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    {{-- Grid untuk Password --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                        {{-- Password --}}
                        <div>
                            <label class="block text-xs font-black text-[#C21B75] uppercase mb-2">Password</label>
                            <input type="password" name="password" 
                                class="w-full rounded-xl border-2 border-pink-200 focus:border-[#FF3EA5] focus:ring-[#FF3EA5] text-gray-700 font-medium" 
                                placeholder="Min. 3 karakter" required>
                            @error('password') <span class="text-red-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        {{-- Konfirmasi Password (YANG TADI HILANG) --}}
                        <div>
                            <label class="block text-xs font-black text-[#C21B75] uppercase mb-2">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" 
                                class="w-full rounded-xl border-2 border-pink-200 focus:border-[#FF3EA5] focus:ring-[#FF3EA5] text-gray-700 font-medium" 
                                placeholder="Ulangi password" required>
                        </div>
                    </div>

                    {{-- Role Selection --}}
                    <div class="mb-8">
                        <label class="block text-xs font-black text-[#C21B75] uppercase mb-2">Role Pengguna</label>
                        <select name="role" class="w-full rounded-xl border-2 border-pink-200 focus:border-[#FF3EA5] focus:ring-[#FF3EA5] text-gray-700 font-bold bg-white">
                            <option value="mama" {{ old('role') == 'mama' ? 'selected' : '' }}>Mama (Pasien)</option>
                            <option value="dokter" {{ old('role') == 'dokter' ? 'selected' : '' }}>Dokter</option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </div>

                    {{-- Tombol Submit --}}
                    <div class="flex justify-end">
                        <button type="submit" class="bg-[#FF3EA5] text-white px-8 py-3 rounded-xl font-black uppercase tracking-wide border-2 border-[#FF3EA5] shadow-[4px_4px_0px_0px_#C21B75] hover:shadow-none hover:translate-x-[2px] hover:translate-y-[2px] transition-all">
                            Simpan Data User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection