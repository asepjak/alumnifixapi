<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lowongan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AdminLowonganController extends Controller
{
    public function LowonganDiterima()
    {
        $response = Http::get('http://raishaapi3.v-project.my.id/api/lowongan'); // Ganti dengan URL yang sesuai

        // Mengecek apakah permintaan berhasil
        if ($response->successful()) {
            // Mendapatkan data alumni dari respons
            $data = $response->json()['data']; // Mengambil data dari respons JSON
            $showLowonganDiterima = [];

            for ($i = 0; $i < count($data); $i++ ) {
                $data[$i]['status'] == 'diterima' ? $showLowonganDiterima[$i] = $data[$i] : '';
            }

        } else {
            $showLowonganDiterima = []; // Jika ada kesalahan, inisialisasi dengan array kosong
        }
        return view('pages.admin.lowongan-diterima', compact('showLowonganDiterima'));
    }

    public function LowonganDivalidasi()
    {
        $response = Http::get('http://raishaapi3.v-project.my.id/api/lowongan'); // Ganti dengan URL yang sesuai

        // Mengecek apakah permintaan berhasil
        if ($response->successful()) {
            // Mendapatkan data alumni dari respons
            $data = $response->json()['data']; // Mengambil data dari respons JSON
            $showLowonganDivalidasi = [];

            for ($i = 0; $i < count($data); $i++ ) {
                $data[$i]['status'] == 'pending' ? $showLowonganDivalidasi[$i] = $data[$i] : '';
            }

        } else {
            $showLowonganDivalidasi = []; // Jika ada kesalahan, inisialisasi dengan array kosong
        }
        return view('pages.admin.lowongan-divalidasi', compact('showLowonganDivalidasi'));
    }

    public function terima_lowongan($id)
    {
        // Redirect ke halaman perusahaan diterima dengan pesan sukses
        return redirect()->route('lowongan-diterima')->with('success', 'lowongan berhasil diterima');
    }

    public function tolak_lowongan($id)
    {

        // Redirect ke halaman perusahaan diterima dengan pesan sukses
        return redirect()->route('lowongan-ditolak')->with('success', 'lowongan berhasil ditolak');
    }

}
