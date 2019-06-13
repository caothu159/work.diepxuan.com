<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;

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
        $time = sprintf('%s-%s', $year, $month);
        $time = new \DateTime($time);
        $time = $time->getTimestamp() / (24 * 60 * 60) + 25569;

        $data = new \App\Data($year, $month);
        foreach ($data->loadFromFile(\App\Employee::DATAFILE) as $name => $val) {
            // $val['salary_id'] = $salary_id;

            $salary = \App\Salary::updateOrCreate([
                'name'  => $name,
                'month' => $time,
            ], [
                'name'  => $name,
                'month' => $time,
            ]);
            \App\Employee::updateOrCreate([
                'salary_id' => $salary->id,
            ], [
                'salary_id' => $salary->id,
                'default'   => $val['Luong co ban'],
                '_0'        => $val['0'],
                '_13'       => $val['12.5'],
                '_20'       => $val['20'],
                '_30'       => $val['30'],
                '_40'       => $val['40'],
                '_50'       => $val['50'],
                '_60'       => $val['60'],
                '_70'       => $val['70'],
                '_80'       => $val['80'],
                'percent'   => $val['Ti le'],
                'with'      => $val['Bat cap'],
            ]);
        }
    }
}
