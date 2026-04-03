<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'nama_pembeli',
        'email',
        'nomor_hp',
        'alamat',           // ← tambahan
        'item_pesanan',
        'total_harga',
        'metode_pembayaran',
        'status',
    ];

    protected $casts = [
        'item_pesanan' => 'array',
    ];
}
