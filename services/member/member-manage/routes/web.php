<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json(['message' => '歡迎來到laravel']);
})->middleware('web');

Route::middlewareGroup('web', [
    // \Illuminate\Cookie\Middleware\EncryptCookies::class,
    \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
    \Illuminate\Session\Middleware\StartSession::class,
    \Illuminate\View\Middleware\ShareErrorsFromSession::class,
    // \Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class,
    // \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
    // \App\Http\Middleware\TrimStrings::class,
    \Illuminate\Routing\Middleware\SubstituteBindings::class,
    // \Illuminate\Session\Middleware\AuthenticateSession::class,
]);