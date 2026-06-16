<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
   public function login(Request $request)
{
    $credentials = $request->only('email', 'password');

    if (!$token = auth()->attempt($credentials)) {
        return response()->json([
            'message' => 'Unauthorized'
        ], 401);
    }

    return response()->json([
        'token' => $token
    ]);
}
}
