<?php

namespace Azuriom\Plugin\Referral\Models;

use Illuminate\Database\Eloquent\Model;

class ReferralPackagesLinks extends Model
{
    protected $table = 'referrals_packages_links';

    protected $fillable = [
        'shop_package_id',
        'applied_amount',
        'created_at',
        'updated_at'
    ];
}
