<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller as Controller;
use App\Salary;

class SalaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param string $year
     * @param string $month
     * @return \Illuminate\Http\Response
     */
    public function index(string $year = null, string $month = null)
    {
        $salary = (new Salary())->setYear($year)->setMonth($month);

        return view('admin', [
            'salary' => $salary,
            'data'   => $salary,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @return void|\Illuminate\Http\Response
     */
    public function show()
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
     * Get Link go to view salary.
     *
     * @param string $year
     * @param string $month
     * @param string $type
     * @return string
     */
    public function link(string $year = null, string $month = null, string $type = null)
    {
        if (!$year) {
            return route('salary');
        }
        if (!$month) {
            return route('salary', ['year' => $year]);
        }
        if (!$type) {
            return route('salary', ['year' => $year, 'month' => $month]);
        }

        return route($type, ['year' => $year, 'month' => $month]);
    }
}
