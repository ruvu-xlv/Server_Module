<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// Auth...
Route::post('v1/auth/signup',[AuthController::class,'register']);
Route::post('v1/auth/signin',[AuthController::class,'login']);