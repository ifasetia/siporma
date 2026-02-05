<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\Master\KampusController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {

    // Dashboard (SEMUA ROLE LOGIN)
    Route::get('/dashboard', function () {
        return view('pages.dashboard.index');
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
    return view('pages.profile.index');
})->middleware(['auth'])->name('profile');



Route::get('/kampus', [KampusController::class, 'index'])
    ->middleware(['auth'])
    ->name('kampus');

Route::get('/kampus-datatables', [KampusController::class, 'datatable'])
    ->middleware(['auth'])
    ->name('kampus-datatables');


// Route::prefix('kampus')->name('kampus.')->group(function () {
//     Route::get('/', [KampusController::class, 'index'])->name('index');
//     Route::get('/create', [KampusController::class, 'create'])->name('create');
//     Route::post('/', [KampusController::class, 'store'])->name('store');
//     Route::get('/{kampus}/edit', [KampusController::class, 'edit'])->name('edit');
//     Route::put('/{kampus}', [KampusController::class, 'update'])->name('update');
//     Route::delete('/{kampus}', [KampusController::class, 'destroy'])->name('destroy');
// });


require __DIR__ . '/auth.php';
