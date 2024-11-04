<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;


class LoginController extends Controller
{
    public function index(): View
    {
        return view('pages.auth.login');
    }


    public function login(Request $request)
{
    $response = Http::post('http://raishaapi3.v-project.my.id/api/login', [
        'nomor_induk' => $request->nomor_induk,
        'password' => $request->password,
    ]);

    if ($response->successful()) {
        // Store token and user information in session
        $data = $response->json();
        session([
            'token' => $data['token'],
            'user' => $data['user'],
            'role' => $data['user']['role'],
            'email' => $data['user']['email'],
        ]);

        // Redirect based on user role
        if ($data['user']['role'] === 0) {
            return redirect()->route('dashboardAdmin')->with('message', $data['message']);
        } elseif ($data['user']['role'] === 1) {
            return redirect()->route('dashboard.alumni')->with('message', $data['message']);
        } elseif ($data['user']['role'] === 2) {
            return redirect()->route('dashboardPerusahaan')->with('message', $data['message']);
        }

        // Default redirect to home if no role matches
        return redirect()->route('home')->with('message', $data['message']);
    }

    return redirect()->back()->withErrors(['error' => 'Login failed']);
}



}
