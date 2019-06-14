<?php

namespace Portal_SSOMA\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Alert;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            Alert::warning('Usted no a iniciado sesion con algun usuario','Importante');
            return route('welcome');
            //return route('login');
        }
    }
}
