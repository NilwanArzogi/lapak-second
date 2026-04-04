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

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
    ];

    // ─── Relasi ──────────────────────────────────────────────────────
    public function products()
    {
        return $this->hasMany(Product::class, 'seller_id');
    }

    // ─── Role Checks ─────────────────────────────────────────────────
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isSeller(): bool
    {
        return $this->role === 'seller';
    }

    public function isUser(): bool
    {
        return $this->role === 'user';
    }

    public function isAdminOrSeller(): bool
    {
        return in_array($this->role, ['admin', 'seller']);
    }

    public function hasRole(string|array $roles): bool
    {
        return in_array($this->role, (array) $roles);
    }

    // ─── Google OAuth ─────────────────────────────────────────────────
    public function isGoogleUser(): bool
    {
        return !is_null($this->google_id);
    }
}
