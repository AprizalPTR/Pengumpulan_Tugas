<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiswaController;


// Tampil data
Route::get('datasiswa', [SiswaController::class, 'datasiswa']);
Route::get('datakelas', [SiswaController::class, 'datakelas']);
Route::get('datapengumpulan', [SiswaController::class, 'datapengumpulan']);
Route::get('datatugas', [SiswaController::class, 'datastugas']);

// User tampil data
Route::get('user/index', [SiswaController::class, 'index']);
Route::get('user/datasiswa', [SiswaController::class, 'userdatasiswa']);
Route::get('datakelas', [SiswaController::class, 'datakelas']);
Route::get('user/datapengumpulan', [SiswaController::class, 'userdatatugas']);
Route::get('user/tambahtugas', [SiswaController::class, 'usertambahtugas']);

// Cari data
Route::get('/cari', [SiswaController::class, 'cari']);
Route::get('/caripengumpulan', [SiswaController::class, 'caripengumpulan']);
Route::get('/caritugas', [SiswaController::class, 'caritugas']);
Route::get('/carikelas', [SiswaController::class, 'carikelas']);

// User cari data
Route::get('user/cari', [SiswaController::class, 'usercari']);
Route::get('user/caritugas', [SiswaController::class, 'usercaritugas']);

// Hapus data
Route::get('siswa/hapus/{id}', [SiswaController::class, 'hapus']);
Route::get('siswa/hapustugas/{id}', [SiswaController::class, 'hapustugas']);
Route::get('siswa/hapuskelas/{id}', [SiswaController::class, 'hapuskelas']);
Route::get('siswa/hapuspengumpulan/{id}', [SiswaController::class, 'hapuspengumpulan']);

// Edit data
Route::get('siswa/edit/{id}', [SiswaController::class, 'editsiswa']);
Route::get('siswa/editpengumpulan/{id}', [SiswaController::class, 'editpengumpulan']);
Route::post('siswa/update', [SiswaController::class, 'update']);
Route::post('/siswa/updatepengumpulan', [SiswaController::class, 'updatepengumpulan']);

// User tambah data
Route::post('siswa/storetugas', [SiswaController::class, 'userstoretugas']);

// Tambah data
Route::get('tambahdata', [SiswaController::class, 'tambah']);
Route::get('tambahpengumpulan', [SiswaController::class, 'tambahpengumpulan']);
Route::get('tambahkelas', [SiswaController::class, 'tambahkelas']);
Route::post('siswa/store', [SiswaController::class, 'store']);
Route::post('siswa/storepengumpulan', [SiswaController::class, 'storepengumpulan']);
Route::post('siswa/storekelas', [SiswaController::class, 'storekelas']);

// Login
Route::get('/login', [SiswaController::class, 'showLoginForm'])->name('login');
Route::post('/login', [SiswaController::class, 'login']);
Route::get('/register', [SiswaController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [SiswaController::class, 'register']);
Route::post('/logout', [SiswaController::class, 'logout'])->name('logout');

// Print
Route::get('print', [SiswaController::class, 'print']);
Route::get('/siswa/printpengumpulan', [SiswaController::class, 'printpengumpulan']);
Route::get('siswa/printtugas', [SiswaController::class, 'printtugas']);
Route::get('printkelas', [SiswaController::class, 'printkelas']);

//profile
Route::get('profile', [SiswaController::class, 'profile']);