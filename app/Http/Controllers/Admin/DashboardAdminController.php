<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class DashboardAdminController extends Controller
{
    public function index(): View
    {
        $response = Http::get('http://raishaapi3.v-project.my.id/api/alumni');
        $response2 = Http::get('http://raishaapi3.v-project.my.id/api/perusahaan');
        // Cek data
        // dd($response->json());
        $dataAlumni = $response->json();
        $countAktif = 0;
        $countPasif = 0;
        for ($i = 0; $i < count($dataAlumni['data']); $i++ ) {
            $dataAlumni['data'][$i]['status'] == 'pasif' ? $countPasif += 1 : $countAktif += 1;
        }

        return view('pages.admin.dashboard');
    }

}


