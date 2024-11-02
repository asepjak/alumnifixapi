<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    // public function logout(Request $request)
    // {

    //     // Atau jika Anda menggunakan JWT, Anda dapat memanggil API untuk mencabut token
    //     $token = $request->session()->get('token');
    //     $response = Http::withToken($token)->post('http://raishaapi3.v-project.my.id/api/auth/logout');

    //     return redirect()->route('login')->with('message', 'You have been logged out successfully.');
    // }

    public function logout()
    {
        session()->forget(['token', 'user', 'role', 'email']);
        return redirect()->route('home')->with('message', 'You have been logged out');
    }
}
