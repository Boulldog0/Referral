<?php

namespace Azuriom\Plugin\Referral\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;
 
class RegisterMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if($request->session()->has('rar')) {
            $request->session()->remove('rar');
            return redirect('/referral/register');
        }
        return $next($request);
    }
}
