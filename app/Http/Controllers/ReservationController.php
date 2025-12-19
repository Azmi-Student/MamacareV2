<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    /**
     * Menampilkan halaman list dokter sekaligus daftar antrian aktif si Mama.
     */
    public function index()
    {
        // 1. Ambil semua data dokter untuk pilihan booking
        $doctors = Doctor::all();

        // 2. Ambil antrian milik Mama yang sedang login
        // Ambil status: pending, confirmed, dan cancelled. 
        // Status 'completed' tidak diambil karena sudah masuk ke halaman Rekap Medis.
        $userAppointments = Appointment::where('user_id', Auth::id())
            ->whereIn('status', ['pending', 'confirmed', 'cancelled'])
            ->with('doctor') // Load relasi dokter agar nama dokter muncul di list antrian
            ->orderBy('date', 'asc')
            ->orderBy('time', 'asc')
            ->get();

        // Pastikan nama view sesuai dengan lokasi file index.blade.php Anda
        return view('page.reservasi-dokter.index', compact('doctors', 'userAppointments'));
    }

    /**
     * Menyimpan data booking baru dari Mama.
     */
    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'date'      => 'required|date|after_or_equal:today',
            'time'      => 'required',
            'notes'     => 'required|string', // Digunakan untuk 'Jenis Pemeriksaan'
        ], [
            // Custom pesan error bahasa Indonesia
            'doctor_id.required' => 'Silakan pilih dokter terlebih dahulu.',
            'date.after_or_equal' => 'Tanggal tidak boleh hari kemarin.',
            'notes.required' => 'Jenis pemeriksaan wajib dipilih.',
        ]);

        // 2. Simpan ke Database
        Appointment::create([
            'user_id'   => Auth::id(), // ID Mama yang login
            'doctor_id' => $request->doctor_id,
            'date'      => $request->date,
            'time'      => $request->time,
            'notes'     => $request->notes, 
            'status'    => 'pending' // Status default saat baru mendaftar
        ]);

        // 3. Kembalikan ke halaman dengan pesan sukses
        // Pastikan nama route 'mama.reservasi' sudah sesuai di web.php Anda
        return redirect()->back()->with('success', 'Janji temu berhasil dibuat! Cek status antrian Anda di bagian bawah halaman ini ya, Bun.');
    }
}