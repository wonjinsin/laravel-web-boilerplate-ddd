<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;

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

Route::prefix('user')->group(function () {
    Route::post('', [UserController::class, 'createUser']);
    Route::get('', [UserController::class, 'getUserList']);
    Route::get('/login', [UserController::class, 'login']);
    Route::get('/{userID}', [UserController::class, 'getUser']);
    Route::put('/{userID}', [UserController::class, 'updateUser']);
    Route::delete('/{userID}', [UserController::class, 'deleteUser']);
});

Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
});
