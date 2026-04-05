<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AffiliateCommission extends Model
{
    protected $fillable = [
        'affiliate_link_id', 'order_id',
        'order_total', 'commission_rate',
        'commission_amount', 'status',
    ];

    public function affiliateLink()
    {
        return $this->belongsTo(AffiliateLink::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
