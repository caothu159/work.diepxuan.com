<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

namespace App\Http\Controllers;

use App\Salary;
use Illuminate\Http\Request;

class SalaryController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @param string|null $year
     * @param string|null $month
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function index( string $year = null, string $month = null ) {
        return view( 'home', [
            'time' => [
                'year'  => $year,
                'month' => $month,
            ],
            'data' => $this->_loadSalary( $year, $month ),
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
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
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
     * @param \Illuminate\Http\Request $request
     * @param int $id
     *
     * @return \Illuminate\Http\Response
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
     * List all month in year.
     *
     * @param string $year
     *
     * @return void
     */
    public static function months( string $year = null ) {
        return array_diff( scandir( ( new \App\Data )->datadir( $year ) ), [ '.', '..' ] );
    }

    /**
     * List all years .
     *
     * @return void
     */
    public static function years() {
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
    public static function link( string $year = null, string $month = null ) {
        $router = self::isAdmin() ? 'admin.' : '';
        if ( ! $year ) {
            return route( $router . 'salary' );
        }
        if ( ! $month ) {
            return route( $router . 'salary', [ 'year' => $year ] );
        }

        return route( $router . 'salary', [ 'year' => $year, 'month' => sprintf( "%02d", $month ) ] );
    }

    /**
     * Get salaries to show.
     *
     * @param string|null $year
     * @param string|null $month
     *
     * @return Collection $collection
     * @throws \Exception
     */
    protected function _loadSalary( string $year = null, string $month = null ) {
        $dt = sprintf( '%s-%s', $year ?: date( 'Y' ), $month ?: date( 'm' ) );

        $month = new \DateTime( $dt );
        $month = $month->getTimestamp() / ( 24 * 60 * 60 ) + 25569;

        $collection = Salary::where( 'month', $month )->orderBy( 'name', 'asc' )->get();

        return $collection;
    }
}
