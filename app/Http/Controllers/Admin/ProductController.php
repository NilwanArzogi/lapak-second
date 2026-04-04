<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Product::class);

        // Admin lihat semua, Seller hanya miliknya
        $products = auth()->user()->isAdmin()
            ? Product::with('seller')->latest()->paginate(10)
            : Product::ownedBy(auth()->user())->latest()->paginate(10);

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $this->authorize('create', Product::class);
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Product::class);

        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'harga'       => 'required|numeric|min:0',
            'kondisi'     => 'required|in:baru,bekas',
            'deskripsi'   => 'nullable|string',
            'gambar'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->only(['nama_barang', 'harga', 'kondisi', 'deskripsi']);
        $data['seller_id'] = auth()->id(); // otomatis assign ke user yang login

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('products', 'public');
        }

        Product::create($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit(Product $product)
    {
        $this->authorize('update', $product);
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $this->authorize('update', $product);

        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'harga'       => 'required|numeric|min:0',
            'kondisi'     => 'required|in:baru,bekas',
            'deskripsi'   => 'nullable|string',
            'gambar'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->only(['nama_barang', 'harga', 'kondisi', 'deskripsi']);

        if ($request->hasFile('gambar')) {
            if ($product->gambar) Storage::disk('public')->delete($product->gambar);
            $data['gambar'] = $request->file('gambar')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy(Product $product)
    {
        $this->authorize('delete', $product);

        if ($product->gambar) Storage::disk('public')->delete($product->gambar);
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil dihapus!');
    }
}
