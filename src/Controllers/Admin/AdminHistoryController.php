<?php

namespace Azuriom\Plugin\Referral\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\Referral\Models\ReferralTransaction;

class AdminHistoryController extends Controller
{
    public function index()
    {
        $transactions = ReferralTransaction::all();
        return view('referral::admin.history', compact('transactions'));
    }
}
