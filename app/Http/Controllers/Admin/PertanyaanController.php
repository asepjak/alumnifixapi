<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JawabanTertutup;
use App\Models\Pertanyaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PertanyaanController extends Controller
{
    public function create()
    {
        return view('pages.admin.tambah-pertanyaan'); // Tampilkan view untuk formulir
    }

    public function index()
    {
        // Mengambil semua data pertanyaan dari database
        $data = Pertanyaan::all();
        return view('pages.admin.pertanyaan', compact('data'));
    }

    /**
     * Menyimpan pertanyaan baru ke dalam database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validate the form input
        $request->validate([
            'pertanyaan' => 'required|string|max:255',
            'jenis' => 'required|in:terbuka,skala',
        ]);

        // Create a new question
        Pertanyaan::create([
            'pertanyaan' => $request->input('pertanyaan'),
            'jenis' => $request->input('jenis'),
        ]);

        // Redirect with a success message
        return redirect()->back()->with('success', 'Pertanyaan berhasil ditambahkan.');
    }


    // Menghapus pertanyaan dari database
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'pertanyaan' => 'required|string|max:255',
        ]);

        // Temukan pertanyaan berdasarkan ID
        $data = Pertanyaan::findOrFail($id);

        // Update field pertanyaan
        $data->pertanyaan = $request->pertanyaan;
        $data->jenis = $request->jenis;
        $data->save(); // Simpan perubahan

        // Redirect dengan pesan sukses
        return redirect()->route('pertanyaan.index')->with('success', 'Pertanyaan berhasil diperbarui!');
    }

    public function edit($id)
    {
        $pertanyaan = Pertanyaan::findOrFail($id);
        return view('pertanyaan.edit', compact('pertanyaan')); // Ganti dengan view yang sesuai
    }

    public function delete($id)
    {
        Pertanyaan::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Data Berhasil di hapus');
    }
}
