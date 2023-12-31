<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\TransactionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('product', ProductController::class)->only(['index','show']);
Route::middleware(['jwt:api'
        ])->group(function() {    
    Route::apiResource('transaction', TransactionController::class);
    Route::apiResource('product', ProductController::class);    
});
Route::post('register', RegisterController::class);
Route::post('login', [LoginController::class, 'login']);