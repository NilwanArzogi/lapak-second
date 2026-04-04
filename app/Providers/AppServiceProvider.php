<?php

namespace App\Providers;

use App\Models\Product;
use App\Policies\ProductPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Daftarkan Policy
        Gate::policy(Product::class, ProductPolicy::class);

        // Gate shortcut untuk cek role di Blade
        Gate::define('admin',  fn($user) => $user->isAdmin());
        Gate::define('seller', fn($user) => $user->isSeller());
        Gate::define('admin-or-seller', fn($user) => $user->isAdminOrSeller());
    }
}
