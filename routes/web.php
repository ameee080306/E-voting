<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin;
use App\Http\Controllers\Mahasiswa;

Route::get('/', function () {
    return view('public.beranda');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('mahasiswa', Admin\MahasiswaController::class)->only(['index', 'update']);
    Route::resource('kandidat', Admin\KandidatController::class);
    Route::resource('periode', Admin\PeriodeController::class);
    Route::get('/profil', [Admin\ProfilController::class, 'index'])->name('profil.index');
    Route::post('/profil', [Admin\ProfilController::class, 'update'])->name('profil.update');
    Route::get('/voting', [Admin\VotingDataController::class, 'index'])->name('voting.index');
    Route::get('/hasil', [Admin\HasilVotingController::class, 'index'])->name('hasil.index');
    Route::get('/laporan', [Admin\LaporanController::class, 'index'])->name('laporan.index');
    

});

Route::middleware(['auth', 'role:mahasiswa'])->prefix('mahasiswa')->name('mahasiswa.')->group(function () {
    Route::get('/dashboard', [Mahasiswa\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profil', [Mahasiswa\ProfilController::class, 'index'])->name('profil.index');
    Route::post('/profil', [Mahasiswa\ProfilController::class, 'update'])->name('profil.update');
    Route::get('/kandidat', [Mahasiswa\KandidatController::class, 'index'])->name('kandidat.index');
    Route::get('/voting', [Mahasiswa\VotingController::class, 'index'])->name('voting.index');
    Route::post('/voting', [Mahasiswa\VotingController::class, 'store'])->name('voting.store');
    Route::get('/hasil', [Mahasiswa\HasilController::class, 'index'])->name('hasil.index');
});
