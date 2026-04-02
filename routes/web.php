<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\ProductController;

// ─── Tambahkan controller admin baru ─────────────────────────────────────────
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController   as AdminOrderController;
use App\Http\Controllers\Admin\UserController    as AdminUserController;

// ─── Auth (Guest only) ───────────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login',    [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',   [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register',[AuthController::class, 'register']);

    Route::get('/auth/google',          [GoogleAuthController::class, 'redirect'])->name('google.redirect');
    Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])->name('google.callback');
});

// ─── Logout ──────────────────────────────────────────────────────────────────
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// ─── Halaman Toko ────────────────────────────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('shop.index');
    Route::post('/checkout', [ProductController::class, 'checkout'])->name('checkout');
});

// ─── Admin Panel (harus login + role admin) ──────────────────────────────────
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [ProductController::class, 'adminDashboard'])->name('dashboard');

    // CRUD Produk
    Route::resource('products', AdminProductController::class)->except(['show']);

    // CRUD Pesanan (tidak ada create, hanya view/update/delete)
    Route::get('/orders',           [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}',   [AdminOrderController::class, 'show'])->name('orders.show');
    Route::put('/orders/{order}',   [AdminOrderController::class, 'update'])->name('orders.update');
    Route::delete('/orders/{order}',[AdminOrderController::class, 'destroy'])->name('orders.destroy');

    // CRUD User (tidak ada create, hanya view/update/delete)
    Route::get('/users',            [AdminUserController::class, 'index'])->name('users.index');
    Route::put('/users/{user}',     [AdminUserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}',  [AdminUserController::class, 'destroy'])->name('users.destroy');
});
