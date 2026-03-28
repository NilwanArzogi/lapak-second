<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\ProductController;

// ─── Auth Routes (Guest only) ────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login',    [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',   [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register',[AuthController::class, 'register']);

    // Google OAuth
    Route::get('/auth/google',          [GoogleAuthController::class, 'redirect'])->name('google.redirect');
    Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])->name('google.callback');
});

// ─── Logout ──────────────────────────────────────────────────────────────────
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// ─── Halaman Toko (harus login) ──────────────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('shop.index');
    Route::post('/checkout', [ProductController::class, 'checkout'])->name('checkout');
});

// ─── Halaman Admin (harus login + role admin) ────────────────────────────────
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [ProductController::class, 'adminDashboard'])->name('admin.dashboard');
});
