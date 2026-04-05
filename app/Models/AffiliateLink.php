<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class AffiliateLink extends Model
{
    protected $fillable = [
        'user_id', 'code',
        'commission_type',  // 'percent' atau 'flat'
        'commission_value', // persen atau nominal rupiah
        'is_active',
    ];

    protected $casts = ['is_active' => 'boolean'];

    public function user()        { return $this->belongsTo(User::class); }
    public function commissions() { return $this->hasMany(AffiliateCommission::class); }

    // Hitung komisi berdasarkan tipe
    public function calculateCommission(float $orderTotal): float
    {
        return $this->commission_type === 'flat'
            ? $this->commission_value
            : round($orderTotal * ($this->commission_value / 100), 2);
    }

    // Label tampilan (misal "5%" atau "Rp 10.000")
    public function commissionLabel(): string
    {
        return $this->commission_type === 'flat'
            ? 'Rp ' . number_format($this->commission_value, 0, ',', '.')
            : $this->commission_value . '%';
    }

    public function getUrlAttribute(): string
    {
        return url('/?ref=' . $this->code);
    }

    public function totalEarned(): float
    {
        return $this->commissions()->whereIn('status', ['approved', 'paid'])->sum('commission_amount');
    }

    public function pendingAmount(): float
    {
        return $this->commissions()->where('status', 'pending')->sum('commission_amount');
    }

    public static function generateCode(string $name): string
    {
        $base = strtoupper(substr(preg_replace('/[^a-zA-Z0-9]/', '', $name), 0, 5));
        do { $code = $base . strtoupper(Str::random(4)); }
        while (static::where('code', $code)->exists());
        return $code;
    }
}
