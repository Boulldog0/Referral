<?php

namespace Azuriom\Plugin\Referral\Listeners;

use Illuminate\Auth\Events\Registered;
use Azuriom\Models\User;
use Azuriom\Plugin\Referral\Models\Referrals;
use Azuriom\Plugin\Referral\Models\ReferralRegistration;
use Azuriom\Notifications\AlertNotification;
use Illuminate\Support\Facades\Log;

class RedirectAfterRegistration
{
    public function handle(Registered $event)
    {
        $user = $event->user;

        if(request()->session()->has('referrer')) {
            $referrer = request()->session()->get('referrer');

            if ($user->name === $referrer) {
                return redirect()->route('referral.register')
                    ->with('error', trans('referral::messages.register.cant_register_yourself'));
            }

            if (Referrals::where('referred_id', $user->id)->exists()) {
                return redirect()->route('referral.register')
                    ->with('error', trans('referral::messages.register.cant_register_several_referrers'));
            }

            $ref = User::where('name', $referrer)->first();
            if (!$ref) {
                return redirect()->route('referral.register')
                    ->with('error', trans('referral::messages.register.given_user_not_found'));
            }

            try {
                Referrals::create([
                    'referrer_id' => $ref->id,
                    'referred_id' => $user->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                    'referrer_total_earn' => 0,
                    'created_via_link' => true,
                ]);
            } catch (\Exception $e) {
                return redirect()->route('referral.register')
                    ->with('error', trans('referral::messages.register.referral_error'));
            }

            $notification_content = trans('referral::messages.notifications.referrer_registred');
            $notification_text = str_replace('%username%', $ref->name, $notification_content);

            $referrer_notification_content = trans('referral::messages.notifications.referred_reffer');
            $referrer_notification_text = str_replace('%username%', $user->name, $referrer_notification_content);

            (new AlertNotification($notification_text))->send($user);
            (new AlertNotification($referrer_notification_text))->send($ref);

            session()->remove('referrer');

            return redirect()->route('referral.register')
            ->with('success', 
                setting('referral.success_message') ?? trans('referral::messages.referral.default_success_message'
            ));        
        } else {
            $register_referral_only_after_registration = setting('referral.ereff', true);

            if($register_referral_only_after_registration) {
                $registration_period = (int)setting('referral.registration_period', 300);
                $expires_at = now()->addSeconds($registration_period);

                ReferralRegistration::create([
                    'user_id' => $user->id,
                    'expires_at' => $expires_at,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            session(['rar' => true]);
        }
    }
}
