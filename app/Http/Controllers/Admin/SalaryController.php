<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

namespace App\Http\Controllers\Admin;

use App\Salary;
use App\Http\Controllers\Controller as Controller;

class SalaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin', ['salary' => new Salary]);
    }

    /**
     * Display the specified resource.
     *
     * @param string $year
     * @param string $month
     * @return void|\Illuminate\Http\Response
     */
    public function show(string $year = null, string $month = null)
    {
        $salary = new Salary($year, $month);
        // dd($salary->employee->fileContent());
        // dd($salary->productivity->fileContent());
        dd($salary->division->fileContent());

        return view('admin', ['salary' => $salary]);
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
}
