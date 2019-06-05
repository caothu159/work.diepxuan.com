<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

namespace App\Model\Factory;

trait Salary
{
    /**
     * Salary Construct.
     *
     * @param string $year
     * @param string $month
     */
    public function __construct()
    {
        parent::__construct();
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
     * @param string $year
     * @param string $month
     * @param string $type
     * @return string
     */
    public function link(string $year = null, string $month = null, string $type = null)
    {
        if (!$year) {
            return route('salary');
        }
        if (!$month) {
            return route('salary', ['year' => $year]);
        }
        if (!$type) {
            return route('salary', ['year' => $year, 'month' => $month]);
        }

        return route($type, ['year' => $year, 'month' => $month]);
    }
}
