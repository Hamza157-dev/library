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
        /** 
         * sent by browser like:
         * ar-SY,ar;q=0.9,en-US;q=0.8,en;q=0.7 
         */
        $supported = ['en', 'ar'];
        if ($request->hasHeader('Accept-Language')) {
            $locale = substr($request->header('Accept-Language'), 0, 2);
            if (! in_array($locale, $supported)) {
                $locale = config('app.fallback_locale');
            }
        }
        else 
            $locale = config('app.locale');

        app()->setLocale($locale);

        return $next($request);
    }
}
