<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class RedirectIfAdminAuthenticated
{
    public function handle($request, Closure $next)
    {
          //If request comes from logged in user, he will
          //be redirect to home page.
          if (Auth::guard()->check()) {
              return redirect('/user');
          }

          //If request comes from logged in organizer, he will
          //be redirected to organizer's home page.
          if (Auth::guard('organizer')->check()) {
              return redirect()->route('organizer.index');
          }

          //If request comes from logged in admin, he will
          //be redirected to admin's home page.
          if (Auth::guard('admin')->check()) {
              return redirect()->route('admin.index');
          }
      return $next($request);
    }
}
