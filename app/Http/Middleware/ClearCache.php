<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

namespace App\Http\Middleware;

use Artisan;
use Closure;

class ClearCache
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
        if (! in_array(config('app.env'), ['production', 'staging'])) {
            Artisan::call('view:clear');
        }

        return $next($request);
    }
}
