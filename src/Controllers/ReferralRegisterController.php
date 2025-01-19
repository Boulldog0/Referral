<?php

namespace Azuriom\Plugin\Referral\Controllers;

use Azuriom\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class ReferralRegisterController extends Controller
{
    public function index()
    {
        return view('referral::register', [
            'descMessage' => setting('referral.desc_message', ''),
            'onlyAfterRegistration' => setting('referral.ereff'),
        ]);
    }
}
