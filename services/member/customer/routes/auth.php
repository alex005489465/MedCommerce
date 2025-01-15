<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\LoginLogoutController;

Route::post('/register', [RegisteredUserController::class, 'register'])->name('register');
Route::post('/login', [LoginLogoutController::class, 'login'])->name('login');
Route::post('/logout', [LoginLogoutController::class, 'logout'])->name('logout');
