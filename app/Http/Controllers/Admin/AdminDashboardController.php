<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Alumni;
use App\Models\Perusahaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        $response = Http::get('http://raishaapi3.v-project.my.id/api/alumni');
        $response2 = Http::get('http://raishaapi3.v-project.my.id/api/perusahaan');
        // Cek data
        // dd($response->json());
        $dataAlumni = $response->json();
        $dataPerusahaan = $response2->json();
        $countAktif = 0;
        $countPasif = 0;
        $countMenunggu = 0;
        $countDitolak = 0;
        $countDiterima = 0;
        for ($i = 0; $i < count($dataAlumni['data']); $i++ ) {
            $dataAlumni['data'][$i]['status'] == 'pasif' ? $countPasif += 1 : $countAktif += 1;
        }
        for ($i = 0; $i < count($dataPerusahaan['data']); $i++ ) {
            $dataPerusahaan['data'][$i]['status'] == 'menunggu' ? $countMenunggu += 1 :
            ($dataPerusahaan['data'][$i]['status'] == 'ditolak' ? $countDitolak += 1 : $countDiterima += 1);
        }

        return view('pages.admin.dashboard', compact(['countAktif', 'countPasif', 'countMenunggu', 'countDitolak', 'countDiterima']));
    }
}
