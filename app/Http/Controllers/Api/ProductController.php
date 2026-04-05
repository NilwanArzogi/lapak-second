<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * GET /api/products
     * Query params: ?search=iphone&kondisi=baru&sort=harga_asc&per_page=12
     */
    public function index(Request $request)
    {
        $query = Product::query();

        // Filter pencarian
        if ($request->filled('search')) {
            $query->where('nama_barang', 'like', '%' . $request->search . '%');
        }

        // Filter kondisi
        if ($request->filled('kondisi')) {
            $query->where('kondisi', $request->kondisi);
        }

        // Sorting
        match ($request->input('sort', 'terbaru')) {
            'harga_asc'  => $query->orderBy('harga', 'asc'),
            'harga_desc' => $query->orderBy('harga', 'desc'),
            default      => $query->latest(),
        };

        $products = $query->paginate($request->input('per_page', 12));

        return response()->json([
            'status' => 'success',
            'data'   => $products->map(fn($p) => $this->formatProduct($p)),
            'meta'   => [
                'current_page' => $products->currentPage(),
                'last_page'    => $products->lastPage(),
                'per_page'     => $products->perPage(),
                'total'        => $products->total(),
            ],
        ]);
    }

    /**
     * GET /api/products/{id}
     */
    public function show(Product $product)
    {
        return response()->json([
            'status' => 'success',
            'data'   => $this->formatProduct($product),
        ]);
    }

    private function formatProduct(Product $product): array
    {
        return [
            'id'          => $product->id,
            'nama_barang' => $product->nama_barang,
            'harga'       => $product->harga,
            'harga_label' => 'Rp ' . number_format($product->harga, 0, ',', '.'),
            'kondisi'     => $product->kondisi,
            'deskripsi'   => $product->deskripsi,
            'gambar'      => $product->gambar
                ? (str_starts_with($product->gambar, 'http')
                    ? $product->gambar
                    : asset('storage/' . $product->gambar))
                : null,
            'seller'      => $product->seller
                ? ['id' => $product->seller->id, 'name' => $product->seller->name]
                : null,
            'created_at'  => $product->created_at->format('d M Y'),
        ];
    }
}
