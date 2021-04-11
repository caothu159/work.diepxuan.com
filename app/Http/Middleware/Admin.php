<?php
/**
 * Copyright © DiepXuan, Ltd. All rights reserved.
 */

namespace App\Http\Middleware;

use Closure;

class Admin
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
        if (auth()->check() && auth()->user()->isAdmin()) {
            return $next($request);
        }

        return redirect('/home')->with('error', 'You have not admin access');
    }
}
