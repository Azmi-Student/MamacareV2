<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Doctor; // Pastikan model Doctor di-import
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    // Menampilkan Form Create
    public function create()
    {
        return view('admin.users.create');
    }

    // Proses Simpan User Baru
    public function store(Request $request)
    {
        // 1. Validasi Dasar
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:admin,dokter,mama'],
        ];

        // 2. Validasi Tambahan Jika Role Dokter
        if ($request->role === 'dokter') {
            $rules['specialist'] = ['required', 'string', 'max:100'];
            $rules['experience'] = ['required', 'numeric', 'min:0'];
            $rules['description'] = ['nullable', 'string'];
        }

        $request->validate($rules);

        // 3. Simpan ke tabel Users
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        // 4. Simpan ke tabel Doctors jika role-nya dokter
        if ($request->role === 'dokter') {
            Doctor::create([
                'user_id' => $user->id,
                'name' => $request->name, // Mengambil nama dari input user
                'specialist' => $request->specialist,
                'experience' => $request->experience,
                'description' => $request->description,
                'image' => 'https://ui-avatars.com/api/?name=' . urlencode($request->name) . '&background=random', // Foto default
            ]);
        }

        return redirect()->route('admin.dashboard')->with('success', 'User berhasil ditambahkan');
    }
    // Menampilkan Form Edit
    public function edit(User $user)
    {
        // Kita panggil relasi doctor agar datanya bisa dibaca di form
        $user->load('doctor'); 
        return view('admin.users.edit', compact('user'));
    }

    // Proses Update
    public function update(Request $request, User $user)
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'role' => ['required', 'in:admin,dokter,mama'],
        ];

        // Validasi tambahan jika role diubah ke dokter atau memang sudah dokter
        if ($request->role === 'dokter') {
            $rules['specialist'] = ['required', 'string', 'max:100'];
            $rules['experience'] = ['required', 'numeric', 'min:0'];
        }

        $request->validate($rules);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ]);
        
        // Update atau Buat data Dokter
        if ($request->role === 'dokter') {
            Doctor::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'name' => $request->name,
                    'specialist' => $request->specialist,
                    'experience' => $request->experience,
                    'description' => $request->description,
                ]
            );
        } else {
            // Jika role diubah dari dokter ke yang lain, hapus data dokternya (opsional)
            Doctor::where('user_id', $user->id)->delete();
        }

        // Cek update password jika diisi
        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('admin.dashboard')->with('success', 'User berhasil diperbarui');
    }

    // Proses Hapus
    public function destroy(User $user)
    {
        // Karena ada relasi, pastikan data dokter terhapus otomatis (cascade) atau hapus manual di sini
        $user->delete();
        return back()->with('success', 'User berhasil dihapus');
    }
}