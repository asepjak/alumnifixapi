<?php

namespace App\Http\Controllers\Perusahaan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardPerusahaanController extends Controller
{
    public function index(): View
    {
        return view('pages.perusahaan.dashboard');
    }
}
