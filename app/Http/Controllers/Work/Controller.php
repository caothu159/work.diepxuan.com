<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

namespace App\Http\Controllers\Work;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class Controller extends \App\Http\Controllers\Controller {

    /**
     * Instantiate a new controller instance.
     *
     * @param Request $request
     *
     * @return void
     */
    public function __construct( Request $request ) {
        $this->middleware( [
            'auth',
            'admin',
            'clearcache'
        ] );
//        $this->middleware('log')->only('index');
//        $this->middleware('subscribed')->except('store');

        $this->_updateRequestInput( $request );
    }

    /**
     * Fix dateinput automatic
     *
     * @param Request $request
     */
    protected function _updateRequestInput( Request $request ) {
        if ( '' != ( $inputFrom = $request->input( 'from' ) ) ) {
            $inputFrom = \DateTime::createFromFormat( 'd-m-Y', $inputFrom );
            $inputFrom = $inputFrom ?: \DateTime::createFromFormat( 'd-m-Y', date( '01-m-Y' ) );
            $inputFrom = $inputFrom->format( 'Y-m-d' );
            $request->merge( [ 'from' => $inputFrom ] );
        }

        if ( '' != ( $inputTo = $request->input( 'to' ) ) ) {
            $inputTo = \DateTime::createFromFormat( 'd-m-Y', $inputTo );
            $inputTo = $inputTo ?: \DateTime::createFromFormat( 'd-m-Y', date( 'd-m-Y' ) );
            $inputTo = $inputTo->format( 'Y-m-d' );
            $request->merge( [ 'to' => $inputTo ] );
        }
    }

    /**
     * @param Request $request
     * @param string|null $from
     * @param string|null $to
     *
     * @return Response|false
     */
    protected function _updateDateInput( Request $request, string $from = null, string $to = null ) {
        $inputFrom = $request->input( 'from' );
        if ( $inputFrom != $from ) {
            return redirect()->to( $this->redirectPath() )
                             ->withInput( [
                                 'from' => $inputFrom,
                             ] );
        }

        $inputTo = $request->input( 'to' );
        if ( $inputTo != $to ) {
            return redirect()->to( $this->redirectPath() )
                             ->withInput( [
                                 'from' => $inputFrom,
                                 'to'   => $inputTo,
                             ] );
        }

        return false;
    }

}
