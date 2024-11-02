<?php

namespace App\Http\Controllers\Perusahaan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PerusahaanLowonganController extends Controller
{
    public function lowongan()
    {
        // Mengambil ID perusahaan dari sesi
        $perusahaanId = session('id_perusahaan'); // Ambil id_perusahaan dari sesi

        // Mengirim permintaan GET ke endpoint API
        $response = Http::withToken(session('token'))->get('http://raishaapi3.v-project.my.id/api/lowongan/lihat-lowongan'); // Ganti dengan URL yang sesuai

        if ($response->successful()) {
            // Ambil lowongan yang sesuai dengan ID perusahaan
            $lowongans = collect($response->json()['lowongans'])->where('id_perusahaan', $perusahaanId)->all();
        } else {
            Log::error('API request failed', ['status' => $response->status(), 'response' => $response->body()]);
            $lowongans = [];
        }

        return view('pages.perusahaan.lowongan', compact('lowongans'));
    }



}
