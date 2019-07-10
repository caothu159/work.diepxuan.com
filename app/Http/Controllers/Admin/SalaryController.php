<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\SalaryController as UserSalaryController;
use App\Services\DatafileService;

class SalaryController extends UserSalaryController {
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
        return view( 'admin', [
            'time' => [
                'year'  => $year,
                'month' => $month,
            ],
            'data' => $this->_loadSalary( $year, $month ),
        ] );
    }

    /**
     * Import Data from file to database.
     *
     * @param string $year
     * @param string $month
     *
     * @return \Illuminate\Http\Response
     */
    public function import( DatafileService $datafileService, string $year = null, string $month = null ) {
        $datafileService->salaryImport( $year, $month );

        return redirect()->route( 'admin.salary', [
            'year'  => $year,
            'month' => $month,
        ] );
    }

}
