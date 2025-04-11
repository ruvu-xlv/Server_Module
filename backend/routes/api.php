<?php

use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\GameController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// Auth...
Route::post('v1/auth/signup',[AuthController::class,'register']);
Route::post('v1/auth/signin',[AuthController::class,'login']);
Route::middleware('auth:sanctum')->post('v1/auth/logout', [AuthController::class, 'logout']);


Route::get('v1/admin',[AdminController::class,'index'])->middleware('auth:sanctum');


// games
Route::get('v1/games',[GameController::class,'index'])->middleware('auth:sanctum');
Route::post('v1/games',[GameController::class,'store'])->middleware('auth:sanctum');
Route::post('v1/games/{id}',[GameController::class,'update'])->middleware('auth:sanctum');
Route::get('v1/games/{id}',[GameController::class,'show'])->middleware('auth:sanctum');
Route::delete('v1/games/{id}',[GameController::class,'destroy'])->middleware('auth:sanctum');