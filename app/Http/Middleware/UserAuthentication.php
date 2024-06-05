<?php

namespace App\Http\Middleware;

use App\Models\Task;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
class UserAuthentication
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($this->isAuthenticated($request) && $this->isUserOfType($request, 'USER')) {
            $routeId = $request->route()->parameter('id');
            if ($routeId === null) {
                return $next($request);
            } else if (Auth::id() == $routeId) {
                return $next($request);
            } else if (Task::findTaskById($routeId) !== null && Task::findTaskById($routeId)->user_id == Auth::id()){
                return $next($request);
            }
        }
        return redirect()->route('login');
    }
    function isAuthenticated(Request $request): bool
    {
        return Auth::check();
    }
    function isUserOfType(Request $request, string $userType): bool
    {
        $user = Auth::user();
        if ($user && isset($user->type) && $user->type === $userType) {
            return true;
        }
        return false;
    }
}
