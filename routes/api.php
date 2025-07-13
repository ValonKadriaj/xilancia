<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AuthenticateSanctumToken;
use App\Http\Middleware\CheckIsLoggedIn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::middleware([AuthenticateSanctumToken::class])->prefix('users')->group(function () {
    Route::post('/', [UserController::class, 'store']);
    Route::get('/', [UserController::class, 'index']);
    Route::get('/{id}', [UserController::class, 'show']);
    Route::put('/{id}', [UserController::class, 'update']);
    Route::delete('/{id}', [UserController::class, 'destroy']);
});

Route::post('auth/login', [AuthController::class, 'login']);
