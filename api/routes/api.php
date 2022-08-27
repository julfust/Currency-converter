<?php

use App\Http\Controllers\ConversionRequestController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\PairController;
use App\Http\Controllers\RegisterController;
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

Route::controller(RegisterController::class)->group(function(){
    Route::post('register', 'register');
    Route::post('login', 'login');
});

Route::middleware('auth:sanctum')->group( function () {
    Route::apiResource("pairs", PairController::class);
    Route::apiResource("currencies", CurrencyController::class);
    Route::apiResource("conversion-request", ConversionRequestController::class);
});