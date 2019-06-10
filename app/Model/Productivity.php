<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Productivity extends Model
{
    /**
     * The data file associated with the model.
     *
     * @var string
     */
    protected $_datafile = 'nangsuat.xlsx';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'time';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'time',
        'ns 01593',
        'no 01593',
        'thu no 01593',
        'ns 03166',
        'no 03166',
        'thu no 03166',
        'ns 05605',
        'no 05605',
        'thu no 05605',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
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
     * Import Data from file to database.
     *
     * @return void
     */
    public function importFromFile()
    {
        $data = new \App\Data($this->getYear(), $this->getMonth());
        foreach ($data->loadFromFile($this->_datafile) as $time => $val) {
            $val['time'] = $time;
            $this::updateOrCreate([
                'time' => $time,
            ], $val);
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
