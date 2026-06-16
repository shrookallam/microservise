<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class ValidateAuthToken
{
   public function handle($request, Closure $next)
{
    $header = $request->header('Authorization');

    if (!$header) {
        return response()->json(['message' => 'No token'], 401);
    }

    $token = str_replace('Bearer ', '', $header);
    $token = trim($token);

    $response = Http::withToken($token)
        ->get('http://auth-service.test/api/validate');

    if (!$response->successful()) {
        return response()->json([
            'message' => 'Unauthorized',
            'debug' => $response->body()
        ], 401);
    }

    $request->merge([
        'auth_user' => $response->json('user')
    ]);

    return $next($request);
}
}
