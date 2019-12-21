<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

namespace App\Http\Controllers;

use App\Car;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;


class CarController extends Controller {
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware( 'auth' );
        $this->middleware( 'admin' );
    }

    /**
     * Display a listing of the resource.
     *
     * @param string|null $year
     * @param string|null $month
     *
     * @return Factory|View
     * @throws Exception
     */
    public function index( string $year = null, string $month = null ) {
        $dt = sprintf( '%s-%s', $year ?: date( 'Y' ), $month ?: ( date( 'm' ) . ' -1 month' ) );

        $timefrom = date( "Y-m-01", strtotime( $dt ) );
        $timefrom = new \DateTime( $timefrom );
        $timefrom = $timefrom->getTimestamp() / ( 24 * 60 * 60 ) + 25569;

        $timeto = date( "Y-m-t", strtotime( $dt ) );
        $timeto = new \DateTime( $timeto );
        $timeto = $timeto->getTimestamp() / ( 24 * 60 * 60 ) + 25569;

        return view( 'car', [
            'controller' => $this,
            'cars'       => Car::all(),
            'time'       => [
                'year'  => $year,
                'month' => $month,
                'from'  => $timefrom,
                'to'    => $timeto,
            ],
        ] );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store( Request $request ) {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show( $id ) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit( $id ) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update( Request $request, $id ) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id ) {
        //
    }

    /**
     * Get Link go to view cars.
     *
     * @param string $year
     * @param string $month
     *
     * @return string
     */
    public function link( string $year = null, string $month = null ) {
        if ( ! $year ) {
            return route( 'cars.index' );
        }
        if ( ! $month ) {
            return route( 'cars.index', [ 'year' => $year ] );
        }

        return route( 'cars.index', [ 'year' => $year, 'month' => sprintf( "%02d", $month ) ] );
    }
}
