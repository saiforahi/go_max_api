<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return response()->json(['success'=>true,'data'=>$request->user()],200);
});
Route::post('/login',[App\Http\Controllers\v1\AuthController::class,'login']);
Route::post('/register',[App\Http\Controllers\v1\AuthController::class,'register']);
Route::post('/change-password',[App\Http\Controllers\v1\AuthController::class,'change_password']);
Route::middleware('auth:sanctum')->get('/logout',[App\Http\Controllers\v1\AuthController::class,'logout']);
