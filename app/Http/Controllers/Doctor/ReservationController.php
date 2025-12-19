<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;

class ReservationController extends Controller
{
    /**
     * Menampilkan daftar reservasi pasien (Index)
     */
    public function index()
    {
        // Ambil data dokter yang sedang login
        $dokter = auth()->user()->doctor;

        if (!$dokter) {
            abort(403, 'Profil Dokter belum disetting. Harap hubungi Admin.');
        }

        // Ambil Appointment milik dokter ini
        $appointments = Appointment::where('doctor_id', $dokter->id)
            ->with('user')
            ->orderBy('date', 'desc') // Tanggal terbaru di atas
            ->orderBy('time', 'asc')
            ->paginate(10);

        return view('dokter.reservasi.index', compact('appointments'));
    }

    /**
     * Menampilkan form edit/periksa pasien
     */
    public function edit($id)
    {
        $dokter = auth()->user()->doctor;

        // Pastikan appointment ini milik dokter yang login
        $appointment = Appointment::where('id', $id)
            ->where('doctor_id', $dokter->id)
            ->with('user')
            ->firstOrFail();
        
        return view('dokter.reservasi.edit', compact('appointment'));
    }

    /**
     * Menyimpan hasil pemeriksaan (Update status & notes)
     */
    public function update(Request $request, $id)
{
    $dokter = auth()->user()->doctor;

    $request->validate([
        'status'       => 'required|in:pending,confirmed,completed,cancelled',
        'diagnosis'    => 'required_if:status,completed|nullable|string',
        'prescription' => 'nullable|string',
        'image'        => 'nullable|image|mimes:jpeg,png,jpg|max:10240', // Maksimal 10MB
    ], [
        'diagnosis.required_if' => 'Wajib mengisi Diagnosa Medis jika status kunjungan Selesai.',
        'image.max' => 'Ukuran gambar terlalu besar, maksimal 10MB.',
    ]);

    $appointment = Appointment::where('id', $id)
        ->where('doctor_id', $dokter->id)
        ->firstOrFail();

    if ($appointment->status == 'completed' && ($request->status == 'pending' || $request->status == 'confirmed')) {
        return back()->withErrors(['status' => 'Data Selesai tidak bisa dikembalikan ke status awal.']);
    }

    $data = $request->only(['status', 'diagnosis', 'prescription']);

    if ($request->hasFile('image')) {
        // Hapus file lama jika ada
        if ($appointment->image && \Illuminate\Support\Facades\Storage::exists('public/' . $appointment->image)) { 
            \Illuminate\Support\Facades\Storage::delete('public/' . $appointment->image); 
        }
        
        $path = $request->file('image')->store('pemeriksaan', 'public');
        $data['image'] = $path;
    }

    $appointment->update($data);

    return redirect()->route('dokter.reservasi.index')
        ->with('success', 'Hasil pemeriksaan berhasil disimpan!');
}
}