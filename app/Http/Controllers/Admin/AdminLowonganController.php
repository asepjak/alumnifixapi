<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lowongan;
use Illuminate\Http\Request;

class AdminLowonganController extends Controller
{
    public function showLowonganDiterima()
    {
        //
        return view('pages.admin.lowongan-diterima', compact('showLowonganDiterima'));
    }

    public function showLowonganDivalidasi()
    {
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
