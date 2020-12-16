<?php

namespace App\Http\Middleware;

use Artisan;
use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class ClearCache extends Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!in_array(config('app.env'), ['production', 'staging'])) {
            Artisan::call('view:clear');
        }

        return $next($request);
    }
}
