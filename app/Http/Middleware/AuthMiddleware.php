<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($this->isAuthenticated($request)) {
                return $next($request);
        }
        return redirect()->route('login')->with('error', 'You need to be logged in to access this page.');
    }
    function isAuthenticated(Request $request): bool
    {
        return Auth::check();
    }
}
