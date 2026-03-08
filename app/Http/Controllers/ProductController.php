<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Halaman Utama Toko
    public function index() {
        $products = \App\Models\Product::all();
        return view('welcome', compact('products'));
    }

    // Fungsi Checkout (Status Otomatis Sukses)
    public function checkout(Request $request) {
        $request->validate([
            'nama' => 'required',
            'phone' => 'required',
            'items' => 'required|array',
            'total' => 'required',
            'payment' => 'required'
        ]);

        Order::create([
            'nama_pembeli' => $request->nama,
            'email' => $request->email,
            'nomor_hp' => $request->phone,
            'item_pesanan' => $request->items,
            'total_harga' => $request->total,
            'metode_pembayaran' => $request->payment,
            'status' => 'sukses' // Status otomatis diset sukses
        ]);

        return response()->json(['message' => 'Pesanan berhasil diproses!']);
    }

    // Halaman Dashboard Admin
    public function adminDashboard() {
        $orders = Order::orderBy('created_at', 'desc')->get();
        return view('admin.dashboard', compact('orders'));
    }
}