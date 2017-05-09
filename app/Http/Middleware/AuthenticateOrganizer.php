<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class AuthenticateOrganizer
{
     public function handle($request, Closure $next)
    {
        //If request does not comes from logged in seller
        //then he shall be redirected to Seller Login page
        if (! Auth::guard('organizer')->check()) {
            return redirect('/organizer/login');
        }

        return $next($request);
    }
}
