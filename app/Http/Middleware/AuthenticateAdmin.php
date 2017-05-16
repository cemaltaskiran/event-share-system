<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class AuthenticateAdmin
{
     public function handle($request, Closure $next)
    {
        //If request does not comes from logged in seller
        //then he shall be redirected to Seller Login page
        if (! Auth::guard('admin')->check()) {
            return redirect()->route('admin.login');
        }

        return $next($request);
    }
}
