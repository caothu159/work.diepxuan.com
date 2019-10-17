<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

namespace App\Http\Controllers\Salary;

class HomeController extends Controller {
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware( [
            'auth',
            'clearcache',
        ] );
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {
        return view( 'home', [
            'controller' => $this,
            'time'       => [
                'year'  => null,
                'month' => null,
            ],
            'data'       => [],
        ] );
    }
}
