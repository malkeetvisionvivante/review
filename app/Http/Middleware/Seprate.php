<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Seprate
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
       // if(Auth::check())
       // {
       //    if(Auth::user()->role == 1)
       //    {
       //      return redirect('/admin/dashboard');
       //    }
       //    if(Auth::user()->role == 2)
       //    {
       //       return redirect('/company/dashboard');
       //    }
       // } 
        return $next($request);
    }
}
