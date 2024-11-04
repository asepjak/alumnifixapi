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

    // public function register(Request $request) {

    //     $response = Http::attach('foto', fopen($request->file('foto')->getRealPath(), 'r'), $request->file('foto')->getClientOriginalName())
    //     ->post('https://raishaapi3.v-project.my.id/api/register', $request->all());

    //     if ($response->successful()) {
    //         // Process if registration is successful
    //         $responseData = $response->json(); // Get JSON data from response

    //         // Save token and role in session
    //         session(['token' => $responseData['token']]); // Save token
    //         session(['role' => $responseData['user']['role']]); // Save role
    //         session(['username' => $responseData['user']['username']]); // Save username
    //         session(['nama' => $responseData['user']['nama_alumni']]); // Save alumni name

    //         // Redirect to alumni dashboard
    //         return redirect()->route('alumni.dashboard')->with('success', 'Registration successful, please login.');
    //     } else {
    //         // Log the error response from the API
    //         Log::error('Registration failed', [
    //             'response_status' => $response->status(),
    //             'response_data' => $response->json(),
    //         ]);

    //         // Handle API error response
    //         $errorMessage = $response->json()['message'] ?? 'Registration failed';
    //         $additionalErrors = $response->json()['errors'] ?? []; // Assuming the API returns detailed errors

    //         // Create an array to store all errors
    //         $allErrors = [$errorMessage];

    //         // Merge additional errors if any
    //         if (is_array($additionalErrors) && count($additionalErrors) > 0) {
    //             foreach ($additionalErrors as $key => $messages) {
    //                 if (is_array($messages)) {
    //                     $allErrors = array_merge($allErrors, $messages);
    //                 } else {
    //                     $allErrors[] = $messages;
    //                 }
    //             }
    //         }

    //         // Return back with all errors
    //         return back()->withErrors(['registration_error' => $allErrors]);
    //     }
    // }

    public function registerAlumni(Request $request)
    {
        // Validate data request
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'nama_alumni' => 'required|string|max:255',
            'nim' => 'required|string|max:10',
            'angkatan' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'no_tlp' => 'required|string',
            'email' => 'required|email|unique:alumni',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:aktif,pasif',
        ]);

        // Prepare data for API consumption
        $data = [
            'user_id' => $request->user_id,
            'nama_alumni' => $request->nama_alumni,
            'angkatan' => $request->angkatan,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat' => $request->alamat,
            'no_tlp' => $request->no_tlp,
            'email' => $request->email,
            'status' => $request->status,
        ];

        // Consume API for alumni registration
        $response = Http::attach('foto', fopen($request->file('foto')->getRealPath(), 'r'), $request->file('foto')->getClientOriginalName())
            ->post(env('API_BASE_URL') . '/api/auth/register-alumni', $data);

        // Check for successful response
        if ($response->successful()) {
            // Process if registration is successful
            $data = $response->json(); // Get JSON data from response

            // Save token and role in session
            session(['token' => $data['token']]); // Save token
            session(['role' => $data['user']['role']]); // Save role
            session(['username' => $data['user']['username']]); // Save username
            session(['nama' => $data['nama_alumni']]); // Save username

            // Show response information on dashboard page
            return view('pages.alumni.dashboard', ['user' => $data['user']]); // Send user data to view
        } else {
            // Log the error response from the API
            Log::error('Registration failed', [
                'response_status' => $response->status(),
                'response_data' => $response->json(),
            ]);

            // Handle API error response
            $errorMessage = $response->json()['message'] ?? 'Registration failed';
            $additionalErrors = $response->json()['errors'] ?? []; // Assuming the API returns detailed errors

            // Create an array to store all errors
            $allErrors = [$errorMessage];

            // Merge additional errors if any
            if (is_array($additionalErrors) && count($additionalErrors) > 0) {
                // Flatten the errors array if it is structured with keys
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

    public function registerPerusahaan(Request $request)
    {
        // Validasi input pengguna
        $request->validate([
            'username' => 'required|string',
            'email' => 'required|string|email|max:255',
            'nama_perusahaan' => 'required|string|max:255',
            'nib' => 'required|string',
            'sektor_bisnis' => 'required|string|max:255',
            'deskripsi_perusahaan' => 'required|string',
            'jumlah_karyawan' => 'required|integer',
            'no_telp' => 'required|string|max:20',
            'alamat' => 'required|string|max:255',
            'website_perusahaan' => 'nullable|url|max:255',
            'password' => 'required|string|confirmed|min:8',
        ]);

        // Menyusun data untuk dikirim ke API
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
        ];

        try {
            // Kirim permintaan ke API
            $response = Http::post(env('API_BASE_URL') . '/api/auth/register-perusahaan', $data);

            // Memeriksa keberhasilan respons
            if ($response->successful()) {
                $responseData = $response->json();

                // Simpan data session yang relevan
                session([
                    'token' => $responseData['token'],
                    'role' => $responseData['user']['role'],
                    'username' => $responseData['user']['username'],
                    'nama_perusahaan' => $responseData['perusahaan']['nama_perusahaan'],
                ]);

                return redirect()->route('dashboard')->with('success', 'Perusahaan registered successfully');
            } else {
                Log::error('Registration failed', [
                    'response_status' => $response->status(),
                    'response_data' => $response->json(),
                ]);

                $errorMessage = $response->json()['message'] ?? 'Registration failed';
                $additionalErrors = $response->json()['errors'] ?? [];

                $allErrors = [$errorMessage];
                if (is_array($additionalErrors) && count($additionalErrors) > 0) {
                    foreach ($additionalErrors as $key => $messages) {
                        $allErrors = is_array($messages) ? array_merge($allErrors, $messages) : array_merge($allErrors, [$messages]);
                    }
                }

                return redirect()->back()->withErrors(['registration_error' => $allErrors]);
            }
        } catch (\Exception $e) {
            Log::error('Server Error', ['exception' => $e->getMessage()]);
            return redirect()->back()->withErrors(['registration_error' => ['Server error occurred. Please try again later.']]);
        }
    }
}
