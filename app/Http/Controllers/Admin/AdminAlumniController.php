<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AdminAlumniController extends Controller
{
    public function alumniAktif()
    {
        $response = Http::get('http://raishaapi3.v-project.my.id/api/alumni'); // Ganti dengan URL yang sesuai

        // Mengecek apakah permintaan berhasil
        if ($response->successful()) {
            // Mendapatkan data alumni dari respons
            $data = $response->json()['data']; // Mengambil data dari respons JSON
            $alumniAktif = [];
            for ($i = 0; $i < count($data); $i++ ) {
                $data[$i]['status'] == 'aktif' ? $alumniAktif[$i] = $data[$i] : '';
            }
        } else {
            $alumniAktif = []; // Jika ada kesalahan, inisialisasi dengan array kosong
        }

        // Mengembalikan tampilan dengan data alumni
        return view('pages.admin.alumni-aktif', compact('alumniAktif'));
    }

    public function alumniPasif()
    {
        $response = Http::get('http://raishaapi3.v-project.my.id/api/alumni'); // Ganti dengan URL yang sesuai

        // Mengecek apakah permintaan berhasil
        if ($response->successful()) {
            // Mendapatkan data alumni dari respons
            $data = $response->json()['data']; // Mengambil data dari respons JSON
            $alumniPasif = [];
            for ($i = 0; $i < count($data); $i++ ) {
                $data[$i]['status'] == 'pasif' ? $alumniPasif[$i] = $data[$i] : '';
            }
        } else {
            $alumniPasif = []; // Jika ada kesalahan, inisialisasi dengan array kosong
        }

        // Mengembalikan tampilan dengan data alumni
        return view('pages.admin.alumni-pasif', compact('alumniPasif'));
    }
}
