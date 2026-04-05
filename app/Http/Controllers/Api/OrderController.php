<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * GET /api/orders
     * Riwayat pesanan milik user yang sedang login
     * Query params: ?status=sukses&per_page=10
     */
    public function index(Request $request)
    {
        $query = Order::where('email', auth()->user()->email)
                      ->latest();

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->paginate($request->input('per_page', 10));

        return response()->json([
            'status' => 'success',
            'data'   => $orders->map(fn($o) => $this->formatOrder($o)),
            'meta'   => [
                'current_page' => $orders->currentPage(),
                'last_page'    => $orders->lastPage(),
                'total'        => $orders->total(),
            ],
        ]);
    }

    /**
     * GET /api/orders/{id}
     * Detail pesanan — hanya bisa lihat milik sendiri
     */
    public function show(Order $order)
    {
        // Pastikan order milik user yang login
        if ($order->email !== auth()->user()->email) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Pesanan tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data'   => $this->formatOrder($order, true),
        ]);
    }

    private function formatOrder(Order $order, bool $withItems = false): array
    {
        $data = [
            'id'                => $order->id,
            'nama_pembeli'      => $order->nama_pembeli,
            'nomor_hp'          => $order->nomor_hp,
            'alamat'            => $order->alamat,
            'total_harga'       => $order->total_harga,
            'total_label'       => 'Rp ' . number_format($order->total_harga, 0, ',', '.'),
            'metode_pembayaran' => $order->metode_pembayaran,
            'status'            => $order->status,
            'ref_code'          => $order->ref_code,
            'tanggal'           => $order->created_at->format('d M Y, H:i'),
        ];

        if ($withItems) {
            $data['items'] = collect($order->item_pesanan)->map(fn($item) => [
                'name'        => $item['name'] ?? $item['nama'] ?? '-',
                'harga'       => $item['harga'] ?? 0,
                'harga_label' => 'Rp ' . number_format($item['harga'] ?? 0, 0, ',', '.'),
            ])->toArray();
        }

        return $data;
    }
}
