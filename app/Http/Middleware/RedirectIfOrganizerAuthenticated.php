<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class RedirectIfOrganizerAuthenticated
{
    public function handle($request, Closure $next)
    {
          //If request comes from logged in user, he will
          //be redirect to home page.
          if (Auth::guard()->check()) {
              return redirect('/home');
          }

          //If request comes from logged in seller, he will
          //be redirected to seller's home page.
          if (Auth::guard('organizer')->check()) {
              return redirect('/organizer');
          }
      return $next($request);
    }
}
