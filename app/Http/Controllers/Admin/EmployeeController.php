<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller as Controller;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param string $year
     * @param string $month
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, string $year = null, string $month = null)
    {
        $this->__importFromFile($year, $month);

        return redirect()->route('admin.salary', [
            'year'  => $year,
            'month' => $month,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Import Data from file to database.
     *
     * @param string $year
     * @param string $month
     * @return void
     */
    private function __importFromFile(string $year = null, string $month = null)
    {
        $data = new \App\Data($year, $month);

        $month = sprintf('%s-%s', $year, $month);
        $month = new \DateTime($month);
        $month = $month->getTimestamp() / (24 * 60 * 60) + 25569;

        foreach ($data->loadFromFile(\App\Employee::DATAFILE) as $name => $val) {
            $salary = \App\Salary::firstOrCreate([
                'name'  => $name,
                'month' => $month,
            ], []);

            \App\Employee::updateOrCreate([
                'salary_id' => $salary->id,
            ], [
                'default' => $val['Luong co ban'],
                '_0'      => $val['0'],
                '_13'     => $val['12.5'],
                '_20'     => $val['20'],
                '_30'     => $val['30'],
                '_40'     => $val['40'],
                '_50'     => $val['50'],
                '_60'     => $val['60'],
                '_70'     => $val['70'],
                '_80'     => $val['80'],
                'percent' => $val['Ti le'],
                'with'    => $val['Bat cap'],
            ]);
        }
    }
}
