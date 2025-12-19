<?php

use Illuminate\Support\Facades\Route;

// --- AUTH CONTROLLERS ---
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\ProfileController;

// --- MAMA CONTROLLERS ---
use App\Http\Controllers\DashboardController; // Dashboard Mama
use App\Http\Controllers\KalenderKehamilanController;
use App\Http\Controllers\ReservationController; // Reservasi Mama
use App\Http\Controllers\ChatController;
use App\Http\Controllers\RekapDataController;

// --- ADMIN CONTROLLERS ---
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;

// --- DOKTER CONTROLLERS ---
// Menggunakan Alias agar tidak bentrok dengan Dashboard Mama
use App\Http\Controllers\Doctor\DashboardController as DoctorDashboardController; 
use App\Http\Controllers\Doctor\ReservationController as DoctorReservationController;


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
});


    // 4. SHARED (PROFILE)
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
    });
});

require __DIR__.'/auth.php';