<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return [
        'message' => 'Welcome to the ' . config('app.name'),
        'status' => 'API is up and running.'
    ];
});

if (!app()->isProduction()) {

    Route::prefix('test')->group(function () {

        Route::middleware('auth')->get('/auth/session', function (Request $request) {
            return $request->user();
        });

        Route::middleware('auth.basic')->get('/auth/basic', function (Request $request) {
            return $request->user();
        });
    });
}

require __DIR__ . '/auth.php';
