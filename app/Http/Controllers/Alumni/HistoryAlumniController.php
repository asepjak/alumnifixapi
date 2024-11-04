<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class HistoryAlumniController extends Controller
{
    public function index()
    {
        // Initialize Guzzle client
        $client = new Client();
        $applications = [];

        // Fetch data from the first API endpoint
        try {
            $response1 = $client->request('GET', 'http://127.0.0.1:8000/api/create/lamaran/1');
            $applications = json_decode($response1->getBody()->getContents(), true);
        } catch (\Exception $e) {
            // Handle the exception, log it or return an error message
            \Log::error('API request failed: ' . $e->getMessage());
            // Optionally, you can set $applications to an empty array or return a view with an error message
        }

        // Return the view with the applications data
        return view('pages.alumni.history', compact('applications'));
    }
}
