<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Middleware\JwtMiddleware;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    // Route Auth (user/admin)
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout'])->middleware(JwtMiddleware::class);
    Route::get('me', [AuthController::class, 'me'])->middleware(JwtMiddleware::class);

    Route::middleware(JwtMiddleware::class)->group(function () {
        // Route Category
        Route::apiResource('categories', CategoryController::class);

        // Route Product
        Route::prefix('products')->group(function () {
            Route::get('search', [ProductController::class, 'search']);
            Route::post('update-stock', [ProductController::class, 'updateStock']);
        });
        Route::apiResource('products', ProductController::class);

        Route::get('inventory/value', [ProductController::class, 'getTotalInventoryValue']);
    });
});
