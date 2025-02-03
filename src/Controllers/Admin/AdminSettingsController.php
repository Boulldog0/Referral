<?php

namespace Azuriom\Plugin\Referral\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Models\ActionLog;
use Azuriom\Models\Setting;
use Illuminate\Http\Request;
use Azuriom\Models\User;
use Azuriom\Plugin\Referral\Models\Referrals;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Schema\Blueprint;

class AdminSettingsController extends Controller
{
    public function index()
    {
        return view('referral::admin.settings', [
            'user' => Auth::user(),
            'descMessage' => setting('referral.desc_message', ''),
            'regOnlyACr' => setting('referral.ereff', true),
            'sendNotification' => setting('referral.send_notification', true),
            'notifContent' => setting('referral.notification', trans('referral::messages.admin.settings.def_notif')),
            'registerExpireAfter' => setting('referral.registration_period', 300),
            'successMessage' => setting('referral.success_message', trans('referral::messages.referral.default_success_message')),
            'noReferrer' => setting('referral.no_referrer', trans('referral::messages.profile.no_referrer')),
            'noReferred' => setting('referral.no_referred', trans('referral::messages.profile.no_referred_users')),
        ]);
    }

    public function save(Request $request)
    {
        $data = $this->validate($request, [
            'desc_message' => ['nullable', 'string'],
            'notification' => ['string'],
            'success_message' => ['nullable', 'string'],
            'no_referrer' => ['nullable', 'string'],
            'no_referred' => ['nullable', 'string'],
        ]);
    
        Setting::updateSettings([
            'referral.desc_message' => $request->input('desc_message'),
            'referral.ereff' => $request->boolean('enable_referral'), 
            'referral.send_notification' => $request->boolean('send_notification'),
            'referral.notification' => $request->input('notification'),
            'referral.registration_period' => $request->input('expire', 300),
            'referral.success_message' => $request->input('success_message'),
            'referral.no_referrer' => $request->input('no_referrer'), 
            'referral.no_referred' => $request->input('no_referred'), 
        ]);
    
        ActionLog::log('referral.settings.updated');
    
        return to_route('referral.admin.settings')
            ->with('success', trans('admin.settings.updated'));
    }  
    
    public function changeReferrer(Request $request, $id)
    {
        $user = User::find($id);
        if($user && $user !== null) {
            $newReferrer = $request->input('referrer');
            if($newReferrer === null || $newReferrer === '') {
                if(Referrals::where('referred_id', $user->id)->exists()) {
                    Referrals::where('referred_id', $user->id)->delete();
                    return redirect()->route('admin.users.edit', ['user' => $user->id])
                        ->with('success', trans('referral::messages.admin.account_updated'));
                }
            } else {
                $rUser = User::where('name', $newReferrer);
                $rId = User::where('name', $newReferrer)->value('id');
                if($rUser && $rUser !== null) {
                    if(Referrals::where('referred_id', $id)->exists()) {
                        Referrals::where('referred_id', $id)->update(['referrer_id' => $rId]);
                    } else {
                        Referrals::create([
                            'referrer_id' => $rId,
                            'referred_id' => $user->id,
                            'referrer_total_earn' => 0,
                            'created_via_link' => False,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    };
                }
                return redirect()->route('admin.users.edit', ['user' => $user->id])
                    ->with('success', trans('referral::messages.admin.account_updated'));
            }
        } else {
            return redirect()->route('admin.users.edit', ['user' => $user->id])
                ->with('error', trans('referral::messages.admin.unknow_player'));
        }
    }

    public function recreateReferralTables()
    {
        if(!Auth::user()->can('referral.resetdb')) {
            return redirect()->route('home')
                ->with('error', trans('referral::messages.permissions.noperm'));
        }
    
        $tables = ['referrals', 'referrals_registrations', 'referrals_transactions'];
    
        foreach($tables as $table) {
            if(Schema::hasTable($table)) {
                Schema::drop($table);
            }
        }
    
        Schema::create('referrals', function (Blueprint $table) {
            $table->id();
            $table->integer('referred_id');
            $table->integer('referrer_id');
            $table->decimal('referrer_total_earn');
            $table->boolean('created_via_link');
            $table->timestamps();
        });

        Schema::create('referrals_registrations', function(Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });

        Schema::create('referrals_transactions', function(Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('command_id');
            $table->integer('total_amount');
            $table->integer('referrer_id');
            $table->integer('percentage_given');
            $table->integer('given_amount');
            $table->timestamps();
        });
    
        return redirect()->back()->with('success', trans('referral::messages.admin.db_regen_successfully'));
    }
}
