<?php

use App\Http\Controllers\Auth\AuthController;
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

Route::middleware('authJwt')->group(function () {
    Route::prefix('users')->group(function () {
        Route::post('/', [UserController::class, 'create']);
        Route::put('/{user_id}', [UserController::class, 'update']);
        Route::get('/{user_id}', [UserController::class, 'find']);
    });
});
