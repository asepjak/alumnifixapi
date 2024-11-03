<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class RegisterAlumniController extends Controller
{
    public function showRegisterForm()
    {
        return view('pages.auth.register_alumni');
    }

    public function registerAlumni(Request $request)
    {
        // Validate input from request
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|min:3|max:50',
            'nim' => 'required|string|unique:alumni,nim',
            'nama_alumni' => 'required|string|min:3|max:100',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string|min:5',
            'no_tlp' => 'required|string|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'email' => 'required|email|unique:alumni,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return back()
                ->withInput($request->except('password', 'password_confirmation'))
                ->withErrors($validator);
        }

        try {
            // Prepare data for API
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

            // Send data to API
            $response = Http::post('http://raishaapi3.v-project.my.id/api/register', $data);
            $responseData = $response->json();

            if ($response->successful()) {
                // Store user data in session
                session([
                    'token' => $responseData['token'],
                    'role' => $responseData['user']['role'],
                    'username' => $responseData['user']['username'],
                    'nama' => $responseData['user']['nama_alumni'],
                ]);

                // Redirect with success message
                return redirect()->route('alumni.dashboard')
                    ->with('success', 'Registration successful! Welcome to the alumni dashboard.');
            }

            // Handle API error response
            Log::error('Alumni registration failed', [
                'response_status' => $response->status(),
                'response_data' => $responseData
            ]);

            return back()
                ->withInput($request->except('password', 'password_confirmation'))
                ->withErrors(['registration_error' => $responseData['message'] ?? 'Registration failed. Please try again.']);

        } catch (\Exception $e) {
            Log::error('Server Error during alumni registration', [
                'exception' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()
                ->withInput($request->except('password', 'password_confirmation'))
                ->withErrors(['registration_error' => 'An error occurred on the server. Please try again later.']);
        }
    }
}
