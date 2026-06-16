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
        $response = Http::withToken(
            str_replace(
                'Bearer ',
                '',
                $request->header('Authorization')
            )
        )->get(
            'http://auth-service.test/api/validate'
        );

        if (!$response->successful()) {
            return response()->json([
                'message' => 'Unauthorized'
            ],401);
        }

        return $next($request);
    }
}
