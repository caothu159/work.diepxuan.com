<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller as Controller;
use App\Salary;
use App\Services\DatafileService;
use Illuminate\Database\Eloquent\Collection;

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
        return view('admin', [
            'time' => [
                'year'  => $year,
                'month' => $month,
            ],
            'data' => $this->__loadSalary($year, $month),
        ]);
    }

    /**
     * Import Data from file to database.
     *
     * @param string $year
     * @param string $month
     * @return \Illuminate\Http\Response
     */
    public function import(DatafileService $datafileService, string $year = null, string $month = null)
    {
        $datafileService->salaryImport($year, $month);

        return redirect()->route('admin.salary', [
            'year'  => $year,
            'month' => $month,
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
     * List all month in year.
     *
     * @param string $year
     * @return void
     */
    public static function months(string $year = null)
    {
        return array_diff(scandir((new \App\Data)->datadir($year)), ['.', '..']);
    }

    /**
     * List all years .
     *
     * @return void
     */
    public static function years()
    {
        return array_diff(scandir((new \App\Data)->datadir()), ['.', '..']);
    }

    /**
     * Get Link go to view salary.
     *
     * @param string $year
     * @param string $month
     * @return string
     */
    public static function link(string $year = null, string $month = null)
    {
        if (!$year) {
            return route('admin.salary');
        }
        if (!$month) {
            return route('admin.salary', ['year' => $year]);
        }

        return route('admin.salary', ['year' => $year, 'month' => $month]);
    }

    /**
     * Get salaries to show.
     *
     * @param string $year
     * @param string $month
     * @return Collection $collection
     */
    private function __loadSalary(string $year = null, string $month = null)
    {
        $dt = sprintf('%s-%s', $year ?: date('Y'), $month ?: date('m'));

        $month = new \DateTime($dt);
        $month = $month->getTimestamp() / (24 * 60 * 60) + 25569;

        $collection = Salary::where('month', $month)->orderBy('name', 'asc')->get();

        return $collection;
    }
}
