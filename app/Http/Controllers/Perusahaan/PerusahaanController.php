<?php

namespace App\Http\Controllers\Perusahaan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PerusahaanController extends Controller
{
    public function index () {
        return view ('pages.alumni.dashboard.perusahaan');  
    }
}
