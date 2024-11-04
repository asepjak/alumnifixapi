<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class RegisterController extends Controller
{
    public function index(): View
    {
        return view('pages.auth.register_user');
    }

    public function indexAlumni(): View
    {
        return view('pages.auth.register_alumni');
    }

    public function indexPerusahaan(): View
    {
        return view('pages.auth.register_perusahaan');
    }

    public function registerAlumni(Request $request)
    {
        // Validate request data
        $request->validate([
            'role' => 'required|in:1', // Role for alumni
            'name' => 'required|string|max:255',
            'angkatan' => 'required|string',
            'nomor_induk' => 'required|string|max:10',
            'alamat' => 'required|string',
            'no_tlp' => 'required|string',
            'email' => 'required|email|unique:alumni',
            // 'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Prepare data for API consumption
        $data = [
            'user_id' => $request->user_id,
            'name' => $request->name,
            'angkatan' => $request->angkatan,
            'alamat' => $request->alamat,
            'no_tlp' => $request->no_tlp,
            'email' => $request->email,
            'role' => 1, // Set role for alumni
        ];

        // Send data to API
        try {
            $response = Http::attach('foto', fopen($request->file('foto')->getRealPath(), 'r'), $request->file('foto')->getClientOriginalName())
                ->post(env('API_BASE_URL') . '/api/auth/register-alumni', $data);

            // Check for successful response
            if ($response->successful()) {
                // Process if registration is successful
                $data = $response->json(); // Get JSON data from response

                // Save token and role in session
                session(['token' => $data['token']]);
                session(['role' => $data['user']['role']]);
                // session(['username' => $data['user']['username']]);
                session(['name' => $data['name']]);

                // Display user data on dashboard page
                return view('pages.alumni.dashboard', ['user' => $data['user']]);
            } else {
                // Log error response from API
                Log::error('Registration failed', [
                    'response_status' => $response->status(),
                    'response_data' => $response->json(),
                ]);

                // Handle API error response
                return $this->handleApiError($response);
            }
        } catch (\Exception $e) {
            Log::error('Server Error', ['exception' => $e->getMessage()]);
            return back()->withErrors(['registration_error' => ['Terjadi kesalahan server. Silakan coba lagi nanti.']]);
        }
    }

    public function registerPerusahaan(Request $request)
    {
        // Validate user input
        $request->validate([
            'role' => 'required|in:2', // Role for company
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:perusahaan,email',
            'nama_perusahaan' => 'required|string|max:255',
            'nib' => 'required|string|max:255',
            'sektor_bisnis' => 'required|string|max:255',
            'deskripsi_perusahaan' => 'required|string',
            'jumlah_karyawan' => 'required|integer',
            'no_telp' => 'required|string|max:20',
            'alamat' => 'required|string|max:255',
            'website_perusahaan' => 'nullable|url|max:255',
            'password' => 'required|string|confirmed|min:8',
        ]);

        // Prepare data to be sent to API
        $data = [
            'username' => $request->username,
            'email' => $request->email,
            'nama_perusahaan' => $request->nama_perusahaan,
            'nib' => $request->nib,
            'sektor_bisnis' => $request->sektor_bisnis,
            'deskripsi_perusahaan' => $request->deskripsi_perusahaan,
            'jumlah_karyawan' => $request->jumlah_karyawan,
            'no_telp' => $request->no_telp,
            'alamat' => $request->alamat,
            'website_perusahaan' => $request->website_perusahaan,
            'password' => $request->password,
            'password_confirmation' => $request->password_confirmation,
            'role' => 2, // Set role for company
        ];

        try {
            // Send request to API
            $response = Http::post(env('API_BASE_URL') . '/api/auth/register-perusahaan', $data);

            // Check for successful response
            if ($response->successful()) {
                $responseData = $response->json();

                // Save relevant session data
                session([
                    'token' => $responseData['token'],
                    'role' => $responseData['user']['role'],
                    // 'username' => $responseData['user']['username'],
                    'nama_perusahaan' => $responseData['perusahaan']['name'],
                ]);

                return redirect()->route('dashboard')->with('success', 'Perusahaan berhasil didaftarkan.');
            } else {
                Log::error('Registration failed', [
                    'response_status' => $response->status(),
                    'response_data' => $response->json(),
                ]);

                return $this->handleApiError($response);
            }
        } catch (\Exception $e) {
            Log::error('Server Error', ['exception' => $e->getMessage()]);
            return redirect()->back()->withErrors(['registration_error' => ['Terjadi kesalahan server. Silakan coba lagi nanti.']]);
        }
    }

    private function handleApiError($response)
    {
        // Handle API error response
        $errorMessage = $response->json()['message'] ?? 'Registration failed';
        $additionalErrors = $response->json()['errors'] ?? []; // Assuming the API returns detailed errors

        // Create an array to store all errors
        $allErrors = [$errorMessage];

        // Merge additional errors if any
        if (is_array($additionalErrors) && count($additionalErrors) > 0) {
            foreach ($additionalErrors as $key => $messages) {
                if (is_array($messages)) {
                    $allErrors = array_merge($allErrors, $messages);
                } else {
                    $allErrors[] = $messages;
                }
            }
        }

        // Return back with all errors
        return back()->withErrors(['registration_error' => $allErrors]);
    }
}
