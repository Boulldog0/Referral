<?php

namespace Azuriom\Plugin\Referral\Cards;

use Azuriom\Extensions\Plugin\UserProfileCardComposer;
use Illuminate\Support\Facades\Auth;
use Azuriom\Models\User;
use Azuriom\Plugin\Referral\Models\Referrals;

class ReferralViewCard extends UserProfileCardComposer
{
    public function getCards(): array
    {
        $user = Auth::user();

        if(!$user) {
            return [];
        }

        $referrerName = null;
        $referral = Referrals::where('referred_id', $user->id)->first();

        if($referral !== null) {
            $referrer = User::find($referral->referrer_id);
            $referrerName = $referrer->name;
        }

            return [
                [
                    'name' => trans('referral::messages.profile.title'),
                    'view' => 'referral::cards.profile',
                    'data' => compact('referrerName'),
                ],
            ];
            
    }
}
