<?php

use App\Http\Controllers\Api\OrderApiController;
use App\Http\Controllers\Api\ProductApiController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    // Products
    Route::get('/products', [ProductApiController::class, 'index']);
    Route::get('/products/{product}', [ProductApiController::class, 'show']);

    // Orders (public - no auth needed for placing)
    Route::post('/orders', [OrderApiController::class, 'store']);
});
