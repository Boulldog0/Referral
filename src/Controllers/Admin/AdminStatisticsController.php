<?php

namespace Azuriom\Plugin\Referral\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;

class AdminStatisticsController extends Controller
{
    public function index()
    {
        return view('referral::admin.statistics');
    }
}
