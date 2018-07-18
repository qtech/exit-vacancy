<?php

namespace App\Http\Middleware;

use Closure;

class Hotelowner
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
        if(Auth()->user()->role == 3)
        {
            return $next($request);
        }
        else
        {
            return redirect()->route('login')->with('error','Un-Authorized Access!');
        }
    }
}
