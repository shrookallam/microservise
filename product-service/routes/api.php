<?php

use Illuminate\Support\Facades\Route;
use  App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;

Route::post(
    '/products',
    [ProductController::class,'store']
)->middleware('auth.service');
