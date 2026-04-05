<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password',
        'role', 'google_id', 'avatar',
    ];

    protected $hidden   = ['password', 'remember_token'];
    protected $casts    = ['email_verified_at' => 'datetime', 'password' => 'hashed'];

    // ─── Relasi ──────────────────────────────────────────────────────
    public function products()
    {
        return $this->hasMany(Product::class, 'seller_id');
    }

    public function affiliateLink()
    {
        return $this->hasOne(AffiliateLink::class);
    }

    // ─── Role Checks ─────────────────────────────────────────────────
    public function isAdmin(): bool     { return $this->role === 'admin'; }
    public function isSeller(): bool    { return $this->role === 'seller'; }
    public function isAffiliate(): bool { return $this->role === 'affiliate'; }
    public function isBuyer(): bool     { return $this->role === 'buyer'; }

    public function hasRole(string|array $roles): bool
    {
        return in_array($this->role, (array) $roles);
    }

    public function isAdminOrSeller(): bool
    {
        return $this->hasRole(['admin', 'seller']);
    }

    // ─── Label & Warna role untuk UI ─────────────────────────────────
    public function roleLabel(): string
    {
        return match($this->role) {
            'admin'     => '⚡ Admin',
            'seller'    => '🏪 Seller',
            'affiliate' => '🔗 Affiliate',
            default     => '👤 Buyer',
        };
    }

    public function roleBadgeStyle(): string
    {
        return match($this->role) {
            'admin'     => 'background:rgba(99,102,241,0.15); color:#818cf8; border:1px solid rgba(99,102,241,0.3);',
            'seller'    => 'background:rgba(245,158,11,0.15); color:#fbbf24; border:1px solid rgba(245,158,11,0.3);',
            'affiliate' => 'background:rgba(34,197,94,0.15); color:#4ade80; border:1px solid rgba(34,197,94,0.3);',
            default     => 'background:rgba(148,148,176,0.15); color:#9494b0; border:1px solid rgba(148,148,176,0.3);',
        };
    }
}
