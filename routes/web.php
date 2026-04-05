<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Admin\ProductController  as AdminProductController;
use App\Http\Controllers\Admin\OrderController    as AdminOrderController;
use App\Http\Controllers\Admin\UserController     as AdminUserController;
use App\Http\Controllers\Admin\AffiliateController;
use App\Http\Controllers\Affiliate\DashboardController as AffiliateDashboard;

// ─── Guest ───────────────────────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login',    [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',   [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register',[AuthController::class, 'register']);
    Route::get('/auth/google',          [GoogleAuthController::class, 'redirect'])->name('google.redirect');
    Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])->name('google.callback');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// ─── Toko — semua yang login (buyer, seller, affiliate, admin) ────────────────
Route::middleware('auth')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('shop.index');
    Route::post('/checkout', [ProductController::class, 'checkout'])->name('checkout');
});

// ─── Affiliate Panel ─────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:affiliate,admin'])
    ->prefix('affiliate')
    ->name('affiliate.')
    ->group(function () {
        Route::get('/dashboard', [AffiliateDashboard::class, 'index'])->name('dashboard');
    });

// ─── Seller Panel (admin + seller) ───────────────────────────────────────────
Route::middleware(['auth', 'role:seller,admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::resource('products', AdminProductController::class)->except(['show']);
    });

// ─── Admin Panel (admin saja) ─────────────────────────────────────────────────
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [ProductController::class, 'adminDashboard'])->name('dashboard');

        // Pesanan
        Route::get('/orders',            [AdminOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}',    [AdminOrderController::class, 'show'])->name('orders.show');
        Route::put('/orders/{order}',    [AdminOrderController::class, 'update'])->name('orders.update');
        Route::delete('/orders/{order}', [AdminOrderController::class, 'destroy'])->name('orders.destroy');

        // Pengguna
        Route::get('/users',           [AdminUserController::class, 'index'])->name('users.index');
        Route::put('/users/{user}',    [AdminUserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');

        // Afiliator
        Route::get('/affiliates',                                    [AffiliateController::class, 'index'])->name('affiliates.index');
        Route::put('/affiliates/{affiliateLink}',                    [AffiliateController::class, 'update'])->name('affiliates.update');
        Route::get('/affiliates/{affiliateLink}/commissions',        [AffiliateController::class, 'commissions'])->name('affiliates.commissions');
        Route::patch('/affiliates/commissions/{commission}/approve', [AffiliateController::class, 'approveCommission'])->name('affiliates.approve');
        Route::patch('/affiliates/commissions/{commission}/pay',     [AffiliateController::class, 'payCommission'])->name('affiliates.pay');
    });
