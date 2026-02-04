<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KegiatanController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {

    // Dashboard (SEMUA ROLE LOGIN)
    Route::get('/dashboard', function () {
        return view('dashboard.index');
    })->name('dashboard');

    // // Profile
    // Route::get('/profile', [ProfileController::class, 'edit'])
    //     ->name('profile.edit');

    // Route::patch('/profile', [ProfileController::class, 'update'])
    //     ->name('profile.update');

    // Route::delete('/profile', [ProfileController::class, 'destroy'])
    //     ->name('profile.destroy');
});

// ADMIN & SUPER ADMIN ONLY
Route::middleware(['auth', 'can:admin'])->group(function () {

    Route::resource('kegiatan', KegiatanController::class);
});

Route::get('/profile', function () {
    return view('profile');
})->middleware(['auth']);


require __DIR__ . '/auth.php';
