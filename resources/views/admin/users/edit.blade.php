@extends('layouts.app')

@section('title', 'Edit User - Mamacare')

@section('content')
<div class="py-12">
    <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
        {{-- Card Container --}}
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-t-4 border-rose-500">
            <div class="p-6 text-gray-900">
                
                {{-- Header --}}
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-xl font-bold text-gray-800">Edit Data User</h3>
                        <p class="text-sm text-gray-500">Perbarui informasi akun untuk {{ $user->name }}</p>
                    </div>
                </div>

                {{-- Form Start --}}
                <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    
                    {{-- Input Nama --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                        <input type="text" name="name" 
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500 transition" 
                               value="{{ old('name', $user->name) }}" required>
                        @error('name') 
                            <span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span> 
                        @enderror
                    </div>

                    {{-- Input Email --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                        <input type="email" name="email" 
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500 transition" 
                               value="{{ old('email', $user->email) }}" required>
                        @error('email') 
                            <span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span> 
                        @enderror
                    </div>

                    {{-- Select Role --}}
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Role / Hak Akses</label>
                        <select name="role" 
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500 transition">
                            <option value="mama" {{ $user->role == 'mama' ? 'selected' : '' }}>Mama</option>
                            <option value="dokter" {{ $user->role == 'dokter' ? 'selected' : '' }}>Dokter</option>
                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                        <p class="mt-2 text-xs text-gray-500 flex items-center gap-1">
                            <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Mengubah role akan mengganti hak akses user ini secara langsung.
                        </p>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="flex justify-end items-center gap-3 pt-4 border-t border-gray-100">
                        {{-- Tombol Batal kembali ke Dashboard Utama --}}
                        <a href="{{ route('admin.dashboard') }}" 
                           class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                             Batal
                        </a>
                        
                        <button type="submit" 
                                class="px-6 py-2 text-sm font-semibold text-white bg-rose-500 rounded-lg hover:bg-rose-600 focus:ring-4 focus:ring-rose-200 transition shadow-md">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection