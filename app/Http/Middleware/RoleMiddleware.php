<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Penggunaan: ->middleware('role:admin')
     *             ->middleware('role:admin,seller')
     */
    public function handle(Request $request, Closure $next, string ...$roles): mixed
    {
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        if (!Auth::user()->hasRole($roles)) {
            // Jika AJAX/API, kembalikan JSON
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Akses ditolak.'], 403);
            }

            abort(403, 'Akses ditolak. Kamu tidak memiliki izin untuk halaman ini.');
        }

        return $next($request);
    }
}
