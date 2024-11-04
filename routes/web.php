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
        if ($role === 0) {
            return redirect()->route('dashboardAdmin'); // Redirect to admin dashboard
        } elseif ($role === 1) {
            return redirect()->route('dashboard.index'); // Redirect to alumni dashboard
        } elseif ($role === 2) {
            return redirect()->route('dashboardperusahaan.index'); // Redirect to company dashboard
        }
    }
    return redirect()->route('login'); // Redirect to login if no token
})->name('dashboard');

// Authentication Routes
Route::get('login', [LoginController::class, 'index'])->name('login'); // done
Route::post('login', [LoginController::class, 'login'])->name('login.post'); // done

Route::middleware(CheckToken::class)->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout'); // done
});

// Public Routes
Route::get('/', [HomeController::class, 'indexHome'])->name('home');
Route::get('/alumni', [HomeController::class, 'indexAlumni'])->name('alumni'); // done

// Registration Routes
Route::prefix('register')->group(function () {
    Route::get('/', [RegisterController::class, 'index'])->name('register.index'); // Registration page
    Route::post('/', [RegisterController::class, 'register'])->name('register.submit'); // Registration action

    // Alumni registration
    Route::get('/alumni', [RegisterController::class, 'indexAlumni'])->name('register.alumni.index');
    Route::post('/alumni', [RegisterController::class, 'registerAlumni'])->name('register.alumni.submit');

    // Company registration
    Route::get('/perusahaan', [RegisterController::class, 'indexPerusahaan'])->name('register.perusahaan.index');
    Route::post('/perusahaan', [RegisterController::class, 'registerPerusahaan'])->name('register.perusahaan.submit');
});

// Admin Routes
Route::prefix('admin')->group(function () {
    Route::get('dashboard', [DashboardAdminController::class, 'index'])->name('dashboardAdmin'); // Admin dashboard

    // Alumni Management
    Route::get('alumni-aktif', [AdminAlumniController::class, 'alumniAktif'])->name('alumni-aktif'); // Active alumni
    Route::get('alumni-pasif', [AdminAlumniController::class, 'alumniPasif'])->name('alumni-pasif'); // Inactive alumni

    // Perusahaan Management
    Route::get('perusahaan-diterima', [AdminPerusahaanController::class, 'perusahaanDiterima'])->name('perusahaan-diterima'); // Accepted companies
    Route::get('perusahaan-divalidasi', [AdminPerusahaanController::class, 'perusahaanDivalidasi'])->name('perusahaan-divalidasi'); // Validated companies

    // Lowongan Management
    Route::get('lowongan-diterima', [AdminLowonganController::class, 'lowonganDiterima'])->name('lowongan-diterima'); // Accepted job openings
    Route::get('lowongan-divalidasi', [AdminLowonganController::class, 'lowonganDivalidasi'])->name('lowongan-divalidasi'); // Validated job openings

    // Berita Management
    Route::get('berita', [BeritaController::class, 'index'])->name('berita.index'); // News index
    Route::post('berita-tambah', [BeritaController::class, 'tambahData'])->name('berita.tambah'); // Add news
    Route::put('berita/{id}', [BeritaController::class, 'updateData'])->name('berita.update'); // Update news
    Route::delete('berita/delete/{id}', [BeritaController::class, 'deleteData'])->name('berita.delete'); // Delete news
});

// Perusahaan Routes
Route::prefix('perusahaan')->group(function () {
    Route::get('lowongan', [PerusahaanLowonganController::class, 'lowongan'])->name('lowongan.index'); // Company job openings
    Route::post('lowongan/tambah', [PerusahaanLowonganController::class, 'store'])->name('lowongan.store'); // Add job opening
    Route::get('dashboard', [PerusahaanController::class, 'index'])->name('dashboardperusahaan.index'); // Company dashboard
});

// Alumni Routes
Route::prefix('alumni')->group(function () {
    Route::get('dashboard', [DashboardAlumniController::class, 'index'])->name('dashboard.alumni'); // Alumni dashboard
    Route::get('profile', [ProfileAlumniController::class, 'index'])->name('alumni.profile'); // Alumni profile
    Route::get('/lamaran/alumni', [LamaranAlumniController::class, 'index'])->middleware(['auth', 'verified'])->name('lamaran.alumni');
    Route::get('/history/lamaran', [HistoryAlumniController::class, 'index'])->name('history.lamaran');
    Route::get('/job/save', [JobAlumniController::class, 'index'])->name('job');
    Route::get('edit-profile', [ProfileAlumniController::class, 'index'])->name('profile.index'); // Edit profile
    Route::get('tracer', [TracerAlumniController::class, 'index'])->name('tracer.index'); // Tracer alumni
});

