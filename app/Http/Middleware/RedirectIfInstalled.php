<?php

namespace App\Http\Middleware;

use Closure;

class RedirectIfInstalled
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (config('app.installed')) {
            return redirect()->route('home');
        }

        return $next($request);
    }
}
