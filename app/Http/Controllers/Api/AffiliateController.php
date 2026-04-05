<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AffiliateLink;
use Illuminate\Http\Request;

class AffiliateController extends Controller
{
    /**
     * GET /api/affiliate/stats
     * Statistik komisi afiliator yang sedang login
     */
    public function stats()
    {
        $user = auth()->user();

        if (!$user->isAffiliate() && !$user->isAdmin()) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Akses ditolak. Hanya untuk afiliator.',
            ], 403);
        }

        $link = $user->affiliateLink;

        if (!$link) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Link referral belum dibuat.',
            ], 404);
        }

        $commissions = $link->commissions()->latest()->get();

        return response()->json([
            'status' => 'success',
            'data'   => [
                'link'   => [
                    'kode'             => $link->code,
                    'url'              => $link->url,
                    'commission_type'  => $link->commission_type,
                    'commission_value' => $link->commission_value,
                    'commission_label' => $link->commissionLabel(),
                    'is_active'        => $link->is_active,
                ],
                'stats'  => [
                    'total_order'     => $commissions->count(),
                    'komisi_pending'  => $commissions->where('status', 'pending')->sum('commission_amount'),
                    'komisi_approved' => $commissions->where('status', 'approved')->sum('commission_amount'),
                    'komisi_paid'     => $commissions->where('status', 'paid')->sum('commission_amount'),
                    'total_earned'    => $commissions->whereIn('status', ['approved', 'paid'])->sum('commission_amount'),
                ],
                'riwayat' => $commissions->map(fn($c) => [
                    'id'               => $c->id,
                    'order_total'      => $c->order_total,
                    'commission_type'  => $c->commission_type,
                    'commission_value' => $c->commission_value,
                    'commission_amount'=> $c->commission_amount,
                    'komisi_label'     => 'Rp ' . number_format($c->commission_amount, 0, ',', '.'),
                    'status'           => $c->status,
                    'tanggal'          => $c->created_at->format('d M Y, H:i'),
                ])->values(),
            ],
        ]);
    }
}
