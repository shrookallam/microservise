<?php

use Illuminate\Support\Facades\Route;
use  App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
Route::post('/orders', [OrderController::class,'store'])
    ->middleware('auth.service');
Route::post('/events', [EventController::class, 'handle']);
