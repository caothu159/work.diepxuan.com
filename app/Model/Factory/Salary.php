<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

namespace App\Model\Factory;

use App\Employee;
use App\Productivity;

trait Salary
{
    /**
     * Employee Construct.
     *
     * @param string $year
     * @param string $month
     */
    public function __construct(string $year = null, string $month = null)
    {
        if ($year) {
            $this->year = $year;
        }

        if ($month) {
            $this->month = $month;
        }

        if ($this->hasData()) {
            $this->employee = new Employee($this->year, $this->month);
            $this->productivity = new Productivity($this->year, $this->month);
        }

        return parent::__construct();
    }

    /**
     * List all month in year.
     *
     * @param bool $year
     * @return void
     */
    public function months($year = false)
    {
        if (! $year) {
            return [];
        }

        return array_diff(scandir($this->_datadir().DIRECTORY_SEPARATOR.$year), ['.', '..']);
    }

    /**
     * List all years .
     *
     * @return void
     */
    public function years()
    {
        return array_diff(scandir($this->_datadir()), ['.', '..']);
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
}
