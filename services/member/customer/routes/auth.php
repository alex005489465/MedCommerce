<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\LoginLogoutController;

Route::post('/register', [RegisteredUserController::class, 'register'])
    ->middleware('guest')
    ->name('register');
Route::post('/login', [LoginLogoutController::class, 'login'])
    ->middleware('guest')
    ->name('login');
Route::post('/logout', [LoginLogoutController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');
