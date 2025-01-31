<?php
namespace Azuriom\Plugin\Referral\Listeners;

use Azuriom\Plugin\Shop\Models\Payment;
use Azuriom\Plugin\Referral\Models\ReferralTransaction;
use Azuriom\Models\User;
use Azuriom\Notifications\AlertNotification;
use Illuminate\Support\Str;
use Illuminate\Mail\Events\MessageSending;
use Azuriom\Plugin\Referral\Models\Referrals;
use Illuminate\Support\Facades\Log;

class ShopBuyListener
{
    public function handle(MessageSending $event)
    {
        if(!isset($event->data['__laravel_notification']) || $event->data['__laravel_notification'] !== 'Azuriom\Plugin\Shop\Notifications\PaymentPaid') {
            return;
        }

        $transactionId = ltrim(trim(Str::between($event->data['introLines'][2], ':', '(')), '#');
        $payment = Payment::where('id', $transactionId)->latest()->first();

        if(!$payment) {
            return;
        }

        if($payment && $payment->isWithSiteMoney()) {
            $give_percentage_enable = setting('referral.referral.enabled', false);
            $user_id = $payment->user_id;
            if($give_percentage_enable && Referrals::where('referred_id', $user_id)->exists()) {
                $amount = $payment->price; 
                $user = User::find($user_id);
                $percentage = (float)setting('referral.percentage', 1) / 100;

                $final_amount = round($amount * $percentage, 2);

                $username = $user->name;
                $referrer_id = Referrals::where('referred_id', $user_id)->value('referrer_id');
                $referrer = User::find($referrer_id);
                
                if($referrer !== null) {
                    $limit = setting('referral.limit', 0);

                    if($limit > 0 && $final_amount > $limit) {
                        $final_amount = $limit;
                    }
                    
                    $referrer->money += $final_amount;
                    $referrer->save();

                    $send_notification = setting('referral.send_notification', true);
          
                    ReferralTransaction::create([
                        'user_id' => $user->id,
                        'command_id' =>  $transactionId,
                        'total_amount' => $amount,
                        'referrer_id' => $referrer->id,
                        'percentage_given' => setting('referral.percentage', 1),
                        'given_amount' => $final_amount,
                        'created_at' => now(),
                        'updated_at' => now(),
                     ]);
 
                     $referrer_total_earn = (float)Referrals::where('referred_id', $user_id)->value('referrer_total_earn');
                     $new_amount = round(($referrer_total_earn + $final_amount), 2);
                     Referrals::where('referred_id', $user_id)->update(['referrer_total_earn' => $new_amount]);

                    if($send_notification) {
                        try {
                            $initial_string = setting('referral.notification');

                            $search = ['{referred_name}', '{amount}', '{percentage}', '{currency}'];
                            $replace = [$username, $final_amount, $percentage * 100, $this->getCurrencyName()];
    
                            $notification = str_replace($search, $replace, $initial_string);
                           (new AlertNotification($notification))
                            ->send($referrer);
                        } catch(Exception $e) {
                            Log::error($e);
                        }
                    }
                }
            }
        } else {
            return;
        }
    }

    private function getCurrencyName()
    {
        return money_name();
    }
}

