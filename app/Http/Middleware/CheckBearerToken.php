<?php

namespace App\Http\Middleware;

use App\Models\PersonalAccessToken;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckBearerToken
{
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();
        $personalToken = PersonalAccessToken::findByUserId($request['id']);
        if ($personalToken !== null) {
            if ($token !== $personalToken['token']) {
                return response()->json(['message' => 'token dose not support'], 401);
            } else {
                return $next($request);
            }
        }  else{
            return response()->json(['message' => 'token dose not found please login'], 401);
        }
    }
}
