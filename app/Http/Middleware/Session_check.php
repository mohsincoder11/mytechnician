<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class Session_check
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
        if (Session::has('userdata')) {
            return $next($request);
        } else {
            return redirect()->route('log_in');
        }
    }
}
