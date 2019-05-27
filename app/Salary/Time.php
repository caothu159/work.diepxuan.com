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

        return array_diff(scandir($this->datadir().DIRECTORY_SEPARATOR.$year), ['.', '..']);
    }

    /**
     * List all years.
     */
    public function years()
    {
        return array_diff(scandir($this->datadir()), ['.', '..']);
    }

    /**
     * get datadir path.
     */
    public function datadir()
    {
        return dirname(base_path()).config('salary.datadir');
    }
}
