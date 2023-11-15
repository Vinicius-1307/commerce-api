<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\User\UserController;
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

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/users', [UserController::class, 'create']);

Route::middleware('authJwt')->group(function () {
    Route::prefix('users')->group(function () {
        Route::put('/{user_id}', [UserController::class, 'update']);
        Route::get('/{user_id}', [UserController::class, 'find']);
        Route::delete('/{user_id}', [UserController::class, 'delete']);
    });
});

Route::middleware('authJwt')->group(function () {
    Route::prefix('products')->group(function () {
        Route::post('/', [ProductController::class, 'create']);
        Route::put('/{product_id}', [ProductController::class, 'update']);
        Route::get('/', [ProductController::class, 'getAll']);
    });
});
