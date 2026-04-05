<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'nama_pembeli', 'email', 'nomor_hp', 'alamat',
        'item_pesanan', 'total_harga', 'metode_pembayaran',
        'status', 'ref_code',
    ];

    protected $casts = ['item_pesanan' => 'array'];

    public function commission()
    {
        return $this->hasOne(AffiliateCommission::class);
    }
}
