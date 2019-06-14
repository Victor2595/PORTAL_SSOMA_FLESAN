<?php

namespace Portal_SSOMA\Http\Middleware;

use Closure;

class Cors
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
        ->header('Access-Control-Allow-Origin', '*');
        ->header('Access-Control-Allow-Methods', 'POST, GET, OPTIONS, PUT, DELETE');
        return $next($request);
    }
}
