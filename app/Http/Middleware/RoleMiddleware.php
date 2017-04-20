<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class RoleMiddleware
{


    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role/*, $permission*/){
        if (Auth::guest()) {
            return redirect('login');
        }

        if (! $request->user()->hasRole($role)) {
            //echo "you dont have role";
        }

        // if (! $request->user()->can($permission)) {
        //     echo "you dont have permission";
        // }

        return $next($request);
    }
}
