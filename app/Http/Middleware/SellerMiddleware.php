<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerMiddleware
{
    public function handle(Request $request, Closure $next): mixed
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Admin juga boleh akses halaman seller
        if (!Auth::user()->isAdminOrSeller()) {
            abort(403, 'Halaman ini khusus Seller dan Admin.');
        }

        return $next($request);
    }
}
