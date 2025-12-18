<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\DashboardController; 
use App\Http\Controllers\KalenderKehamilanController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\Auth\GoogleController;
use Illuminate\Support\Facades\Route;

// Rute Login Google
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {

    // 1. Role: MAMA
Route::middleware('role:mama')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Kalender Kehamilan Routes
    Route::get('/kalender-kehamilan', [KalenderKehamilanController::class, 'index'])->name('mama.kalender');
    Route::get('/kalender-kehamilan/detail', [KalenderKehamilanController::class, 'detail'])->name('mama.kalender.detail');
    Route::get('/kalender-kehamilan/reset', [KalenderKehamilanController::class, 'reset'])->name('mama.kalender.reset');
    Route::post('/kalender-kehamilan/update-checklist', [KalenderKehamilanController::class, 'updateChecklist'])->name('mama.kalender.update_checklist');

    // Mama AI Chat Routes
    Route::get('/mama-ai', [ChatController::class, 'index'])->name('mama.ai');
    Route::post('/mama-ai/send', [ChatController::class, 'chat'])->name('mama.ai.send');
});

    // 2. Role: ADMIN
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
        
        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/create', [AdminController::class, 'createUser'])->name('create');
            Route::get('/{user}/edit', [AdminController::class, 'editUser'])->name('edit');
            Route::post('/', [AdminController::class, 'storeUser'])->name('store');
            Route::patch('/{user}', [AdminController::class, 'updateUser'])->name('update');
            Route::delete('/{user}', [AdminController::class, 'destroyUser'])->name('destroy');
        });
    });

    // 3. Role: DOKTER
    Route::middleware('role:dokter')->group(function () {
        Route::get('/dokter/dashboard', [DokterController::class, 'index'])->name('dokter.dashboard');
    });

    // 4. SHARED ROUTES (Profile)
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
    });
});

require __DIR__.'/auth.php';