<?php

use App\Http\Controllers\Admin\AdminAlumniController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminLowonganController;
use App\Http\Controllers\Admin\AdminPertanyaanController;
use App\Http\Controllers\Admin\AdminPerusahaanController;
use App\Http\Controllers\Admin\AdminTracerController;
use App\Http\Controllers\Admin\BeritaController;
use App\Http\Controllers\Admin\DashboardAdminController;
use App\Http\Controllers\Admin\PerusahaanController;
use App\Http\Controllers\Alumni\AlumniLamaranController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Alumni\DashboardAlumniController;
use App\Http\Controllers\Alumni\HistoryAlumniController;
use App\Http\Controllers\Alumni\JobAlumniController;
use App\Http\Controllers\Alumni\ProfileAlumniController;
use App\Http\Controllers\Alumni\TracerAlumniController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\RegisterAlumniController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Perusahaan\DashboardPerusahaanController;
use App\Http\Controllers\Perusahaan\PerusahaanLowonganController;
use App\Http\Middleware\CheckToken;
use Illuminate\Support\Facades\Route;

// Main Dashboard Route
Route::get('/dashboard', function () {
    if (session()->has('token')) {
        $role = session('role');
        switch ($role) {
            case 0:
                return redirect()->route('dashboardAdmin'); // Redirect to admin dashboard
            case 1:
                return redirect()->route('dashboard.alumni'); // Redirect to alumni dashboard
            case 2:
                return redirect()->route('dashboardperusahaan.index'); // Redirect to company dashboard
        }
    }
    return redirect()->route('login'); // Redirect to login if no token
})->name('dashboard');

// Authentication Routes
Route::get('login', [LoginController::class, 'index'])->name('login');
Route::post('login', [LoginController::class, 'login'])->name('login.post');

Route::middleware(CheckToken::class)->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});

// Public Routes
Route::get('/', [HomeController::class, 'indexHome'])->name('home');
Route::get('/alumni', [HomeController::class, 'indexAlumni'])->name('alumni');

// Registration Routes
Route::prefix('register')->group(function () {
    Route::get('/', [RegisterController::class, 'index'])->name('register.index');
    Route::post('/', [RegisterController::class, 'register'])->name('register.submit');

    // Alumni registration
    Route::prefix('alumni')->group(function () {
        Route::get('/', [RegisterController::class, 'indexAlumni'])->name('register.alumni.index');
        Route::post('/', [RegisterController::class, 'registerAlumni'])->name('register.alumni.submit');
    });

    // Company registration
    Route::prefix('perusahaan')->group(function () {
        Route::get('/', [RegisterController::class, 'indexPerusahaan'])->name('register.perusahaan.index');
        Route::post('/', [RegisterController::class, 'registerPerusahaan'])->name('register.perusahaan.submit');
    });
});

// Admin Routes
Route::prefix('admin')->group(function () {
    Route::get('dashboard', [DashboardAdminController::class, 'index'])->name('dashboardAdmin');

    // Alumni Management
    Route::get('alumni-aktif', [AdminAlumniController::class, 'alumniAktif'])->name('alumni-aktif');
    Route::get('alumni-pasif', [AdminAlumniController::class, 'alumniPasif'])->name('alumni-pasif');

    // Company Management
    Route::get('perusahaan-diterima', [AdminPerusahaanController::class, 'perusahaanDiterima'])->name('perusahaan-diterima');
    Route::get('perusahaan-divalidasi', [AdminPerusahaanController::class, 'perusahaanDivalidasi'])->name('perusahaan-divalidasi');

    // Job Opening Management
    Route::get('lowongan-diterima', [AdminLowonganController::class, 'lowonganDiterima'])->name('lowongan-diterima');
    Route::get('lowongan-divalidasi', [AdminLowonganController::class, 'lowonganDivalidasi'])->name('lowongan-divalidasi');

    // News Management
    Route::prefix('berita')->group(function () {
        Route::get('/', [BeritaController::class, 'index'])->name('berita.index');
        Route::post('tambah', [BeritaController::class, 'tambahData'])->name('berita.tambah');
        Route::put('{id}', [BeritaController::class, 'updateData'])->name('berita.update');
        Route::delete('delete/{id}', [BeritaController::class, 'deleteData'])->name('berita.delete');
    });
});

// Company Routes
Route::prefix('perusahaan')->group(function () {
    Route::get('lowongan', [PerusahaanLowonganController::class, 'lowongan'])->name('lowongan.index');
    Route::post('lowongan/tambah', [PerusahaanLowonganController::class, 'store'])->name('lowongan.store');
    Route::get('dashboard', [PerusahaanController::class, 'index'])->name('dashboardperusahaan.index');
});

// Alumni Routes
Route::prefix('alumni')->group(function () {
    Route::get('dashboard', [DashboardAlumniController::class, 'index'])->name('dashboard.alumni');
    // Route::get('profile', [ProfileAlumniController::class, 'index'])->name('alumni.profile'); // Alumni profile
    Route::get('profile/{id_alumni}', [ProfileAlumniController::class, 'index'])->name('alumni.profile');
    Route::put('update/{id_alumni}', [ProfileAlumniController::class, 'update'])->name('alumni.update');
    Route::delete('delete/{id_alumni}', [ProfileAlumniController::class, 'delete'])->name('alumni.delete');
    Route::get('history-alumni', [HistoryAlumniController::class, 'index'])->name('history.lamaran');
    Route::get('job/save', [JobAlumniController::class, 'index'])->name('job');
    Route::get('edit-profile', [ProfileAlumniController::class, 'index'])->name('profile.index');
    Route::get('tracer', [TracerAlumniController::class, 'index'])->name('tracer.index');
});
