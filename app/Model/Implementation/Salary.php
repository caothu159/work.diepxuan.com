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
     * @return void
     */
    public function years();

    /**
     * List all month in year.
     *
     * @param bool $year
     * @return void
     */
    public function months();

    /**
     * Get Link go to view salary.
     *
     * @param int $year
     * @param int $month
     * @return void
     */
    public function link(int $year = null, int $month = null);
}
