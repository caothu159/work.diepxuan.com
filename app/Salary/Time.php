<?php

namespace App\Salary;

use Illuminate\Database\Eloquent\Model;

trait Time
{
    /**
     * List all years
     */
    public function months($year)
    {
        return array_diff(scandir($this->datadir().DIRECTORY_SEPARATOR.$year), ['.', '..']);
    }

    /**
     * List all years
     */
    public function years()
    {
        // return dirname(base_path()).config('salary.datadir');
        return array_diff(scandir($this->datadir()), ['.', '..']);
    }

    /**
     * get datadir path
     */
    public function datadir()
    {
        return dirname(base_path()).config('salary.datadir');
    }
}
