<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JawabanTertutup;
use App\Models\Pertanyaan;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class PertanyaanController extends Controller
{
    public function create()
    {
        return view('pages.admin.tambah-pertanyaan'); // Tampilkan view untuk formulir
    }

    public function index()
    {
        $response = Http::get('http://raishaapi3.v-project.my.id/api/pertanyaan'); // Ganti dengan URL yang sesuai

        // Mengecek apakah permintaan berhasil
        if ($response->successful()) {
            // Mendapatkan data alumni dari respons
            $pertanyaan = $response->json()['data']; // Mengambil data dari respons JSON
        } else {
            $pertanyaan = []; // Jika ada kesalahan, inisialisasi dengan array kosong
        }
        // Mengambil semua data pertanyaan dari database
        return view('pages.admin.pertanyaan', compact('pertanyaan'));
    }

    /**
     * Menyimpan pertanyaan baru ke dalam database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $client = new Client();
        $data = [
            'pertanyaan' => $request->pertanyaan,
            'jenis' => $request->jenis,
        ];
        $url = Http::post('http://raishaapi3.v-project.my.id/api/create-pertanyaan'); // Ganti dengan URL yang sesuai
        try {
            // Send POST request to API
            $response = $client->request('POST', $url, [
                'multipart' => [
                    [
                        'name'     => 'pertanyaan',
                        'contents' => $data['pertanyaan']
                    ],
                    [
                        'name'     => 'jenis',
                        'contents' => $data['jenis']
                    ]
                ]
            ]);

            // Get the response body
            $content = $response->getBody()->getContents();
            $contentArray = json_decode($content, true);
            $pertanyaan = $contentArray['data'];

            return redirect()->back()->with('success', 'Pertanyaan berhasil ditambahkan.');
        } catch (\Exception $e) {
            // Handle errors
            return redirect()->back()->withErrors(['add_error' => 'Gagal menambahkan berita: ' . $e->getMessage()]);
        }
    }


    // Menghapus pertanyaan dari database
    public function update(Request $request, $id)
    {
        // Redirect dengan pesan sukses
        return redirect()->route('pertanyaan.index')->with('success', 'Pertanyaan berhasil diperbarui!');
    }

    public function edit($id)
    {
        return view('pertanyaan.edit', compact('pertanyaan')); // Ganti dengan view yang sesuai
    }

    public function delete($id)
    {
        return redirect()->back()->with('success', 'Data Berhasil di hapus');
    }
}
