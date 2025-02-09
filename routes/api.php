<?php

use App\Http\Controllers\Auth\AuthApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/auth', [AuthApiController::class, 'auth']);
Route::apiResource('/products', ProductController::class);
Route::apiResource('/users', UserController::class);
