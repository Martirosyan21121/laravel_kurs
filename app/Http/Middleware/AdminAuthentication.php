<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
class AdminAuthentication
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($this->isAuthenticated($request) && $this->isAdminOfType($request, 'ADMIN')) {
            return $next($request);
        }

        return redirect()->route('login')->with('error', 'You need to be logged in as a user to access this page.');
    }
    public function isAuthenticated(Request $request): bool
    {
       return Auth::check();
    }
    function isAdminOfType(Request $request, string $userType): bool
    {
        $user = Auth::user();
        if ($user && isset($user->type) && $user->type === $userType) {
            return true;
        }
        return false;
    }
}
