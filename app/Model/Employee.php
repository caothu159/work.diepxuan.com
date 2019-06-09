<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $_datafile = 'nhanvien.xlsx';

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
        'salary_id',
        'Luong co ban',
        '_0',
        '_13',
        '_20',
        '_30',
        '_40',
        '_50',
        '_60',
        '_70',
        '_80',
        'Ti le',
        'Bat cap',
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
     * Import Data from file to database.
     *
     * @return void
     */
    public function importFromFile()
    {
        $time = sprintf('%s-%s', $this->getYear(), $this->getMonth());
        $time = new \DateTime($time);
        $time = $time->getTimestamp() / (24 * 60 * 60) + 25569;

        $data = new \App\Data($this->getYear(), $this->getMonth());
        foreach ($data->loadFromFile($this->_datafile) as $salary_id => $val) {
            $val['salary_id'] = $salary_id;
            $this::updateOrCreate([
                'salary_id' => $salary_id,
                'time'      => $time,
            ], [
                'salary_id'    => $salary_id,
                'time'         => $time,
                'Luong co ban' => $val['Luong co ban'],
                '_0'           => $val['0'],
                '_13'          => $val['12.5'],
                '_20'          => $val['20'],
                '_30'          => $val['30'],
                '_40'          => $val['40'],
                '_50'          => $val['50'],
                '_60'          => $val['60'],
                '_70'          => $val['70'],
                '_80'          => $val['80'],
                'Ti le'        => $val['Ti le'],
                'Bat cap'      => $val['Bat cap'],
            ]);
        }
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

    /**
     * Get data in a month.
     *
     * @return array data
     */
    public function getByTime()
    {
        if (! $this->hasData()) {
            return $this::all();
        }

        $dt = sprintf('%s-%s', $this->getYear(), $this->getMonth());
        $first = date('Y-m-01', strtotime($dt));
        $first = new \DateTime($first);
        $first = $first->getTimestamp() / (24 * 60 * 60) + 25569;

        $last = date('Y-m-t', strtotime($dt));
        $last = new \DateTime($last);
        $last = $last->getTimestamp() / (24 * 60 * 60) + 25569;

        return $this->whereBetween('time', [$first, $last])->get();
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
}
