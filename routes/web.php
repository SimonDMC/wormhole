<?php

use App\Http\Controllers\RoomController;
use App\Http\Middleware\RoomMiddleware;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'guest'], function () {
    Route::view('/', 'pages.landing')
        ->name('landing');
    Route::view('/no-support', 'pages.no-support')
        ->name('no-support');

    Route::get('/create', [RoomController::class, 'create'])
        ->name('room.create');
    Route::get('/check/{code}', [RoomController::class, 'check'])
        ->name('room.check');
    Route::view('/join/{code}', 'pages.join')
        ->name('room.join')
        ->middleware(RoomMiddleware::class);
    Route::post('/register', [RoomController::class, 'register'])
        ->name('room.register');
});