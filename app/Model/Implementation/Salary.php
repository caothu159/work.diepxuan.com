<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

namespace App\Model\Implementation;

interface Salary
{
    /**
     * List all years .
     *
     * @return array
     */
    public function years();

    /**
     * List all month in year.
     *
     * @param bool $year
     * @return array
     */
    public function months();

    /**
     * Get Link go to view salary.
     *
     * @param string $year
     * @param string $month
     * @param string $type
     * @return string
     */
    public function link(string $year = null, string $month = null, string $type = null);

    /**
     * Valid Data to build salary.
     *
     * @return bool
     */
    public function hasData();

    /**
     * Get data file path.
     *
     * @param string $file
     * @return string
     */
    public function datapath(string $file = null);

    /**
     * Get data directory path.
     *
     * @return string
     */
    public function datadir();
}
