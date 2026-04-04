<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'seller_id',
        'nama_barang',
        'harga',
        'kondisi',
        'deskripsi',
        'gambar',
    ];

    // ─── Relasi ──────────────────────────────────────────────────────
    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    // ─── Scope: hanya produk milik seller tertentu ───────────────────
    public function scopeOwnedBy($query, User $user)
    {
        return $query->where('seller_id', $user->id);
    }
}
