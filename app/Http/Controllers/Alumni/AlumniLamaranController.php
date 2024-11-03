<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AlumniLamaranController extends Controller
{
    public function index () {
        return view ('pages.alumni.lamaran');
    }
}
