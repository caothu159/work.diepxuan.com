<?php

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
     * @param boolean $year
     * @return void
     */
    public function months();

    /**
     * Get Link go to view salary.
     *
     * @param integer $year
     * @param integer $month
     * @return void
     */
    public function link(int $year = null, int $month = null);
}
