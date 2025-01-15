<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'message' => 'Welcome to our application!',
    ], 200);
});

require __DIR__.'/auth.php';