<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminPertanyaanController extends Controller
{
    public function index()
    {
        // Redirect ke halaman perusahaan diterima dengan pesan sukses
        return view ('pages.admin.pertanyaan');
    }

}
