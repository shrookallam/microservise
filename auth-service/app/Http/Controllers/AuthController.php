<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use PHPOpenSourceSaver\JWTAuth\JWT;
use Firebase\JWT\JWT;


class AuthController extends Controller
{
public function login(Request $request)
{
    $credentials = $request->only('email', 'password');

    if (!$user = auth()->attempt($credentials)) {
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    $user = auth()->user();

 $payload = [
    "iss" => "app-user",   // MUST match Kong consumer key
    "sub" => $user->id,
    "email" => $user->email,
    "iat" => time(),
    "exp" => time() + 3600,
];

$token = JWT::encode($payload, env('JWT_SECRET'), 'HS256');

    return response()->json([
        "token" => $token,
        "token_type" => "Bearer"
    ]);
}
}
