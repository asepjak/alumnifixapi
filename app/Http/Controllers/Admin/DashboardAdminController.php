<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class DashboardAdminController extends Controller
{
    public function index(): View
    {
        Log::debug('Session data:', session()->all());
        return view('pages.admin.dashboard');
    }

}


