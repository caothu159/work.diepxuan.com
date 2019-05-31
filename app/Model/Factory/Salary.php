<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

namespace App\Model\Factory;

trait Salary
{
    public function __construct(int $year = null, int $month = null)
    {
        if ($year) {
            $this->year = $year;
        }

        if ($month) {
            $this->month = $month;
        }

        if ($this->hasData()) {

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
        if (!$year) {
            return [];
        }

        return array_diff(scandir($this->_datadir() . DIRECTORY_SEPARATOR . $year), ['.', '..']);
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
     * @param int $year
     * @param int $month
     * @return void
     */
    public function link(int $year = null, int $month = null)
    {
        if (!$year) {
            return route('salary');
        }
        if (!$month) {
            return route('salary', ['year' => $year]);
        }

        return route('salary', ['year' => $year, 'month' => $month]);
    }
}
