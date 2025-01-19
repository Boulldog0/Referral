<?php

namespace Azuriom\Plugin\Referral\Models;

use Illuminate\Database\Eloquent\Model;

class Referrals extends Model
{
    protected $table = 'referrals';

    protected $fillable = [
        'referred_id',
        'referrer_id',
        'referrer_total_earn',
        'created_via_link',
    ];
}
