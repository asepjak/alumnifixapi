<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    public function indexHome(Request $request)
    {
        // Mengembalikan view dengan data yang diambil dari API
        return view('pages.home');
    }

    public function indexAlumni(Request $request)
    {
        // Make a GET request to the alumni API
        $response = Http::get('http://raishaapi3.v-project.my.id/api/alumni'); // Adjust the URL as necessary

        // Check if the response was successful
        if ($response->successful()) {
            $data = $response->json(); // Decode the JSON response

            // You can now access alumni data directly
            $alumni = $data['data']; // This contains all alumni data
            return view('pages.alumni', [
                'alumni' => $alumni, // Pass the alumni data directly to the view
            ]);
        } else {
            // Handle errors (e.g., log or return an error view)
            return response()->json(['status' => 'error', 'message' => 'Failed to fetch alumni data'], 500);
        }
    }


    public function indexLoker(Request $request)
    {
        // Make a GET request to the lowongan API
        $response = Http::get('http://raishaapi3.v-project.my.id/api/lowongan'); // Adjust the URL as necessary
        // Check if the response was successful
        if ($response->successful()) {
            $data = $response->json(); // Decode the JSON response

            // Access the lowongan data
            $loker = $data['data']; // This contains the lowongan data

            // Return a view with the lowongan data
            return view('pages.lowongan', [
                'loker' => $loker,
            ]);
        } else {
            // Handle errors (e.g., log or return an error view)
            return response()->json(['status' => 'error', 'message' => 'Failed to fetch lowongan data'], 500);
        }
    }

    public function getLowonganDetail($id)
    {
        // Make a GET request to the lowongan API with the specified ID
        $response = Http::get("http://raishaapi3.v-project.my.id/api/lowongan/{$id}"); // Adjust the URL if necessary

        // Check if the response was successful
        if ($response->successful()) {
            $data = $response->json(); // Decode the JSON response

            // Access the lowongan data
            $lowongan = $data['data']; // This contains the lowongan details

            // Return a view with the lowongan details
            return view('pages.lowongan-detail', [
                'lowongan' => $lowongan,
            ]);
        } else {
            // Handle errors (e.g., log or return an error view)
            return response()->json(['status' => 'error', 'message' => 'Failed to fetch lowongan details'], 500);
        }
    }
}
