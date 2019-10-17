<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

namespace App\Http\Controllers\Salary;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

class Controller extends \App\Http\Controllers\Controller {

    /**
     * @return mixed
     */
    public function isAdmin() {
        return auth()->user()->isAdmin();
    }

    /**
     * List all month in year.
     *
     * @param string $year
     *
     * @return void
     */
    public function months( string $year = null ) {
        return array_diff( scandir( ( new \App\Data )->datadir( $year ) ), [ '.', '..' ] );
    }

    /**
     * List all years .
     *
     * @return void
     */
    public function years() {
        return array_diff( scandir( ( new \App\Data )->datadir() ), [ '.', '..' ] );
    }

    /**
     * Get Link go to view salary.
     *
     * @param string $year
     * @param string $month
     *
     * @return string
     */
    public function link( string $year = null, string $month = null ) {
        if ( ! $year ) {
            return route( 'salary.index' );
        }
        if ( ! $month ) {
            return route( 'salary.index', [ 'year' => $year ] );
        }

        return route( 'salary.index', [ 'year' => $year, 'month' => sprintf( "%02d", $month ) ] );
    }
}
