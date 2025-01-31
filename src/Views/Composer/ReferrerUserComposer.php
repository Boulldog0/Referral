<?php

namespace Azuriom\Plugin\Referral\Views\Composer;

use Azuriom\Extensions\Plugin\AdminUserEditComposer;
use Azuriom\Models\User;
use Illuminate\View\View;
use Azuriom\Plugin\Referral\Models\Referrals;
use Azuriom\Plugin\Referral\Models\ReferralTransaction;

class ReferrerUserComposer extends AdminUserEditComposer
{
    public function getCards(User $user, View $view)
    {
        $referral = Referrals::where('referred_id', $user->id);
        if($referral !== null) {
            $rId = $referral->referrer_id;
            $referrer = User::find($rId)->name;
            $view->with('referrer', $referrer);
        } else {
            $view->with('referrer', null);
        }

        $referreds = Referrals::where('referrer_id', $user->id)->get();
        $view->with('referreds', $referreds);

        $rewards = ReferralTransaction::where('referrer_id', $user->id)->get();
        $view->with('rewards', $rewards);

        $buyings = ReferralTransaction::where('user_id', $user->id)->get();
        $view->with('buyings', $buyings);

        $view->with('user', $user);

        return [
            'referral' => [
                'name' => trans('referral::messages.admin.referrals'),
                'view' => 'referral::admin.users.referrals',
            ],
        ];
    }
}
