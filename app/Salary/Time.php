<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

namespace App\Salary;

trait Time
{
    /**
     * List all years.
     */
    public function months($year = false)
    {
        if (! $year) {
            return [];
        }

        return array_diff(scandir($this->_datadir().DIRECTORY_SEPARATOR.$year), ['.', '..']);
    }

    /**
     * List all years.
     */
    public function years()
    {
        return array_diff(scandir($this->_datadir()), ['.', '..']);
    }

    /**
     * get Link go to view salary.
     */
    public function link(int $year = null, int $month = null)
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
     * get datadir path.
     */
    protected function _datadir()
    {
        return dirname(base_path()).config('salary.datadir');
    }
}
