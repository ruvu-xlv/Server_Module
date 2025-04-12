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


Route::get('v1/user',[AdminController::class,'index']);


// games
Route::get('v1/games',[GameController::class,'index']);
Route::post('v1/games',[GameController::class,'store']);
Route::post('v1/games/{id}',[GameController::class,'update']);
Route::get('v1/games/{id}',[GameController::class,'show']);
Route::delete('v1/games/{id}',[GameController::class,'destroy']);