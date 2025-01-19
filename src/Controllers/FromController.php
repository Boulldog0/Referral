<?php

namespace Azuriom\Plugin\Referral\Controllers;

use Azuriom\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Azuriom\Models\User;

class FromController extends Controller
{
    public function index(Request $request, $username)
    {
        $user = User::where('name', $username)->first();

        if(!$user || $user === null) {
            return redirect()->route('referral.register')
            ->with('error', trans('referral::messages.register.given_user_not_found'));
        }
        
        $request->session()->put('referrer', $username);
        return redirect()->route('register');
    }
}
