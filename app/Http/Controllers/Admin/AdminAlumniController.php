<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AdminAlumniController extends Controller
{
    public function alumniAktif()
    {
        $response = Http::get('http://raishaapi3.v-project.my.id/api/alumni/aktif'); // Ganti dengan URL yang sesuai

        // Mengecek apakah permintaan berhasil
        if ($response->successful()) {
            // Mendapatkan data alumni dari respons
            $alumniAktif = $response->json()['data']; // Mengambil data dari respons JSON
        } else {
            $alumniAktif = []; // Jika ada kesalahan, inisialisasi dengan array kosong
        }

        // Mengembalikan tampilan dengan data alumni
        return view('pages.admin.alumni-aktif', compact('alumniAktif'));
    }

    public function alumniPasif()
    {
        $response = Http::get('http://raishaapi3.v-project.my.id/api/alumni/pasif'); // Ganti dengan URL yang sesuai

        // Mengecek apakah permintaan berhasil
        if ($response->successful()) {
            // Mendapatkan data alumni dari respons
            $alumniPasif = $response->json()['data']; // Mengambil data dari respons JSON
        } else {
            $alumniPasif = []; // Jika ada kesalahan, inisialisasi dengan array kosong
        }

        // Mengembalikan tampilan dengan data alumni
        return view('pages.admin.alumni-pasif', compact('alumniPasif'));
    }
}
