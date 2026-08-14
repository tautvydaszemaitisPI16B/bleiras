<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\NewController;
use Illuminate\Support\Facades\Route;

Route::prefix('server')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])
        ->middleware('guest');

    Route::get('/news', [NewController::class, 'index']);

    Route::middleware('auth')->group(function () {
        Route::get('/news/create', [NewController::class, 'create']);
        Route::post('/news', [NewController::class, 'store']);

        Route::get('/news/{news}/edit', [NewController::class, 'edit']);
        Route::put('/news/{news}', [NewController::class, 'update']);
        Route::delete('/news/{news}', [NewController::class, 'destroy']);

        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/user', [AuthController::class, 'user']);
    });

    Route::get('/news/{news}', [NewController::class, 'show']);
});

Route::get('/{any}', function () {
    return view('app');
})->where('any', '^(?!server).*$');
