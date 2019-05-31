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
     * @return string
     */
    public function link(string $year = null, string $month = null);
}
