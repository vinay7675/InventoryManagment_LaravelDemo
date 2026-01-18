<?php

use App\Models\Product;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
    Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/next-code', function () {
    $last = Product::orderBy('id', 'desc')->first();
    $next = $last ? $last->id + 1 : 1;

    return response()->json([
        'code' => 'PM-PCE-' . str_pad($next, 4, '0', STR_PAD_LEFT)
    ]);
    });
    Route::post('/products', [ProductController::class, 'store']);
    Route::put('/products/{product}', [ProductController::class, 'update']);
    Route::delete('/products/{product}', [ProductController::class, 'destroy']);
});
