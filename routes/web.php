<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('server')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])
        ->middleware('guest');

    Route::post('/logout', [AuthController::class, 'logout'])
        ->middleware('auth');

    Route::get('/user', [AuthController::class, 'user'])
        ->middleware('auth');
});

Route::get('/{any}', function () {
    return view('app');
})->where('any', '^(?!server).*$');
