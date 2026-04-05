<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AffiliateCommission;
use App\Models\AffiliateLink;
use Illuminate\Http\Request;

class AffiliateController extends Controller
{
    public function index()
    {
        $links = AffiliateLink::with('user')
                              ->withCount('commissions')
                              ->withSum('commissions', 'commission_amount')
                              ->latest()->paginate(10);
        return view('admin.affiliates.index', compact('links'));
    }

    public function update(Request $request, AffiliateLink $affiliateLink)
    {
        $request->validate([
            'commission_type'  => 'required|in:percent,flat',
            'commission_value' => 'required|numeric|min:0',
            'is_active'        => 'nullable',
        ]);
        $affiliateLink->update([
            'commission_type'  => $request->commission_type,
            'commission_value' => $request->commission_value,
            'is_active'        => (bool) $request->input('is_active', 0),
        ]);
        return redirect()->route('admin.affiliates.index')
            ->with('success', 'Komisi afiliator diperbarui!');
    }

    public function commissions(AffiliateLink $affiliateLink)
    {
        $link = $affiliateLink->load('user', 'commissions.order');
        return view('admin.affiliates.commissions', compact('link'));
    }

    public function approveCommission(AffiliateCommission $commission)
    {
        $commission->update(['status' => 'approved']);
        return back()->with('success', 'Komisi di-approve!');
    }

    public function payCommission(AffiliateCommission $commission)
    {
        $commission->update(['status' => 'paid']);
        return back()->with('success', 'Komisi ditandai dibayar!');
    }
}
