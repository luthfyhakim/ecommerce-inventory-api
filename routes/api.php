<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::prefix('/v1')->group(function () {
    Route::apiResource('/categories', CategoryController::class);

    Route::prefix('/products')->group(function () {
        Route::apiResource('/', ProductController::class);
        Route::get('/search', [ProductController::class, 'search']);
        Route::post('/update-stock', [ProductController::class, 'updateStock']);
    });

    Route::get('/inventory/value', [ProductController::class, 'getTotalInventoryValue']);
});
