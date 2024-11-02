<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class DashboardAlumniController extends Controller
{
    public function index(): View
    {
        return view('pages.alumni.dashboard_alumni');
    }

}


