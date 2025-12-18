<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class DokterController extends Controller
{
    /**
     * Menampilkan halaman dashboard utama untuk Dokter.
     */
    public function index()
    {
        // Mengambil data Mama (Pasien) untuk ditampilkan ke Dokter
        $pasiens = User::where('role', 'mama')->latest()->paginate(10);

        // Menghitung total pasien khusus untuk widget dashboard
        $totalPasien = User::where('role', 'mama')->count();

        return view('dokter.index', compact('pasiens', 'totalPasien'));
    }
}