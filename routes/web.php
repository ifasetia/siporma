<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\Master\KampusController;
use App\Http\Controllers\Master\JurusanController;
use App\Http\Controllers\Master\PekerjaanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DatainternController;
use App\Http\Controllers\DataadminController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\Master\SupervisorController;
use App\Http\Controllers\Master\TeknologiController;
use App\Http\Controllers\Master\StatusProyekController;
use App\Http\Controllers\ValidasiProyekController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\Public\PublicController;



// 1. Halaman Depan (Public)
// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [PublicController::class, 'landing']);

//public
Route::prefix('public')->group(function () {


    Route::get('/dashboard',[PublicController::class,'dashboard'])
        ->name('public.dashboard');

    Route::get('/project',[PublicController::class,'projects'])
        ->name('public.project');

    Route::get('/project/{id}',[PublicController::class,'detailProject'])
        ->name('public.project.detail');

    Route::get('/analytics',[PublicController::class,'analytics'])
        ->name('public.analytics');
});

// 2. Grup Route yang Wajib Login (Auth)
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return redirect()->route('analytics.index');
    })->name('dashboard');
    // Route::get('/dashboard', function () {
    //     return view('pages.dashboard.index');
    // })->name('dashboard');



    // Profile (Menggunakan View di pages/profile/index.blade.php)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');
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

    //Analytics
    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics.index');



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
        Route::put('/{id}/update', [KampusController::class, 'update'])->name('update');
        Route::delete('/{id}', [KampusController::class, 'destroy'])->name('destroy');
    });

    // Master Data Teknologi
    Route::prefix('teknologi')->name('teknologi.')->group(function () {
        Route::get('/', [TeknologiController::class, 'index'])->name('index');
        Route::get('/datatables', [TeknologiController::class, 'datatable'])->name('datatables');
        Route::post('/store', [TeknologiController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [TeknologiController::class, 'edit'])->name('edit');
        Route::put('/{id}/update', [TeknologiController::class, 'update'])->name('update');
        Route::delete('/{id}', [TeknologiController::class, 'destroy'])->name('destroy');
    });

    Route::middleware(['auth'])
        ->prefix('data-intern')
        ->name('data-intern.')
        ->group(function () {
            Route::get('/', [DatainternController::class, 'index'])->name('index');
            Route::get('/datatables', [DatainternController::class, 'datatable'])->name('datatables');
            Route::get('/{id}/detail', [DatainternController::class, 'detail'])
            ->name('detail')
            ->middleware('ajax');
            Route::post('/store', [DatainternController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [DataInternController::class, 'edit']);
            Route::post('/{id}/update', [DataInternController::class, 'update']);
            Route::post('/{id}/toggle-status', [DatainternController::class, 'toggleStatus']);
            Route::delete('/{id}', [DatainternController::class, 'destroy'])->name('destroy');
            Route::get('/data-intern/create', [DatainternController::class, 'create'])->name('data-intern.create');
        });

    // Master Data Status Proyek
    Route::prefix('status-proyek')->name('status-proyek.')->group(function () {
        Route::get('/', [StatusProyekController::class, 'index'])->name('index');
        Route::get('/datatables', [StatusProyekController::class, 'datatable'])->name('datatables');
        Route::post('/store', [StatusProyekController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [StatusProyekController::class, 'edit'])->name('edit');
        Route::put('/{id}/update', [StatusProyekController::class, 'update'])->name('update');
        Route::delete('/{id}', [StatusProyekController::class, 'destroy'])->name('destroy');
    });


    Route::middleware(['auth'])
        ->prefix('data-admin')
        ->name('data-admin.')
        ->group(function () {
            Route::get('/', [DataadminController::class, 'index'])->name('index');
            Route::get('/datatables', [DataadminController::class, 'datatable'])->name('datatables');
            Route::get('/{id}/detail', [DataadminController::class, 'detail'])->name('detail');
            Route::post('/store', [DataadminController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [DataadminController::class, 'edit']);
            Route::post('/{id}/update', [DataadminController::class, 'update']);
            Route::post('/{id}/toggle-status', [DataadminController::class, 'toggleStatus']);
            Route::delete('/{id}', [DataadminController::class, 'destroy'])->name('destroy');
        });


    Route::prefix('projects')
        ->name('projects.')
        ->group(function () {

            Route::get('/', [ProjectController::class, 'index'])->name('index');
            Route::get('/datatables', [ProjectController::class, 'datatable'])->name('datatables');

            Route::post('/store', [ProjectController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [ProjectController::class, 'edit'])->name('edit');
            Route::post('/{id}/update', [ProjectController::class, 'update'])->name('update');
            Route::get('/{id}/detail', [ProjectController::class, 'detail'])->name('detail');

            Route::delete('/{id}', [ProjectController::class, 'destroy'])->name('destroy');

        });

    Route::delete('/project-files/{id}', [ProjectController::class, 'deleteFile']);
    Route::delete('/project-photos/{id}', [ProjectController::class, 'deletePhoto']);
    Route::delete('/project-links/{id}', [ProjectController::class, 'deleteLink']);

    // ROUTE UNTUK VALIDASI PROYEK (ADMIN)
    Route::get('/validasi-proyek', [ValidasiProyekController::class, 'index'])->name('validasi-proyek.index');
    Route::get('/validasi-proyek/datatables', [ValidasiProyekController::class, 'datatable'])->name('validasi-proyek.datatables');
    Route::put('/validasi-proyek/{id}/status', [ValidasiProyekController::class, 'updateStatus'])->name('validasi-proyek.update-status');


    // Kegiatan (Jika nanti diaktifkan oleh Admin)
    // Route::resource('kegiatan', KegiatanController::class);
    // Master Data Jurusan
    Route::prefix('jurusan')->name('jurusan.')->group(function () {
        Route::get('/', [JurusanController::class, 'index'])->name('index');
        Route::get('/datatables', [JurusanController::class, 'datatable'])->name('datatables');
        Route::post('/store', [JurusanController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [JurusanController::class, 'edit'])->name('edit');
        Route::put('/{id}/update', [JurusanController::class, 'update'])->name('update');
        Route::delete('/{id}', [JurusanController::class, 'destroy'])->name('destroy');
    });

    // Master Data Supervisor
    Route::get('supervisor/datatables', [SupervisorController::class, 'datatable'])->name('supervisor.datatables');
    Route::resource('supervisor', SupervisorController::class);
    Route::post('supervisor/{id}/update', [SupervisorController::class, 'update'])->name('supervisor.update');
    Route::post('/supervisor/{id}/toggle-status', [SupervisorController::class, 'toggleStatus'])->name('supervisor.toggle');

    // Data Intern
    Route::middleware(['auth'])
        ->prefix('data-intern')
        ->name('data-intern.')
        ->group(function () {
            Route::get('/', [DatainternController::class, 'index'])->name('index');
            Route::get('/datatables', [DatainternController::class, 'datatable'])->name('datatables');
            Route::get('/{id}/detail', [DatainternController::class, 'detail'])->name('detail');
            Route::post('/store', [DatainternController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [DatainternController::class, 'edit'])->name('edit');
            Route::post('/{id}/update', [DatainternController::class, 'update'])->name('update');
            Route::post('/{id}/toggle-status', [DatainternController::class, 'toggleStatus'])->name('toggle-status');
        });

        // //public
// Route::get('/', function () {
//     return view('pages.public.dashboard');
// });

});


// 3. Auth Routes (Login, Register, dll dari Breeze)
require __DIR__ . '/auth.php';
