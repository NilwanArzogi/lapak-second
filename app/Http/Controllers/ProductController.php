<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('shop.index', compact('products'));
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'nama'    => 'required',
            'phone'   => 'required',
            'alamat'  => 'required',   // ← wajib diisi
            'items'   => 'required|array',
            'total'   => 'required',
            'payment' => 'required',
        ]);

        Order::create([
            'nama_pembeli'      => $request->nama,
            'email'             => $request->email,
            'nomor_hp'          => $request->phone,
            'alamat'            => $request->alamat,  // ← simpan alamat
            'item_pesanan'      => $request->items,
            'total_harga'       => $request->total,
            'metode_pembayaran' => $request->payment,
            'status'            => 'sukses',
        ]);

        return response()->json(['message' => 'Pesanan berhasil diproses!']);
    }

    public function adminDashboard()
    {
        $orders = Order::orderBy('created_at', 'desc')->get();
        return view('admin.dashboard', compact('orders'));
    }
}
