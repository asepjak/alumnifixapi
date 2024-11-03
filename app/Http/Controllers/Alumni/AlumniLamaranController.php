<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AlumniLamaranController extends Controller
{
    public function index () {
        $response = Http::get('http://raishaapi3.v-project.my.id/api/lamaran'); // Ganti dengan URL yang sesuai

        // Mengecek apakah permintaan berhasil
        if ($response->successful()) {
            // Mendapatkan data alumni dari respons
            $lamaran = $response->json()['data']; // Mengambil data dari respons JSON
        } else {
            $lamaran = []; // Jika ada kesalahan, inisialisasi dengan array kosong
        }
        return view ('pages.alumni.lamaran', compact('lamaran'));
    }
}
