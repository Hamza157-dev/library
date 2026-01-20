<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LangMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $supported = ['en', 'ar'];
        $locale = substr($request->header('Accept-Language'), 0,2);
        if (! in_array($locale, $supported)) {
            $locale = config('app.fallback_locale'); 
        }
        app()->setLocale($locale);
       
        return $next($request);
    }
}
