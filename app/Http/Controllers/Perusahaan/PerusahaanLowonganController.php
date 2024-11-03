<?php

namespace App\Http\Controllers\Perusahaan;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
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
        $response = Http::withToken(session('token'))->get('http://raishaapi3.v-project.my.id/api/lowongan'); // Ganti dengan URL yang sesuai

        if ($response->successful()) {
            // Ambil lowongan yang sesuai dengan ID perusahaan
            $lowongans = collect($response->json()['data'])->where('id_perusahaan', $perusahaanId)->all();
        } else {
            Log::error('API request failed', ['status' => $response->status(), 'response' => $response->body()]);
            $lowongans = [];
        }

        return view('pages.perusahaan.lowongan', compact('lowongans'));
    }
    public function store(Request $request)
    {
        // Mengambil ID perusahaan dari sesi
        $client = new Client();
        $url = Http::post('http://raishaapi3.v-project.my.id/api/create-lowongan'); // Ganti dengan URL yang sesuai
        try {
            // Send POST request to API
            $response = $client->request('POST', $url, [
                'multipart' => [
                    [
                        'name'     => 'nib',
                        'contents' => $request->nib
                    ],
                    [
                        'name'     => 'judul_lowongan',
                        'contents' => $request->judul_lowongan
                    ],
                    [
                        'name'     => 'posisi_pekerjaan',
                        'contents' => $request->posisi_pekerjaan
                    ],
                    [
                        'name'     => 'deskripsi_pekerjaan',
                        'contents' => $request->deskripsi_pekerjaan
                    ],
                    [
                        'name'     => 'gambar',
                        'contents' => fopen($request->gambar->getPathname(), 'r'), // Pastikan $request->gambar adalah instance dari UploadedFile
                        'filename' => $request->gambar->getClientOriginalName()
                    ],
                    [
                        'name'     => 'tipe_pekerjaan',
                        'contents' => $request->tipe_pekerjaan
                    ],
                    [
                        'name'     => 'jumlah_kandidat',
                        'contents' => $request->jumlah_kandidat
                    ],
                    [
                        'name'     => 'lokasi',
                        'contents' => $request->lokasi
                    ],
                    [
                        'name'     => 'tanggal_aktif',
                        'contents' => $request->tanggal_aktif //tidakada
                    ],
                    [
                        'name'     => 'rentang_gaji',
                        'contents' => $request->rentang_gaji
                    ],
                    [
                        'name'     => 'pengalaman_kerja',
                        'contents' => $request->pengalaman_kerja
                    ],
                    [
                        'name'     => 'kontak',
                        'contents' => $request->kontak
                    ]
                ]
            ]);

            // Get the response body
            $content = $response->getBody()->getContents();
            dd($content);
            $contentArray = json_decode($content, true);
            $pertanyaan = $contentArray['data'];

            return redirect()->back()->with('success', 'Lowongan berhasil ditambahkan.');
        } catch (\Exception $e) {
            // Handle errors
            return redirect()->back()->withErrors(['add_error' => 'Gagal menambahkan lowongan: ' . $e->getMessage()]);
        }
    }


}
