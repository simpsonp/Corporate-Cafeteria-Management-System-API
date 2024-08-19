<?php

use App\Http\Controllers\Auth\NewTokenController;
use App\Http\Controllers\MealTypeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AuthenticateOnceWithBasicAuth;
use App\Http\Middleware\BasicOrTokenAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/users/tokens', [NewTokenController::class, 'store'])
    ->name('token.store');

Route::middleware(['auth:sanctum'])->group(function () {

    Route::get('/user', [UserController::class, 'showCurrent']);
    Route::get('/menus', [MenuController::class, 'index']);
    Route::get('/meals/types', [MealTypeController::class, 'index']);
});


if (!app()->isProduction()) {

    Route::prefix('test')->group(function () {

        Route::middleware(AuthenticateOnceWithBasicAuth::class)
            ->get('/auth/once-basic', function (Request $request) {
                return $request->user();
            });

        Route::middleware(BasicOrTokenAuth::class)
            ->get('/auth/basic-or-token', function (Request $request) {
                return $request->user();
            });
    });
}
