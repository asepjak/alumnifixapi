<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AdminPertanyaanController extends Controller
{
    public function pertanyaan()
    {
        $response = Http::withToken(session('token'))->get('http://raishaapi3.v-project.my.id/api/pertanyaan'); // Ganti dengan URL yang sesuai

        if ($response->successful()) {
            // Ambil lowongan yang sesuai dengan ID perusahaan
            $lowongans = $response->json()['data'];
            dd($lowongans);
        } else {
            Log::error('API request failed', ['status' => $response->status(), 'response' => $response->body()]);
            $lowongans = [];
        }
        // Redirect ke halaman perusahaan diterima dengan pesan sukses
        return view ('pages.admin.pertanyaan', compact('lowongans'));
    }

}
