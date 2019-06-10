<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
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
     * Make attributes available in the json response.
     *
     * @var array
     */
    protected $_appends = [];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $_attributes = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $_fillable = [];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * List all month in year.
     *
     * @param string $year
     * @return void
     */
    public function months(string $year = null)
    {
        return array_diff(scandir((new \App\Data)->datadir($year)), ['.', '..']);
    }

    /**
     * List all years .
     *
     * @return void
     */
    public function years()
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
    public function link(string $year = null, string $month = null)
    {
        if (! $year) {
            return route('salary');
        }
        if (! $month) {
            return route('salary', ['year' => $year]);
        }

        return route('salary', ['year' => $year, 'month' => $month]);
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
