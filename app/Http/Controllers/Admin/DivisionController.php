<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller as Controller;
use Illuminate\Http\Request;

class DivisionController extends Controller
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
     * @return void
     */
    private function __importFromFile(string $year, string $month)
    {
        $data = new \App\Data($year, $month);

        $month = sprintf('%s-%s', $year, $month);
        $month = new \DateTime($month);
        $month = $month->getTimestamp() / (24 * 60 * 60) + 25569;

        foreach ($data->loadFromFile(\App\Division::DATAFILE) as $date => $val) {
            if (0 == $date) {
                continue;
            }

            foreach ($val as $car_id => $salary_ids) {
                if (0 === $salary_ids) {
                    continue;
                }

                $car_id = str_replace('x', '', $car_id);
                $car    = \App\Car::where('name', $car_id)->first();

                if (null == $car) {
                    continue;
                }

                $salary_ids = explode('-', $salary_ids);

                foreach ($salary_ids as $salary_id) {
                    $salary = \App\Salary::where('name', $salary_id)
                        ->where('month', $month)->first();

                    if (null == $salary) {
                        continue;
                    }

                    \App\Division::updateOrCreate([
                        'salary_id' => $salary->id,
                        'car_id'    => $car->id,
                        'date'      => $date,
                    ], [
                        'salary_id'    => $salary->id,
                        'car_id'       => $car->id,
                        'date'         => $date,
                        'salary_count' => \sizeof($salary_ids),
                    ]);
                }
            }
        }
    }
}
