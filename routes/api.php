<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\orderController;
use App\Http\Controllers\API\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

// prodcut
Route::apiResource('products', ProductController::class);

// order
Route::apiResource('orders', orderController::class);