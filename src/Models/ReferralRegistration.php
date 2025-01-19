<?php

namespace Azuriom\Plugin\Referral\Models;

use Illuminate\Database\Eloquent\Model;

class ReferralRegistration extends Model
{
    protected $table = 'referrals_registrations';

    protected $fillable = [
        'user_id',
        'expires_at',
        'created_at',
        'updated_at'
    ];
}
