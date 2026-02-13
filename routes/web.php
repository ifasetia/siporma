<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\Master\KampusController;
use App\Http\Controllers\Master\PekerjaanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DatainternController;


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
// Route::middleware(['auth', 'can:admin'])->group(function () {

//     Route::resource('kegiatan', KegiatanController::class);
// });

Route::get('/profile', function () {
    return view('pages.profile.index');
})->middleware(['auth'])->name('profile');


Route::middleware(['auth'])
    ->prefix('pekerjaan')
    ->name('pekerjaan.')
    ->group(function () {
        Route::get('/', [PekerjaanController::class, 'index'])->name('index');
        Route::get('/datatables', [PekerjaanController::class, 'datatable'])->name('datatables');
        Route::get('/create', [PekerjaanController::class, 'create'])->name('create');
        Route::post('/store', [PekerjaanController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [PekerjaanController::class, 'edit'])->name('edit');
        Route::put('/{id}/update', [PekerjaanController::class, 'update'])->name('update');
        Route::delete('/{id}/delete', [PekerjaanController::class, 'destroy'])->name('delete');
    });



Route::middleware(['auth'])
    ->prefix('kampus')
    ->name('kampus.')
    ->group(function () {
        Route::get('/', [KampusController::class, 'index'])->name('index');
        Route::get('/datatables', [KampusController::class, 'datatable'])->name('datatables');
        Route::post('/store', [KampusController::class, 'store'])->name('store');
        Route::delete('/{id}', [KampusController::class, 'destroy'])->name('destroy');
        Route::get('/{id}/edit', [KampusController::class, 'edit'])->name('edit');
        Route::post('/{id}/update', [KampusController::class, 'update'])->name('update');
    });

Route::middleware(['auth'])
    ->prefix('user')
    ->name('user.')
    ->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/datatables', [UserController::class, 'datatable'])->name('datatables');
        Route::post('/store', [UserController::class, 'store'])->name('store');
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy');
        Route::get('/{id}/edit', [UserController::class, 'edit'])->name('edit');
        Route::post('/{id}/update', [UserController::class, 'update'])->name('update');
    });

Route::middleware(['auth'])
    ->prefix('data-intern')
    ->name('data-intern.')
    ->group(function () {
        Route::get('/', [DatainternController::class,'index'])->name('index');
        Route::get('/datatables', [DatainternController::class,'datatable'])->name('datatables');
        Route::get('/{id}/detail',[DatainternController::class,'detail'])->name('detail');
        Route::post('/store', [DatainternController::class,'store'])->name('store');
        Route::get('/{id}/edit', [DataInternController::class, 'edit']);
        Route::post('/{id}/update', [DataInternController::class, 'update']);
    });

require __DIR__ . '/auth.php';
