<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Perusahaan;
use Illuminate\Http\Request;

class PerusahaanController extends Controller
{

    public function terima_perusahaan($id)
    {
        // Redirect ke halaman perusahaan diterima dengan pesan sukses
        return redirect()->route('perusahaan-diterima')->with('success', 'Perusahaan berhasil diterima');
    }

    public function tolak_perusahaan($id)
    {

        // Redirect ke halaman validasi perusahaan dengan pesan sukses
        return redirect()->route('perusahaan-divalidasi')->with('success', 'Perusahaan berhasil ditolak');
    }

    public function showPerusahaanActive()
    {
        return view('pages.admin.perusahaan-diterima', compact('activePerusahaan'));
    }

    public function showPerusahaanNonActive()
    {
        return view('pages.admin.perusahaan-divalidasi', compact('nonActivePerusahaan'));
    }
}
