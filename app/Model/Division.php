<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    protected $_datafile = 'phancong.xlsx';

    /**
     * Current year.
     *
     * @var string
     */
    protected $_year = null;

    /**
     * Current month.
     *
     * @var string
     */
    protected $_month = null;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'time',
        'car_id',
        'salary_id',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        //
    ];

    /**
     * Make attributes available in the json response.
     *
     * @var array
     */
    protected $appends = [
        //
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get data in a month
     *
     * @return array data
     */
    public function getByTime()
    {
        if (!$this->hasData()) {
            return $this::all();
        }

        $dt    = sprintf('%s-%s', $this->getYear(), $this->getMonth());
        $first = date('Y-m-01', strtotime($dt));
        $first = new \DateTime($first);
        $first = $first->getTimestamp() / (24 * 60 * 60) + 25569;

        $last = date('Y-m-t', strtotime($dt));
        $last = new \DateTime($last);
        $last = $last->getTimestamp() / (24 * 60 * 60) + 25569;

        return $this->whereBetween('time', [$first, $last])->get();
    }

    /**
     * Import Data from file to database
     *
     * @return void
     */
    public function importFromFile()
    {
        $data = new \App\Data($this->getYear(), $this->getMonth());
        foreach ($data->loadFromFile($this->_datafile) as $time => $val) {
            if (0 == $time) {
                continue;
            }

            foreach ($val as $car_id => $salary_ids) {
                if (0 === $salary_ids) {
                    continue;
                }

                $salary_ids = explode('-', $salary_ids);

                foreach ($salary_ids as $salary_id) {
                    $this->updateOrCreate([
                        'time'      => $time,
                        'car_id'    => $car_id,
                        'salary_id' => $salary_id,
                    ], [
                        'time'      => $time,
                        'car_id'    => $car_id,
                        'salary_id' => $salary_id,
                    ]);
                }
            }
        }
    }

    /**
     * @return string
     */
    public function getYear()
    {
        return $this->_year;
    }

    /**
     * @param string $year
     * @return object
     */

    /**
     * @param string $year
     * @return object $this
     */
    public function setYear(string $year = null)
    {
        $this->_year = $year;

        return $this;
    }

    /**
     * @return string
     */
    public function getMonth()
    {
        return $this->_month;
    }

    /**
     * @param string $year
     * @return object $this
     */
    public function setMonth(string $month = null)
    {
        $this->_month = $month;

        return $this;
    }

    /**
     * Valid Data to build salary.
     *
     * @return bool
     */
    public function hasData()
    {
        return $this->getYear() and $this->getMonth();
    }
}
