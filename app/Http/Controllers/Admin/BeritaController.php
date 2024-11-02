<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BeritaController extends Controller
{
    public function index()
    {
        $client = new Client();
        $url = "http://raishaapi3.v-project.my.id/api/berita";
        $response = $client->request('GET', $url);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);
        $berita = $contentArray['data'];
        return view('pages.admin.berita', ['berita' => $berita]);
    }

    public function updateData(Request $request, $id)
    {
        // Validate the incoming request data
        $request->validate([
            'judul_berita' => 'nullable|string|max:255',
            'tanggal_terbit' => 'nullable|date',
            'deskripsi_berita' => 'nullable|string|max:255',
            'link' => 'nullable|string|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Prepare the data to send to the API
        $data = $request->only(['judul_berita', 'tanggal_terbit', 'deskripsi_berita', 'link']);

        // Handle the image upload if present
        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar');
        }

        // Send the PUT request to the API to update the berita
        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                // You can add any other headers here, such as Authorization if needed
            ])->put("http://raishaapi3.v-project.my.id/api/berita/{$id}", $data);

            // Check if the response is successful
            if ($response->successful()) {
                // Redirect back with a success message
                return redirect()->route('berita.index')->with('success', 'Berita updated successfully.');
            } else {
                // Redirect back with an error message
                return redirect()->back()->withErrors(['error' => $response->json('error') ?? 'Failed to update berita.']);
            }
        } catch (\Exception $e) {
            // Log the error and return a redirect with an error message
            Log::error('Error consuming updateBerita API', [
                'message' => $e->getMessage(),
                'request_data' => $request->all(),
                'id' => $id
            ]);

            return redirect()->route('berita.index')->withErrors(['update_error' => 'Gagal memperbarui berita: ' . $e->getMessage()]);
        }
    }

    public function tambahData(Request $request)
    {
        // Validate incoming request data
        $request->validate([
            'judul_berita' => 'required|string|max:255',
            'tanggal_terbit' => 'required|date',
            'deskripsi_berita' => 'required|string|max:255',
            'link' => 'required|string|max:255',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $client = new Client();
        $url = "http://raishaapi3.v-project.my.id/api/berita/";

        // Prepare the data to be sent
        $data = [
            'judul_berita' => $request->judul_berita,
            'tanggal_terbit' => $request->tanggal_terbit,
            'deskripsi_berita' => $request->deskripsi_berita,
            'link' => $request->link,
            'gambar' => $request->file('gambar'), // Make sure to handle this properly in your API
        ];

        try {
            // Send POST request to API
            $response = $client->request('POST', $url, [
                'multipart' => [
                    [
                        'name'     => 'judul_berita',
                        'contents' => $data['judul_berita']
                    ],
                    [
                        'name'     => 'tanggal_terbit',
                        'contents' => $data['tanggal_terbit']
                    ],
                    [
                        'name'     => 'deskripsi_berita',
                        'contents' => $data['deskripsi_berita']
                    ],
                    [
                        'name'     => 'link',
                        'contents' => $data['link']
                    ],
                    [
                        'name'     => 'gambar',
                        'contents' => fopen($data['gambar']->getPathname(), 'r'), // Use fopen to upload files
                        'filename' => $data['gambar']->getClientOriginalName(),
                    ]
                ]
            ]);

            // Get the response body
            $content = $response->getBody()->getContents();
            $contentArray = json_decode($content, true);
            $berita = $contentArray['data'];

            return redirect()->route('berita.index')->with('success', 'Berita added successfully.');
        } catch (\Exception $e) {
            // Handle errors
            return redirect()->route('berita.index')->withErrors(['add_error' => 'Gagal menambahkan berita: ' . $e->getMessage()]);
        }
    }



    public function deleteData($id)
{
    // Mengirim permintaan DELETE ke API
    $response = Http::withToken('your_api_token') // Jika API memerlukan token, tambahkan di sini
        ->delete("http://raishaapi3.v-project.my.id/api/berita/{$id}"); // Ganti dengan URL API Anda

    // Memeriksa status respons
    if ($response->successful()) {
        // Jika berhasil, arahkan kembali dengan pesan sukses
        return redirect()->route('berita.index')->with('success', 'Berita berhasil dihapus.');
    } else {
        // Jika gagal, arahkan kembali dengan pesan error
        return redirect()->route('berita.index')->with('error', 'Gagal menghapus berita. Silakan coba lagi.');
    }
}
}
