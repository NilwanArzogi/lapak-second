<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use App\Models\AffiliateLink;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $link = $user->affiliateLink;

        // Buat link otomatis kalau belum punya
        if (!$link) {
            $link = AffiliateLink::create([
                'user_id'         => $user->id,
                'code'            => AffiliateLink::generateCode($user->name),
                'commission_rate' => 5.00,
                'is_active'       => true,
            ]);
        }

        $commissions = $link->commissions()
                            ->with('order')
                            ->latest()
                            ->paginate(10);

        $stats = [
            'total_klik'       => 0, // bisa tambah tracking klik nanti
            'total_order'      => $link->commissions()->count(),
            'komisi_pending'   => $link->pendingCommission(),
            'komisi_approved'  => $link->commissions()->where('status', 'approved')->sum('commission_amount'),
            'komisi_paid'      => $link->commissions()->where('status', 'paid')->sum('commission_amount'),
        ];

        return view('affiliate.dashboard.index', compact('link', 'commissions', 'stats'));
    }
}
