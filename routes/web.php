<?php

use App\Http\Controllers\AlatController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LaporanPeminjamanController;
use App\Http\Controllers\LogAktivitasController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::resource('kategori', KategoriController::class);
    Route::resource('alat', AlatController::class);
    Route::resource('peminjaman', PeminjamanController::class);
    Route::get('pengembalian', [PengembalianController::class, 'index'])->name('pengembalian.index');
    Route::get('pengembalian/{id}/edit', [PengembalianController::class, 'edit'])->name('pengembalian.edit');
    Route::put('pengembalian/{id}', [PengembalianController::class, 'update'])->name('pengembalian.update');
    Route::get('log-aktivitas', [LogAktivitasController::class, 'index'])->name('log-aktivitas.index');
    Route::get('laporan-peminjaman', [LaporanPeminjamanController::class, 'index'])->name('laporan-peminjaman.index');
    Route::get('laporan-peminjaman/cetak/{id}', [LaporanPeminjamanController::class, 'cetakSatu'])->name('laporan-peminjaman.cetak.satu');
    Route::get('laporan-peminjaman/cetak', [LaporanPeminjamanController::class, 'cetak'])->name('laporan-peminjaman.cetak');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
