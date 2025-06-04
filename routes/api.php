<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    // Route Auth (user/admin)
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout'])->middleware('jwt.auth');
    Route::get('me', [AuthController::class, 'me'])->middleware('jwt.auth');

    Route::middleware('jwt.auth')->group(function () {
        // Route Category
        Route::apiResource('categories', CategoryController::class);

        // Route Product
        Route::prefix('products')->group(function () {
            Route::apiResource('/', ProductController::class);
            Route::get('search', [ProductController::class, 'search']);
            Route::post('update-stock', [ProductController::class, 'updateStock']);
        });

        Route::get('inventory/value', [ProductController::class, 'getTotalInventoryValue']);
    });
});
