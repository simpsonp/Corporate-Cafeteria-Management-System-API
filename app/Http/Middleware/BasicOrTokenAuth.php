<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class BasicOrTokenAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        // Attempt Basic Authentication manually
        if ($this->attemptBasicAuth($request)) {
            return $next($request);
        }

        // If Basic Auth fails, attempt API token authentication
        $user = Auth::guard('sanctum')->authenticate();

        // If API token authentication fails, will automatically throw \Illuminate\Auth\AuthenticationException

        // API token authentication succeeds, set the current user.
        Auth::setUser($user);
        return $next($request);
    }

    private function attemptBasicAuth(Request $request)
    {
        // Manually extract the Authorization header
        $credentials = $request->getUser() && $request->getPassword();

        // If the credentials are absent, fail authentication
        if (!$credentials) {
            return false;
        }

        // If the credentials are present, attempt to authenticate
        if (Auth::guard('web')->attempt(['email' => $request->getUser(), 'password' => $request->getPassword()])) {
            return true;
        }

        // If authentication fails
        return false;
    }
}
