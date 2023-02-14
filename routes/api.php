<?php

use App\Http\Controllers\v1\admin\MerchantController;
use App\Http\Controllers\v1\admin\PaymentServiceController;
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

Route::middleware(['auth:sanctum'])->prefix('merchant')->group(function () {
    Route::post('create', [MerchantController::class, 'create']);
    Route::post('edit/{merchant_id}', [MerchantController::class, 'edit']);
    Route::get('all', [MerchantController::class, 'all']);
    Route::delete('delete/{id}', [MerchantController::class, 'delete']);
});

Route::middleware(['auth:sanctum'])->prefix('payment-service')->group(function () {
    Route::post('merchant/bkash/create', [PaymentServiceController::class, 'createBkashMerchant']);
    Route::post('merchant/shurjo/create', [PaymentServiceController::class, 'createShurjoPayMerchant']);
    Route::get('merchant/all', [PaymentServiceController::class, 'getAllMerchant']);
    Route::get('all', [PaymentServiceController::class, 'getPaymentServices']);
    Route::delete('merchant/delete/{type}/{id}', [PaymentServiceController::class, 'deleteMerchant']);
});
