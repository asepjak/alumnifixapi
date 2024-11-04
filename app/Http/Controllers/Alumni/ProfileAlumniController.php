<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class ProfileAlumniController extends Controller
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function index($id_alumni)
    {
        // Fetch alumni data from the API
        try {
            $response = $this->client->request('GET', "http://127.0.0.1:8000/api/alumni/{$id_alumni}");
            $alumni = json_decode($response->getBody()->getContents(), true);
            return view('pages.alumni.profile', compact('alumni'));
        } catch (\Exception $e) {
            Log::error('Failed to fetch alumni data: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to fetch alumni data.');
        }
    }

    public function edit($id_alumni)
    {
        // Fetch alumni data from the API for editing
        try {
            $response = $this->client->request('GET', "http://127.0.0.1:8000/api/alumni/{$id_alumni}");
            $alumni = json_decode($response->getBody()->getContents(), true);
            return view('pages.alumni.edit', compact('alumni')); // Ensure the edit view path is correct
        } catch (\Exception $e) {
            Log::error('Failed to fetch alumni data for edit for ID ' . $id_alumni . ': ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to fetch alumni data for editing.');
        }
    }

    public function update(Request $request, $id_alumni)
    {
        // Validate incoming request data
        $request->validate([
            'nama_alumni' => 'required|string|max:255',
            'email' => 'required|email',
            'no_tlp' => 'required|string|max:15',
            'alamat' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'password' => 'nullable|string|min:8|confirmed',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['nama_alumni', 'email', 'no_tlp', 'alamat', 'tanggal_lahir']);

        // Handle image upload
        if ($request->hasFile('gambar')) {
            // Store the image and get the path
            $data['gambar'] = $request->file('gambar')->store('profile_images', 'public');
        }

        // Send a PUT request to the API
        try {
            $response = $this->client->request('PUT', "http://127.0.0.1:8000/api/alumni/update/{$id_alumni}", [
                'form_params' => $data,
            ]);

            if (in_array($response->getStatusCode(), [200, 204])) {
                return redirect()->route('alumni.profile', $id_alumni)->with('success', 'Alumni updated successfully.');
            } else {
                return redirect()->back()->with('error', 'Failed to update profile.');
            }
        } catch (\Exception $e) {
            Log::error('Failed to update alumni profile: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while updating the profile.');
        }
    }

    public function delete($id_alumni)
    {
        // Send a DELETE request to the API
        try {
            $response = $this->client->request('DELETE', "http://127.0.0.1:8000/api/delete-alumni/{$id_alumni}");

            if ($response->getStatusCode() == 200) {
                return redirect()->route('alumni.list')->with('success', 'Alumni deleted successfully.'); // Adjust the route as needed
            } else {
                return redirect()->back()->with('error', 'Failed to delete alumni profile.');
            }
        } catch (\Exception $e) {
            Log::error('Failed to delete alumni profile: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while deleting the profile.');
        }
    }
}
