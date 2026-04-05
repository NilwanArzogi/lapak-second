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
        Gate::policy(Product::class, ProductPolicy::class);

        // Gate shortcut untuk Blade
        Gate::define('admin',           fn($u) => $u->isAdmin());
        Gate::define('seller',          fn($u) => $u->isSeller());
        Gate::define('affiliate',       fn($u) => $u->isAffiliate());
        Gate::define('admin-or-seller', fn($u) => $u->isAdminOrSeller());
    }
}
