<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Helpers\RoutePath;

Route::get('/', function () {
    return response()->json(['message' => 'welcome to Med shop'], 200);
});

/*
Route::get('/reset-password/{token}', function(){   
})
->middleware(['guest:' . config('fortify.guard')])
->name('password.reset');
*/