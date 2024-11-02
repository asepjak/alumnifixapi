<?php

use App\Http\Controllers\Admin\AdminAlumniController;
use App\Http\Controllers\Admin\AdminLowonganController;
use App\Http\Controllers\Admin\AdminPertanyaanController;
use App\Http\Controllers\Admin\AdminPerusahaanController;
use App\Http\Controllers\Admin\AdminTracerController;
use App\Http\Controllers\Admin\BeritaController;
use App\Http\Controllers\Admin\DashboardAdminController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Alumni\DashboardAlumniController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Perusahaan\DashboardPerusahaanController;
use App\Http\Controllers\Perusahaan\PerusahaanLowonganController;
use App\Http\Middleware\CheckToken;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function () {
    if (session()->has('token')) {
        $role = session('role');
        if ($role === 0) {
            return redirect()->route('dashboardAdmin'); // Redirect to admin dashboard
        } elseif ($role === 1) {
            return redirect()->route('dashboardAlumni'); // Redirect to alumni dashboard
        } elseif ($role === 2) {
            return redirect()->route('dashboardPerusahaan'); // Redirect to company dashboard
        }
    }
    return redirect()->route('login'); // Redirect to login if no token
})->name('dashboard');

Route::get('login', [LoginController::class, 'index'])->name('login');
Route::post('login', [LoginController::class, 'login'])->name('login.post');
// Authentication Routes
Route::middleware(CheckToken::class)->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});

// Public Routes
Route::get('/', [HomeController::class, 'indexHome'])->name('home');
Route::get('/loker', [HomeController::class, 'indexLoker'])->name('loker');
Route::get('/alumni', [HomeController::class, 'indexAlumni'])->name('alumni');

// Registration Routes
Route::get('register-perusahaan', [RegisterController::class, 'indexPerusahaan'])->name('indexPerusahaan');
Route::get('register-alumni', [RegisterController::class, 'indexAlumni'])->name('indexAlumni');
Route::post('register', [RegisterController::class, 'register'])->name('register');
// Route::post('register-perusahaan', [RegisterController::class, 'registerPerusahaan'])->name('registerPerusahaan');


// Admin Routes
Route::prefix('admin')->group(function () {
    Route::get('dashboard', [DashboardAdminController::class, 'index'])->name('dashboardAdmin');

    // Alumni Management
    Route::get('alumni-aktif', [AdminAlumniController::class, 'alumniAktif'])->name('alumni-aktif');
    Route::get('alumni-pasif', [AdminAlumniController::class, 'alumniPasif'])->name('alumni-pasif');

    // Perusahaan Management
    Route::get('perusahaan-diterima', [AdminPerusahaanController::class, 'perusahaanDiterima'])->name('perusahaan-diterima');
    Route::get('perusahaan-divalidasi', [AdminPerusahaanController::class, 'perusahaanDivalidasi'])->name('perusahaan-divalidasi');

    // Lowongan Management
    Route::get('lowongan-diterima', [AdminLowonganController::class, 'lowonganDiterima'])->name('lowongan-diterima');
    Route::get('lowongan-divalidasi', [AdminLowonganController::class, 'lowonganDivalidasi'])->name('lowongan-divalidasi');

    // Pertanyaan Management
    Route::get('pertanyaan', [AdminPertanyaanController::class, 'pertanyaan'])->name('pertanyaan.index');

    // Tracer
    Route::get('tracer', [AdminTracerController::class, 'tracer'])->name('tracer.index');

    // Berita Management
    Route::get('berita', [BeritaController::class, 'index'])->name('berita.index');
    Route::post('berita-tambah', [BeritaController::class, 'tambahData'])->name('berita.tambah');
    Route::put('berita/{id}', [BeritaController::class, 'updateData'])->name('berita.update');
    Route::delete('berita/delete/{id}', [BeritaController::class, 'deleteData'])->name('berita.delete');
});

// Perusahaan Routes
Route::prefix('perusahaan')->group(function () {
    Route::get('lowongan', [PerusahaanLowonganController::class, 'lowongan'])->name('lowongan.index');
    Route::post('lowongan/tambah', [PerusahaanLowonganController::class, 'store'])->name('lowongan.store');
});
