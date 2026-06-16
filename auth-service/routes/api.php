<?php

use Illuminate\Support\Facades\Route;
use  App\Http\Controllers\AuthController;

Route::post('/login', [AuthController::class,'login']);
Route::middleware('auth:api')->get('/validate', function () {
    return response()->json([
        'user' => auth()->user()
    ]);
});
