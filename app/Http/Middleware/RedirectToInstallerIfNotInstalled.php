<?php

namespace App\Http\Middleware;

use Closure;

class RedirectToInstallerIfNotInstalled
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (! config('app.installed') && ! $request->is('install/*')) {
            return redirect('install/pre-installation');
        }

        return $next($request);
    }
}
