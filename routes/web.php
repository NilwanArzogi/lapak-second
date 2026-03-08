<?php

use Illuminate\Support\Facades\Route;
use App\Models\Product; // <--- TAMBAHKAN BARIS INI

Route::get('/', function () {
    // Mengambil semua data produk dari database
    $products = Product::all(); 
    
    // Mengirim variabel $products ke view welcome
    return view('welcome', compact('products'));
});
use App\Http\Controllers\ProductController;

Route::post('/checkout', [ProductController::class, 'checkout'])->name('checkout');
Route::get('/admin/dashboard', [ProductController::class, 'adminDashboard'])->name('admin.dashboard');