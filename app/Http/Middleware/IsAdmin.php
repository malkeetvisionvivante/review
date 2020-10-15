<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) 
    {

         if(Auth::guard('admin')->user() && Auth::guard('admin')->user()->isAdmin()) {
            //echo Auth::guard('admin')->user()->id;die;
            return $next($request);
        }
          return redirect('admin/login');
    }
}
