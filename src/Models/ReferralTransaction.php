<?php

namespace Azuriom\Plugin\Referral\Models;

use Illuminate\Database\Eloquent\Model;

class ReferralTransaction extends Model
{
    protected $table = 'referrals_transactions';

    protected $fillable = [
        'user_id',
        'command_id',
        'total_amount',
        'referrer_id',
        'percentage_given',
        'given_amount',
        'created_at',
        'updated_at',
    ];
}
