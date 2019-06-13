<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller as Controller;
use App\Productivity;
use Illuminate\Http\Request;

class ProductivityController extends Controller
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

        $cars = \App\Car::all();

        foreach ($data->loadFromFile(\App\Productivity::DATAFILE) as $date => $val) {
            $val['date'] = $date;

            foreach ($cars as $car) {
                \App\Productivity::updateOrCreate([
                    'date'   => $date,
                    'car_id' => $car->id,
                ], [
                    'date'      => $date,
                    'month'     => $month,
                    'car_id'    => $car->id,
                    'nang suat' => $val["ns $car->name"],
                    'cho no'    => $val["no $car->name"],
                    'thu no'    => $val["thu no $car->name"],
                ]);
            }
        }
    }
}
