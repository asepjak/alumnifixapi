<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class CheckToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if there is a token in the session
        if (!Session::has('token')) {
            // If no token, redirect to the login page instead of the dashboard
            return redirect()->route('login')->withErrors(['error' => 'You must be logged in to access this feature.']);
        }

        return $next($request);
    }

}
