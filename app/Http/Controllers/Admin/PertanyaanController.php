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
        // Redirect with a success message
        return redirect()->back()->with('success', 'Pertanyaan berhasil ditambahkan.');
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
