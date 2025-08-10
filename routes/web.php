<?php

use App\Http\Controllers\DeviceController;
use App\Http\Controllers\FileDownloadController;
use App\Http\Controllers\RoomController;
use App\Http\Middleware\RegisteredMiddleware;
use App\Http\Middleware\RoomMiddleware;
use App\Http\Middleware\UnregisteredMiddleware;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Route;

Broadcast::routes(['middleware' => ['web']]);

Route::group(['middleware' => UnregisteredMiddleware::class], function () {
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
});

Route::group(['middleware' => RegisteredMiddleware::class], function () {
    Route::view('/dashboard', 'pages.dashboard')
        ->name('dashboard');
});

Route::get('/download/{uid}/{filename}', [FileDownloadController::class, 'download'])
    ->name('file.download');