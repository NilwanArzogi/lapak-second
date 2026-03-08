<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Hapus data lama agar tidak double
        DB::table('products')->truncate();

        $products = [
            // LAPTOP (Kategori: tech,laptop)
            ['nama_barang' => 'Macbook Air M2 2022', 'kondisi' => 'bekas', 'harga' => 14500000, 'deskripsi' => 'Mulus 98%, CC rendah, fullset.', 'gambar' => 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=500'],
            ['nama_barang' => 'ASUS ROG Zephyrus G14', 'kondisi' => 'baru', 'harga' => 21000000, 'deskripsi' => 'Ryzen 9, RTX 3060, Garansi resmi.', 'gambar' => 'https://images.unsplash.com/photo-1593642632823-8f785ba67e45?w=500'],
            ['nama_barang' => 'Lenovo ThinkPad X1 Carbon', 'kondisi' => 'bekas', 'harga' => 8500000, 'deskripsi' => 'Eks kantor, mulus, baterai awet.', 'gambar' => 'https://images.unsplash.com/photo-1588872657578-7efd1f1555ed?w=500'],
            
            // SMARTPHONE (Kategori: iphone,smartphone)
            ['nama_barang' => 'iPhone 15 Pro Max', 'kondisi' => 'baru', 'harga' => 22500000, 'deskripsi' => 'Titanium, iBox original.', 'gambar' => 'https://images.unsplash.com/photo-1696446701796-da61225697cc?w=500'],
            ['nama_barang' => 'Samsung S23 Ultra', 'kondisi' => 'bekas', 'harga' => 15000000, 'deskripsi' => 'Lengkap, stylus normal, lecet pemakaian.', 'gambar' => 'https://images.unsplash.com/photo-1678911820864-e2c567c655d7?w=500'],
            ['nama_barang' => 'Xiaomi 13T', 'kondisi' => 'baru', 'harga' => 6200000, 'deskripsi' => 'Leica camera, garansi TAM.', 'gambar' => 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=500'],
           
            // KAMERA (Kategori: camera)
            ['nama_barang' => 'Sony A6400 Body Only', 'kondisi' => 'bekas', 'harga' => 9000000, 'deskripsi' => 'SC rendah, sensor bersih.', 'gambar' => 'https://images.unsplash.com/photo-1516035069371-29a1b244cc32?w=500'],
            ['nama_barang' => 'Fujifilm X-T30 II', 'kondisi' => 'baru', 'harga' => 14000000, 'deskripsi' => 'Garansi fujifilm indonesia.', 'gambar' => 'https://images.unsplash.com/photo-1510127034890-ba27508e9f1c?w=500'],
            ['nama_barang' => 'GoPro Hero 12', 'kondisi' => 'baru', 'harga' => 7000000, 'deskripsi' => 'Action cam terbaru, waterproof.', 'gambar' => 'https://images.unsplash.com/photo-1502920917128-1aa500764cbd?w=500'],

            // AKSESORIS (Kategori: mouse,headphone)
            ['nama_barang' => 'Logitech G Pro X Superlight', 'kondisi' => 'baru', 'harga' => 1800000, 'deskripsi' => 'Mouse gaming teringan.', 'gambar' => 'https://images.unsplash.com/photo-1615663245857-ac93bb7c39e7?w=500'],
            ['nama_barang' => 'Keychron K2 V2', 'kondisi' => 'bekas', 'harga' => 950000, 'deskripsi' => 'Mechanical keyboard, blue switch.', 'gambar' => 'https://images.unsplash.com/photo-1595225476474-87563907a212?w=500'],
            ['nama_barang' => 'AirPods Pro Gen 2', 'kondisi' => 'baru', 'harga' => 3400000, 'deskripsi' => 'Active Noise Cancellation.', 'gambar' => 'https://images.unsplash.com/photo-1588423770186-80f85631f673?w=500'],
        ];

        foreach ($products as $product) {
            DB::table('products')->insert(array_merge($product, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}