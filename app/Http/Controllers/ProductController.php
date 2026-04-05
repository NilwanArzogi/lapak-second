<?php

namespace App\Http\Controllers;

use App\Models\AffiliateCommission;
use App\Models\AffiliateLink;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::all();

        // Simpan ref_code ke session kalau ada di URL (?ref=KODE)
        if ($request->has('ref')) {
            $link = AffiliateLink::where('code', $request->ref)
                                 ->where('is_active', true)->first();
            if ($link) session(['affiliate_ref' => $request->ref]);
        }

        return view('shop.index', compact('products'));
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'nama'    => 'required',
            'phone'   => 'required',
            'alamat'  => 'required',
            'items'   => 'required|array',
            'total'   => 'required|numeric',
            'payment' => 'required',
        ]);

        $refCode = session('affiliate_ref');

        $order = Order::create([
            'nama_pembeli'      => $request->nama,
            'email'             => $request->email,
            'nomor_hp'          => $request->phone,
            'alamat'            => $request->alamat,
            'item_pesanan'      => $request->items,
            'total_harga'       => $request->total,
            'metode_pembayaran' => $request->payment,
            'status'            => 'sukses',
            'ref_code'          => $refCode,
        ]);

        // Hitung komisi (flat ATAU percent, sesuai setting afiliator)
        if ($refCode) {
            $link = AffiliateLink::where('code', $refCode)
                                 ->where('is_active', true)->first();
            if ($link) {
                AffiliateCommission::create([
                    'affiliate_link_id' => $link->id,
                    'order_id'          => $order->id,
                    'order_total'       => $request->total,
                    'commission_type'   => $link->commission_type,
                    'commission_value'  => $link->commission_value,
                    'commission_amount' => $link->calculateCommission((float) $request->total),
                    'status'            => 'pending',
                ]);
                session()->forget('affiliate_ref');
            }
        }

        return response()->json(['message' => 'Pesanan berhasil diproses!']);
    }

    public function adminDashboard()
    {
        $orders = Order::orderBy('created_at', 'desc')->get();
        return view('admin.dashboard', compact('orders'));
    }
}
