@extends('layouts.app')

@section('title', 'Dashboard Dokter - Mamacare')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6 text-gray-900">
                <h3 class="text-lg font-bold mb-4 text-indigo-700">Panel Konsultasi Dokter</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="p-4 bg-green-100 border-l-4 border-green-500 rounded">
                        <p class="text-sm text-green-600 font-semibold uppercase">Total Pasien (Mama)</p>
                        <p class="text-2xl font-bold">{{ $totalPasien }}</p>
                    </div>
                    <div class="p-4 bg-blue-100 border-l-4 border-blue-500 rounded">
                        <p class="text-sm text-blue-600 font-semibold uppercase">Status Dokter</p>
                        <p class="text-2xl font-bold">Aktif / Terverifikasi</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h3 class="text-md font-bold mb-4">Daftar Pasien Mama Terdaftar</h3>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b">
                                <th class="p-3 text-sm font-semibold text-gray-700">Nama Pasien</th>
                                <th class="p-3 text-sm font-semibold text-gray-700">Email</th>
                                <th class="p-3 text-sm font-semibold text-center text-gray-700">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pasiens as $pasien)
                            <tr class="border-b hover:bg-gray-50 transition">
                                <td class="p-3 text-sm text-gray-800">{{ $pasien->name }}</td>
                                <td class="p-3 text-sm text-gray-600">{{ $pasien->email }}</td>
                                <td class="p-3 text-center">
                                    <button class="bg-indigo-500 text-white px-3 py-1 rounded text-xs hover:bg-indigo-600 transition">
                                        Lihat Detail / Rekam Medis
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="p-4 text-center text-gray-500 italic">Belum ada pasien mama yang terdaftar.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $pasiens->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection