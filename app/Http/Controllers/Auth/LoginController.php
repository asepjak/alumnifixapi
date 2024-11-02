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
    // Validate input fields
    $request->validate([
        'nomor_induk' => 'required',
        'password' => 'required',
    ]);

    // Get nomor_induk and password from the request
    $nomor_induk = $request->input('nomor_induk');
    $password = $request->input('password');

    // Make an API call to the login endpoint
    $response = Http::post('http://raishaapi3.v-project.my.id/api/login', [
        'nomor_induk' => $nomor_induk,
        'password' => $password,
    ]);

    // Check if the request was successful
    if ($response->successful()) {
        // Extract data from the response
        $data = $response->json();
        $token = $data['token'];
        $user = $data['user'];
        $role = $user['role']; // Assume roles: 0 = admin, 1 = alumni, 2 = perusahaan

        // Store token and user details in the session
        session([
            'token' => $token,
            'user' => $user,
            'role' => $role,
            'email' => $user['email'],
        ]);

        // Redirect based on the user role
        if ($role === 0) {
            return redirect()->route('dashboardAdmin')->with('success', $data['message']);
        } elseif ($role === 1) {
            return redirect()->route('dashboardAlumni')->with('success', $data['message']);
        } elseif ($role === 2) {
            return redirect()->route('dashboardPerusahaan')->with('success', $data['message']);
        }

        // Default redirection if no specific role matches
        return redirect()->route('dashboard')->with('success', $data['message']);
    } elseif ($response->status() === 401) {
        // Handle unauthorized error
        return back()->withErrors(['login_error' => 'Unauthorized. Please check your credentials.']);
    } else {
        // Handle other errors
        return back()->withErrors(['login_error' => 'An error occurred. Please try again later.']);
    }
}

}
