<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\Master\KampusController;
use App\Http\Controllers\Master\PekerjaanController;
use App\Http\Controllers\UserController;

// 1. Halaman Depan (Public)
Route::get('/', function () {
    return view('welcome');
});

// 2. Grup Route yang Wajib Login (Auth)
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return view('pages.dashboard.index');
    })->name('dashboard');

    // Profile (Menggunakan View di pages/profile/index.blade.php)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Management User (Lengkap dengan DataTable)
    Route::prefix('user')->name('user.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/datatables', [UserController::class, 'datatable'])->name('datatables');
        Route::post('/store', [UserController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [UserController::class, 'edit'])->name('edit');
        Route::post('/{id}/update', [UserController::class, 'update'])->name('update');
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy');
    });

    // Master Data Pekerjaan
    Route::prefix('pekerjaan')->name('pekerjaan.')->group(function () {
        Route::get('/', [PekerjaanController::class, 'index'])->name('index');
        Route::get('/datatables', [PekerjaanController::class, 'datatable'])->name('datatables');
        Route::post('/store', [PekerjaanController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [PekerjaanController::class, 'edit'])->name('edit');
        Route::put('/{id}/update', [PekerjaanController::class, 'update'])->name('update');
        Route::delete('/{id}/delete', [PekerjaanController::class, 'destroy'])->name('delete');
    });

    // Master Data Kampus
    Route::prefix('kampus')->name('kampus.')->group(function () {
        Route::get('/', [KampusController::class, 'index'])->name('index');
        Route::get('/datatables', [KampusController::class, 'datatable'])->name('datatables');
        Route::post('/store', [KampusController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [KampusController::class, 'edit'])->name('edit');
        Route::put('/{id}/update', [KampusController::class, 'update'])->name('update'); // Pakai PUT sesuai kodinganmu
        Route::delete('/{id}', [KampusController::class, 'destroy'])->name('destroy');
    });

    // Kegiatan (Jika nanti diaktifkan oleh Admin)
    // Route::resource('kegiatan', KegiatanController::class);

});

// 3. Auth Routes (Login, Register, dll dari Breeze)
require __DIR__ . '/auth.php';
