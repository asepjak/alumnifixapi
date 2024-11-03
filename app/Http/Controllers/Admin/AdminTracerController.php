<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AdminTracerController extends Controller
{
    //
    public function index(){
        $response = Http::withToken(session('token'))->get('http://raishaapi3.v-project.my.id/api/tracerstudy'); // Ganti dengan URL yang sesuai

        if ($response->successful()) {
            // Ambil lowongan yang sesuai dengan ID perusahaan
            $data = $response->json()['data'];
        } else {
            $data = [];
        }
        return view('pages.admin.data-tracer', compact('data'));
    }
}
