<?php

/**
 * Copyright © DiepXuan, Ltd. All rights reserved.
 */

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    /**
     * @return mixed
     */
    public function isAdmin()
    {
        return auth()->check() && auth()->user()->isAdmin();
    }
}
