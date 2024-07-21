<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::any('/', [LoginController::class, 'login'])->name('login');
Route::any('/proses_login', [LoginController::class, 'prosesLogin'])->name('prosesLogin');
Route::any('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::prefix('admin')->middleware(['admin'])->group(function () {
        Route::any('/home', [AdminController::class, 'index'])->name('admin.index');
        Route::any('/profile', [AdminController::class, 'profile'])->name('admin.profile');
        Route::any('/update_profile', [AdminController::class, 'updateProfile'])->name('admin.updateProfile');
        Route::any('/karyawan', [AdminController::class, 'karyawan'])->name('admin.karyawan');
        Route::any('/add_karyawan', [AdminController::class, 'addKaryawan'])->name('admin.addKaryawan');
        Route::any('/update_karyawan', [AdminController::class, 'updateKaryawan'])->name('admin.updateKaryawan');
        Route::any('/delete_karyawan/{id}', [AdminController::class, 'deleteKaryawan'])->name('admin.deleteKaryawan');
        Route::any('/jabatan', [AdminController::class, 'jabatan'])->name('admin.jabatan');
        Route::any('/add_jabatan', [AdminController::class, 'addJabatan'])->name('admin.addJabatan');
        Route::any('/update_jabatan', [AdminController::class, 'updateJabatan'])->name('admin.updateJabatan');
        Route::any('/delete_jabatan/{id}', [AdminController::class, 'deleteJabatan'])->name('admin.deleteJabatan');
        Route::any('/absen', [AdminController::class, 'absen'])->name('admin.absen');
        Route::any('/add_absen', [AdminController::class, 'addAbsen'])->name('admin.addAbsen');
        Route::any('/update_absen', [AdminController::class, 'updateAbsen'])->name('admin.updateAbsen');
        Route::any('/gaji', [AdminController::class, 'gaji'])->name('admin.gaji');
        Route::any('/pdfGaji', [AdminController::class, 'pdfGaji'])->name('admin.pdfGaji');
        Route::any('/potongan', [AdminController::class, 'potongan'])->name('admin.potongan');
        Route::any('/add_potongan', [AdminController::class, 'addPotongan'])->name('admin.addPotongan');
        Route::any('/update_potongan', [AdminController::class, 'updatePotongan'])->name('admin.updatePotongan');
        Route::any('/delete_potongan/{id}', [AdminController::class, 'deletePotongan'])->name('admin.deletePotongan');
    });
});

Route::middleware(['auth'])->group(function () {
    Route::prefix('karyawan')->middleware(['karyawan'])->group(function () {
        Route::any('/home', [UserController::class, 'index'])->name('karyawan.index');
        Route::any('/profile', [UserController::class, 'profile'])->name('karyawan.profile');
        Route::any('/update_profile', [UserController::class, 'updateProfile'])->name('karyawan.updateProfile');
        Route::any('/gaji', [UserController::class, 'gaji'])->name('karyawan.gaji');
    });
});
