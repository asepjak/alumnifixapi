<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class RegisterController extends Controller
{
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
        // Validate data request
        $request->validate([
            'username' => 'required|string',
            'nim' => 'required|string',
            'nama_alumni' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'no_tlp' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string',
            'password_confirmation' => 'required|string|same:password',
        ]);

        // Prepare data for API consumption
        $data = [
            'username' => $request->username,
            'nim' => $request->nim,
            'nama_alumni' => $request->nama_alumni,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat' => $request->alamat,
            'no_tlp' => $request->no_tlp,
            'email' => $request->email,
            'password' => $request->password,
            'password_confirmation' => $request->password_confirmation,
        ];

        // Consume API for alumni registration
        $response = Http::post('http://raishaapi3.v-project.my.id/api/register', $data);

        // Check for successful response
        if ($response->successful()) {
            // Process if registration is successful
            $responseData = $response->json(); // Get JSON data from response

            // Save token and role in session
            session(['token' => $responseData['token']]); // Save token
            session(['role' => $responseData['user']['role']]); // Save role
            session(['username' => $responseData['user']['username']]); // Save username
            session(['nama' => $responseData['user']['nama_alumni']]); // Save alumni name

            // Redirect to alumni dashboard
            return redirect()->route('alumni.dashboard')->with('success', 'Registration successful, please login.');
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
        // Validate user input
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

        // Prepare data for API consumption
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
            // Send request to API
            $response = Http::post('http://raishaapi3.v-project.my.id/api/register-perusahaan', $data);

            // Check for successful response
            if ($response->successful()) {
                $responseData = $response->json();

                // Save relevant session data
                session([
                    'token' => $responseData['token'],
                    'role' => $responseData['user']['role'],
                    'username' => $responseData['user']['username'],
                    'nama_perusahaan' => $responseData['perusahaan']['nama_perusahaan'],
                ]);

                return redirect()->route('dashboard')->with('success', 'Company registered successfully');
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

                return back()->withErrors(['registration_error' => $allErrors]);
            }
        } catch (\Exception $e) {
            Log::error('Server Error', ['exception' => $e->getMessage()]);
            return back()->withErrors(['registration_error' => ['An error occurred on the server. Please try again later.']]);
        }
    }
}
