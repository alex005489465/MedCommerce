<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserInformationController;
use App\Http\Middleware\CustomAuthenticate;

Route::get('/', function () {
    return response()->json([
        'message' => 'Welcome to our application!',
    ], 200);
});

require __DIR__.'/auth.php';


Route::get('/user-information', [UserInformationController::class, 'show'])
    ->middleware('auth')
    ->name('user-information.show');
Route::post('/user-information', [UserInformationController::class, 'update'])
    ->middleware('auth')
    ->name('user-information.update');

