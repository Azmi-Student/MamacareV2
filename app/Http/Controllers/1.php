<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AdminController extends Controller
{
    /**
     * Menampilkan halaman dashboard utama untuk Admin.
     */
    public function index()
    {
        $data = [
            'totalMama'   => User::where('role', 'mama')->count(),
            'totalDokter' => User::where('role', 'dokter')->count(),
            'totalAdmin'  => User::where('role', 'admin')->count(),
            'users'       => User::latest()->paginate(10), 
        ];

        return view('admin.index', $data);
    }

    /**
     * MENAMPILKAN halaman form tambah user baru.
     */
    public function createUser()
    {
        return view('admin.users.create');
    }

    /**
     * MENAMPILKAN halaman form edit user.
     */
    public function editUser(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * PROSES menyimpan user baru ke database.
     */
    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', Rules\Password::defaults()],
            'role' => ['required', 'in:mama,dokter,admin'],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        // Redirect ke index dashboard dengan pesan sukses
        return redirect()->route('admin.dashboard')->with('success', 'User berhasil ditambahkan!');
    }

    /**
     * PROSES memperbarui data/role user.
     */
    public function updateUser(Request $request, User $user)
    {
        // Jika ingin bisa edit nama/email juga, tambahkan validasinya di sini
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'role' => ['required', 'in:mama,dokter,admin'],
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Data ' . $user->name . ' berhasil diperbarui!');
    }

    /**
     * PROSES menghapus user.
     */
    public function destroyUser(User $user)
    {
        if (auth()->id() === $user->id) {
            return back()->with('error', 'Anda tidak bisa menghapus akun sendiri!');
        }

        $user->delete();
        return back()->with('success', 'User berhasil dihapus!');
    }
}