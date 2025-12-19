<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Ambil data dokter yang login
        $dokter = auth()->user()->doctor;

        // 2. Hitung statistik
        // a. Total Pasien (Semua waktu)
        $totalPasien = $dokter ? $dokter->appointments()->count() : 0;
        
        // b. Pasien Hari Ini (Tambahan)
        $pasienHariIni = $dokter ? $dokter->appointments()->where('date', date('Y-m-d'))->count() : 0;

        // 3. Ambil Daftar User 'Mama' untuk tabel
        $pasiens = User::where('role', 'mama')->latest()->paginate(5);

        // 4. Return ke view
        return view('dokter.index', compact('totalPasien', 'pasiens', 'pasienHariIni'));
    }
}