<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\AffiliateController;

/*
|--------------------------------------------------------------------------
| API Routes — Lapak Second
|--------------------------------------------------------------------------
|
| Semua response berformat JSON.
| Untuk route yang butuh login, gunakan session cookie (same-origin).
|
*/

// ─── Public (tidak perlu login) ───────────────────────────────────────────────
Route::prefix('v1')->group(function () {

    // Produk
    Route::get('/products',      [ProductController::class, 'index'])->name('api.products.index');
    Route::get('/products/{product}', [ProductController::class, 'show'])->name('api.products.show');

});

// ─── Private (harus login) ────────────────────────────────────────────────────
Route::prefix('v1')->middleware('auth')->group(function () {

    // Pesanan milik user yang login
    Route::get('/orders',         [OrderController::class, 'index'])->name('api.orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('api.orders.show');

    // Statistik afiliasi (khusus role affiliate/admin)
    Route::get('/affiliate/stats', [AffiliateController::class, 'stats'])->name('api.affiliate.stats');

});
