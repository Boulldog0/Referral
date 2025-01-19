<?php

namespace Azuriom\Plugin\Referral\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Models\ActionLog;
use Azuriom\Models\Setting;
use Illuminate\Http\Request;

class AdminRewardsController extends Controller
{
    public function index()
    {
        return view('referral::admin.rewards', [
            'regivePercentage' => setting('referral.referral.enabled', true),
            'percentage' => setting('referral.percentage', 1),
            'limit' => setting('referral.limit', 0),
        ]);
    }

    public function save(Request $request)
    {
        $data = $this->validate($request, [
            'percentage' => ['nullable', 'integer', 'min:0', 'max:99'],
            'limit' => ['nullable', 'integer', 'min:0', 'max:999999'],
        ]);        
    
        Setting::updateSettings([
            'referral.percentage' => $request->input('percentage'),
            'referral.referral.enabled' => $request->has('enable_referral'),
            'referral.limit' => $request->input('limit'),
        ]);
        
        ActionLog::log('referral.rewards.updated');
    
        return to_route('referral.admin.rewards')
            ->with('success', trans('admin.settings.updated'));
    }   
}
