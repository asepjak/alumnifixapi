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
use Illuminate\Support\Facades\Route;


Route::get('/', [HomeController::class, 'indexHome'])->name('home');
Route::get('/loker', [HomeController::class, 'indexLoker'])->name('loker');
Route::get('/alumni', [HomeController::class, 'indexAlumni'])->name('alumni');


Route::get('login', [LoginController::class, 'index'])->name('login');
Route::post('login', [LoginController::class, 'login'])->name('login.post');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

//Register Alumni
Route::get('register-perusahaan', [RegisterController::class, 'indexPerusahaan'])->name('indexPerusahaan');
Route::get('register-alumni', [RegisterController::class, 'indexAlumni'])->name('indexAlumni');

Route::post('register', [RegisterController::class, 'registerAlumni'])->name('registerAlumni');
Route::post('register-perusahaan', [RegisterController::class, 'registerPerusahaan'])->name('registerPerusahaan');

Route::get('dashboard', [DashboardAlumniController::class, 'index'])->name('dashboardAlumni');

//Admin
Route::get('dashboard-admin', [DashboardAdminController::class, 'index'])->name('dashboardAdmin');
Route::get('alumni-aktif', [AdminAlumniController::class, 'alumniAktif'])->name('alumni-aktif');
Route::get('alumni-pasif', [AdminAlumniController::class, 'alumniPasif'])->name('alumni-pasif');
Route::get('perusahaan-diterima', [AdminPerusahaanController::class, 'perusahaanDiterima'])->name('perusahaan-diterima');
Route::get('perusahaan-divalidasi', [AdminPerusahaanController::class, 'perusahaanDivalidasi'])->name('perusahaan-divalidasi');
Route::get('lowongan-diterima', [AdminLowonganController::class, 'lowonganDiterima'])->name('lowongan-diterima');
Route::get('lowongan-divalidasi', [AdminLowonganController::class, 'lowonganDivalidasi'])->name('lowongan-divalidasi');
Route::get('pertanyaan', [AdminPertanyaanController::class, 'pertanyaan'])->name('pertanyaan.index');
Route::get('tracer', [AdminTracerController::class, 'tracer'])->name('tracer.index');


// Admin-Berita
Route::get('berita', [BeritaController::class, 'index'])->name('berita.index');
Route::post('berita-tambah', [BeritaController::class, 'tambahData'])->name('berita.tambah');
Route::put('/berita/{id}', [BeritaController::class, 'updateData'])->name('berita.update');
Route::delete('/berita/delete/{id}', [BeritaController::class, 'deleteData'])->name('berita.delete');


// Admin-Berita

//Perusahaan
Route::get('dashboard', [DashboardPerusahaanController::class, 'index'])->name('dashboardPerusahaan');
Route::get('lowongan', [PerusahaanLowonganController::class, 'lowongan'])->name('lowongan.index');
Route::post('lowongan/tambah', [PerusahaanLowonganController::class, 'store'])->name('lowongan.store');

