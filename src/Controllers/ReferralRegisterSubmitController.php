<?php

namespace Azuriom\Plugin\Referral\Controllers;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Azuriom\Plugin\Referral\Models\Referrals;
use Azuriom\Plugin\Referral\Models\ReferralRegistration;
use Azuriom\Notifications\AlertNotification;

class ReferralRegisterSubmitController extends Controller
{
    public function submit(Request $request)
    {
        $nickname = $request->input('inputField');
    
        $validator = Validator::make($request->all(), [
            'inputField' => 'required|string|exists:users,name', 
        ]);
    
        if($validator->fails()) {
            return redirect()->route('referral.register')
                >with('error', trans('referral::messages.register.validator_failure'));
        }
    
        $user = Auth::user();
        if(!$user || $user === null) {
            return redirect()->route('referral.register')
                ->with('error', trans('referral::messages.register.must_be_login'));
        }
    
        if($user->name === $nickname) {
            return redirect()->route('referral.register')
                ->with('error', trans('referral::messages.register.cant_register_yourself')); 
        }

        $referrer = User::where('name', $nickname)->first();
        if(!$referrer || $referrer == null) {
            return redirect()->route('referral.register')
                ->with('error', trans('referral::messages.register.given_user_not_found'));
        }

        $register_only_after_account_creation = setting('referral.ereff', true);

        if($register_only_after_account_creation)  {
            $expire_timestamp = ReferralRegistration::where('user_id', $user->id);
            $actual_timestamp = now();

            if(!ReferralRegistration::where('user_id', $user->id)->exists() || $expire_timestamp == null || $expire_timestamp < $actual_timestamp) {
                if($expire_timestamp < $actual_timestamp) {
                    ReferralRegistration::where('user_id', $user->id)->delete();
                }
                return redirect()->route('referral.register')
                    ->with('error', trans('referral::messages.register.delay_expired')); 
            }
        }
    
        if(Referrals::where('referred_id', $user->id)->exists()) {
            return redirect()->route('referral.register')
                             ->with('error', trans('referral::messages.register.cant_register_several_referrers')); 
        }
    
        $refId = $referrer->id; 

        Referrals::create([
            'referrer_id' => $refId,
            'referred_id' => $user->id,
            'created_at' => now(),
            'updated_at' => now(),
            'referrer_total_earn' => 0,
            'created_via_link' => False,
        ]);

        $notification_content = trans('referral::messages.notifications.referrer_registred');
        $notification_text = str_replace('%username%', $nickname, $notification_content);

        $referrer_notification_content = trans('referral::messages.notifications.referred_reffer');
        $referrer_notification_text = str_replace('%username%', $user->name, $referrer_notification_content);

        (new AlertNotification($notification_text))
            ->send($user);

        (new AlertNotification($referrer_notification_text))
            ->send($referrer);

        return redirect()->route('referral.register')
            ->with('success', setting('referral.success_message'), trans('referral::messages.referral.default_success_message'));
    }  
}
