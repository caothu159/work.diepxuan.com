<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

namespace App\Http\Controllers\Admin;

use App\Employee;
use App\Http\Controllers\Controller as Controller;
use App\Salary;
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
        $dt = sprintf('%s-%s', $year, $month);

        $time = new \DateTime($dt);
        $time = $time->getTimestamp() / (24 * 60 * 60) + 25569;

        // $first = date('Y-m-01', strtotime($dt));
        // $first = new \DateTime($first);
        // $first = $first->getTimestamp() / (24 * 60 * 60) + 25569;

        // $last = date('Y-m-t', strtotime($dt));
        // $last = new \DateTime($last);
        // $last = $last->getTimestamp() / (24 * 60 * 60) + 25569;

        $collection = Salary::where('month', $time)->orderBy('name', 'asc')->get();
        // $collection = $this->__loadEmployees($collection, $time);
        // $collection = $this->__loadPresences($collection, $time);
        // $collection = $this->__loadDivisions($collection, $first, $last);
        // $collection = $this->__loadProductivities($collection, $time);

        // foreach ($collection as $salary) {
        //     echo get_class($salary->employee);die;
        // }
        // $collection->dump();

        return $collection;
    }

    /**
     * Load employees.
     *
     * @param Collection $collection
     * @param integer $month
     * @return Collection $collection
     */
    private function __loadEmployees(Collection $collection, int $month)
    {
        $employees = \App\Employee::where('month', $month)->get()->sortBy('salary_id');
        foreach ($employees as $employee) {
            $salary           = new Salary;
            $salary->name     = $employee->salary_id;
            $salary->employee = $employee;

            $collection->put($salary->name, $salary);
        }

        return $collection;
    }

    /**
     * Load Presences.
     *
     * @param Collection $collection
     * @param integer $month
     * @return Collection $collection
     */
    private function __loadPresences(Collection $collection, int $month)
    {
        foreach ($collection as $salary) {
            $presences = \App\Presence::where('month', $month)
                ->where('salary_id', $salary->name)
                ->get();
            $salary->presences = $presences;

            $salary->presence = $presences->sum('presence');
            // $salary->salary = array(
            //     'presence' = $salary->presence
            // );
        }

        return $collection;
    }

    /**
     * Load Divisions.
     *
     * @param Collection $collection
     * @param integer $first
     * @param integer $last
     * @return Collection $collection
     */
    private function __loadDivisions(Collection $collection, int $first, int $last)
    {
        foreach ($collection as $salary) {
            $divisions = \App\Division::whereBetween('time', [$first, $last])
                ->where('salary_id', $salary->salary_id)
                ->get();
            $salary->divisions = $divisions;
        }

        return $collection;
    }

    /**
     * Load Productivities.
     *
     * @param Collection $collection
     * @param integer $first
     * @param integer $last
     * @return Collection $collection
     */
    private function __loadProductivities(Collection $collection, int $month)
    {
        foreach ($collection as $salary) {
            $productivities         = \App\Productivity::where('month', $month)->get();
            $salary->productivities = $productivities;
        }

        return $collection;
    }
}
