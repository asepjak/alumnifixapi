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

Route::get('login', [LoginController::class, 'index'])->name('login'); //done
Route::post('login', [LoginController::class, 'login'])->name('login.post'); //done
// Authentication Routes
Route::middleware(CheckToken::class)->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout'); //done
});

// Public Routes
Route::get('/', [HomeController::class, 'indexHome'])->name('home');
// Route::get('/loker', [HomeController::class, 'indexLoker'])->name('loker'); //done
Route::get('/alumni', [HomeController::class, 'indexAlumni'])->name('alumni'); //done

// Registration Routes
// Route::get('register-perusahaan', [RegisterController::class, 'indexPerusahaan'])->name('indexPerusahaan');
// // Route::get('register-alumni', [RegisterController::class, 'indexAlumni'])->name('indexAlumni');
// Route::get('register', [RegisterController::class, 'index'])->name('register'); // masi kacau di tampilan
// Route::post('register', [RegisterController::class, 'register'])->name('register.submit'); //done
// Route::get('register/alumni', [RegisterController::class, 'indexAlumni'])->name('register.alumni'); //done
// Route::post('register/alumni', [RegisterController::class, 'registerAlumni'])->name('register.alumni.submit');
// Route::post('register-perusahaan', [RegisterController::class, 'registerPerusahaan'])->name('register.perusahaan'); //done

// Registration Routes
Route::prefix('register')->group(function () {
    // General user registration
    Route::get('/', [RegisterController::class, 'index'])->name('register.index');
    Route::post('/', [RegisterController::class, 'register'])->name('register.submit');

    // Alumni registration
    Route::get('/alumni', [RegisterController::class, 'indexAlumni'])->name('register.alumni.index');
    Route::post('/alumni', [RegisterController::class, 'registerAlumni'])->name('register.alumni.submit');

    // Company registration
    Route::get('/perusahaan', [RegisterController::class, 'indexPerusahaan'])->name('register.perusahaan.index');
    Route::post('/perusahaan', [RegisterController::class, 'registerPerusahaan'])->name('register.perusahaan.submit');
});



// Admin Routes
Route::prefix('admin')->group(function () {

    //Tracer
    Route::get('tracer', [AdminTracerController::class, 'index'])->name('tracer.index'); //done

    //edit atmin
    // Route::get('edit-admin',[AdminController::class, 'indexEditProfile'])->name('edit-admin.index');

    Route::get('dashboard', [DashboardAdminController::class, 'index'])->name('dashboardAdmin'); // done

    // Alumni Management
    Route::get('alumni-aktif', [AdminAlumniController::class, 'alumniAktif'])->name('alumni-aktif'); //done
    Route::get('alumni-pasif', [AdminAlumniController::class, 'alumniPasif'])->name('alumni-pasif'); //done

    // Perusahaan Management
    Route::get('perusahaan-diterima', [AdminPerusahaanController::class, 'perusahaanDiterima'])->name('perusahaan-diterima'); //done
    Route::get('perusahaan-divalidasi', [AdminPerusahaanController::class, 'perusahaanDivalidasi'])->name('perusahaan-divalidasi'); //done

    // Lowongan Management
    Route::get('lowongan-diterima', [AdminLowonganController::class, 'lowonganDiterima'])->name('lowongan-diterima'); //done
    Route::get('lowongan-divalidasi', [AdminLowonganController::class, 'lowonganDivalidasi'])->name('lowongan-divalidasi'); //done


    // Pertanyaan Management
    // Route::get('pertanyaan', [AdminPertanyaanController::class, 'pertanyaan'])->name('pertanyaan.index'); //done

    // Tracer
    // Route::get('tracer', [AdminTracerController::class, 'tracer'])->name('tracer.index'); //done

    // Berita Management
    Route::get('berita', [BeritaController::class, 'index'])->name('berita.index'); //done
    Route::post('berita-tambah', [BeritaController::class, 'tambahData'])->name('berita.tambah'); //done
    Route::put('berita/{id}', [BeritaController::class, 'updateData'])->name('berita.update'); //done
    Route::delete('berita/delete/{id}', [BeritaController::class, 'deleteData'])->name('berita.delete'); //done
});

// Perusahaan Routes
Route::prefix('perusahaan')->group(function () {
    Route::get('lowongan', [PerusahaanLowonganController::class, 'lowongan'])->name('lowongan.index'); //done
    Route::post('lowongan/tambah', [PerusahaanLowonganController::class, 'store'])->name('lowongan.store'); //done
    Route::get('dashboard', [PerusahaanController::class, 'index'])->name('dashboardperusahaan.index'); // tidak ada fungsiny
});

//Alumni

Route::get('lamaran', [AlumniLamaranController::class, 'index'])->name('lamaran.index'); //done
Route::get('dashboard', [DashboardAlumniController::class, 'index'])->name('dashboard.index');
Route::get('history', [HistoryAlumniController::class, 'index'])->name('history.index');
Route::get('job', [JobAlumniController::class, 'index'])->name('job.index');
Route::get('edit-profile', [ProfileAlumniController::class, 'index'])->name('profile.index');
Route::get('tracer', [TracerAlumniController::class, 'index'])->name('tracer.index');




