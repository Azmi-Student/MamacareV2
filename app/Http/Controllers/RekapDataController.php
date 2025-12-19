<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;

class RekapDataController extends Controller
{
    public function index()
    {
        // Ambil data milik Mama yang sedang login
        // Hanya yang statusnya 'completed' (sudah diperiksa)
        $rekaps = Appointment::where('user_id', auth()->id())
            ->where('status', 'completed')
            ->with('doctor.user') // Ambil info Dokter
            ->orderBy('date', 'desc')
            ->paginate(10);

        return view('page.rekap-data.index', compact('rekaps'));
    }
}