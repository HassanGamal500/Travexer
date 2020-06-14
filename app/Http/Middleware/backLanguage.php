<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;

class backLanguage
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
        if (session()->has('back-locale')) {
            App::setLocale(session()->get('back-locale'));
        } 
        // else {
        //     App::setLocale('en');
        // }
        return $next($request);
    }
}
