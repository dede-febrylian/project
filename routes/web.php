<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RuangController;
use App\Http\Controllers\ReservasiController;
use App\Http\Controllers\FasilitasController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes (Bisa Diakses Pengunjung / Tanpa Login)
|--------------------------------------------------------------------------
*/

Route::get('/', [RuangController::class, 'index'])->name('dashboard');

// 2. Room Reservasi: Kalender Agenda / Jadwal Publik
Route::get('/room-reservasi', [ReservasiController::class, 'index'])->name('reservasi.public');

// 3. Setting: Mengarahkan pengunjung ke halaman Login Breeze
Route::get('/setting', function () {
    return redirect()->route('login');
})->name('setting');


/*
|--------------------------------------------------------------------------
| Authenticated User Routes (Memerlukan Login)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {
    // Profil bawaan Breeze
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Menu Reservasi Baru (Muncul di Sidebar Pasca-Login)
    Route::get('/reservasi/buat', [ReservasiController::class, 'create'])->name('reservasi.create');
    Route::post('/reservasi/store', [ReservasiController::class, 'store'])->name('reservasi.store');
});


/*
|--------------------------------------------------------------------------
| Admin Routes (Khusus Admin)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->as('admin.')->group(function () {
    // 1. Kelola Ruangan (CRUD Ruangan)
    // Route index khusus admin
    Route::get('ruang', [RuangController::class, 'adminIndex'])->name('ruang.index');

    // Route lainnya (create, store, show, edit, update, destroy)
    Route::resource('ruang', RuangController::class)->except(['index']);

    Route::get('/riwayat-reservasi', [ReservasiController::class, 'index'])->name('riwayat.index');
    Route::delete('/riwayat-reservasi/{id}', [ReservasiController::class, 'destroy'])->name('riwayat.destroy');
});

require __DIR__ . '/auth.php';
