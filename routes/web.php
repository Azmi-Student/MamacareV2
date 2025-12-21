<?php

use Illuminate\Support\Facades\Route;

// --- AUTH CONTROLLERS ---
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ArtikelController;

// --- MAMA CONTROLLERS ---
use App\Http\Controllers\DashboardController; // Dashboard Mama
use App\Http\Controllers\KalenderKehamilanController;
use App\Http\Controllers\ReservationController; // Reservasi Mama
use App\Http\Controllers\ChatController;
use App\Http\Controllers\RekapDataController;
use App\Http\Controllers\TanyaDokterController;

// --- ADMIN CONTROLLERS ---
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;

// --- DOKTER CONTROLLERS ---
// Menggunakan Alias agar tidak bentrok dengan Dashboard Mama
use App\Http\Controllers\Doctor\DashboardController as DoctorDashboardController; 
use App\Http\Controllers\Doctor\ReservationController as DoctorReservationController;
use App\Http\Controllers\Doctor\JawabPasienController as JawabPasienController;
use App\Http\Controllers\Doctor\KelolaArtikelController as DoctorKelolaArtikelController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// --- GOOGLE LOGIN ---
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);


// --- AUTHENTICATED ROUTES ---
Route::middleware('auth')->group(function () {

    // 1. Role: MAMA
    Route::middleware('role:mama')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Fitur: Kalender Kehamilan
        // SAYA KEMBALIKAN NAMANYA PERSIS SEPERTI DULU (Manual Naming)
        Route::prefix('kalender-kehamilan')->group(function () {
            Route::get('/', [KalenderKehamilanController::class, 'index'])->name('mama.kalender'); // Nama Route Kembali Asal
            Route::get('/detail', [KalenderKehamilanController::class, 'detail'])->name('mama.kalender.detail');
            Route::get('/reset', [KalenderKehamilanController::class, 'reset'])->name('mama.kalender.reset');
            Route::post('/update-checklist', [KalenderKehamilanController::class, 'updateChecklist'])->name('mama.kalender.update_checklist');
        });

        // Fitur: Reservasi Dokter (Sisi Mama)
        Route::get('/reservasi-dokter', [ReservationController::class, 'index'])->name('mama.reservasi');
        Route::post('/reservasi-dokter', [ReservationController::class, 'store'])->name('mama.reservasi.store');

        // Fitur: Mama AI
        Route::get('/mama-ai', [ChatController::class, 'index'])->name('mama.ai');
        Route::post('/mama-ai/send', [ChatController::class, 'chat'])->name('mama.ai.send');

        // Fitur: Rekap Data Pemeriksaan\
        Route::get('/rekap-data', [RekapDataController::class, 'index'])->name('mama.rekap-data');
        Route::get('/rekap-data/{id}', [RekapDataController::class, 'detail'])->name('mama.rekap-data.detail');

        // Fitur: Tanya Dokter
Route::get('/tanya-dokter', [TanyaDokterController::class, 'index'])->name('mama.tanya-dokter');

// Tambahkan Route baru ini untuk halaman chat terpisah
Route::get('/tanya-dokter/chat/{id}', [TanyaDokterController::class, 'chat'])->name('mama.tanya-dokter.chat');

// API Routes (untuk Fetch Data di background)
Route::get('/tanya-dokter/messages/{doctorId}', [TanyaDokterController::class, 'getMessages']);
Route::post('/tanya-dokter/send', [TanyaDokterController::class, 'sendMessage']);
    });


    // 2. Role: ADMIN
Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard (Stats)
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Manajemen Users (CRUD)
    Route::prefix('users')->name('users.')->group(function () {
        // Perhatikan: Saya sederhanakan nama functionnya (create, store, edit, dst)
        Route::get('/create', [AdminUserController::class, 'create'])->name('create');
        Route::post('/', [AdminUserController::class, 'store'])->name('store');
        
        Route::get('/{user}/edit', [AdminUserController::class, 'edit'])->name('edit');
        Route::patch('/{user}', [AdminUserController::class, 'update'])->name('update');
        Route::delete('/{user}', [AdminUserController::class, 'destroy'])->name('destroy');
    });
});


    // 3. Role: DOKTER
Route::middleware('role:dokter')->prefix('dokter')->name('dokter.')->group(function () {
    
    // Dashboard Dokter (Logic sudah pakai Controller Baru)
    Route::get('/dashboard', [DoctorDashboardController::class, 'index'])->name('dashboard');

    // Manajemen Pasien / Reservasi (Sisi Dokter)
    Route::prefix('reservasi')->name('reservasi.')->group(function () {
        // Halaman Daftar Pasien (Index)
        Route::get('/', [DoctorReservationController::class, 'index'])->name('index');
        
        // Halaman Form Periksa (Edit)
        Route::get('/{id}/edit', [DoctorReservationController::class, 'edit'])->name('edit');
        
        // Proses Simpan Data Pemeriksaan (Update)
        Route::patch('/{id}', [DoctorReservationController::class, 'update'])->name('update');
    });

    // Fitur: Jawab Pasien (Chat Dokter)
    Route::prefix('jawab-pasien')->name('chat.')->group(function () {
        // Halaman Utama Chat
        Route::get('/', [JawabPasienController::class, 'index'])->name('index');
        
        // API Internal: Ambil Pesan
        Route::get('/messages/{userId}', [JawabPasienController::class, 'getMessages'])->name('messages');
        
        // API Internal: Kirim Pesan
        Route::post('/send', [JawabPasienController::class, 'sendMessage'])->name('send');
    });

    // Fitur: Manajemen Artikel Dok
    // Panggil pakai nama Alias-nya
    Route::resource('kelola-artikel', DoctorKelolaArtikelController::class);

    // Route tambahan juga pakai nama Alias
    Route::patch('/kelola-artikel/{id}/update-status', [DoctorKelolaArtikelController::class, 'updateStatus'])
        ->name('kelola-artikel.updateStatus');
    
});


    // 4. SHARED
    // Route untuk profile user (semua role)
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
    });

    // Route untuk halaman artikel
    Route::get('/artikel', [ArtikelController::class, 'index'])->name('artikel.index');
    Route::get('/artikel/{slug}', [ArtikelController::class, 'show'])->name('artikel.show'); 
});

require __DIR__.'/auth.php';