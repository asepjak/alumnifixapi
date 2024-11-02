<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AdminPerusahaanController extends Controller
{
    public function perusahaanDiterima()
    {
        $response = Http::get('http://raishaapi3.v-project.my.id/api/perusahaan/diterima'); // Ganti dengan URL yang sesuai

        // Mengecek apakah permintaan berhasil
        if ($response->successful()) {
            // Mendapatkan data alumni dari respons
            $perusahaanAktif = $response->json()['data']; // Mengambil data dari respons JSON
        } else {
            $perusahaanAktif = []; // Jika ada kesalahan, inisialisasi dengan array kosong
        }

        // Mengembalikan tampilan dengan data alumni
        return view('pages.admin.perusahaan-diterima', compact('perusahaanAktif'));
    }
    public function perusahaanDivalidasi()
    {
        $response = Http::get('http://raishaapi3.v-project.my.id/api/perusahaan/divalidasi'); // Ganti dengan URL yang sesuai

        // Mengecek apakah permintaan berhasil
        if ($response->successful()) {
            // Mendapatkan data alumni dari respons
            $perusahaanDivalidasi = $response->json()['data']; // Mengambil data dari respons JSON
        } else {
            $perusahaanDivalidasi = []; // Jika ada kesalahan, inisialisasi dengan array kosong
        }

        // Mengembalikan tampilan dengan data alumni
        return view('pages.admin.perusahaan-divalidasi', compact('perusahaanDivalidasi'));
    }
}
