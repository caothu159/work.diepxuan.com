<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

namespace App\Model\Adapter;

trait AbstractAdapter
{
    /**
     * Valid Data to build salary.
     *
     * @return bool
     */
    public function hasData()
    {
        return $this->getYear() and $this->getMonth();
    }

    /**
     * Get data file path.
     *
     * @param string $file
     * @return string
     */
    public function datapath(string $file = null)
    {
        return $this->datadir().$file;
    }

    /**
     * Get data directory path.
     *
     * @return string
     */
    public function datadir()
    {
        return $this->_datadir($this->getYear(), $this->getMonth());
    }

    /**
     * Get datadir path.
     *
     * @param string $year
     * @param string $month
     * @return string
     */
    protected function _datadir(string $year = null, string $month = null)
    {
        if ($year && $month) {
            return $this->__datadir()
                .$year.DIRECTORY_SEPARATOR
                .$month.DIRECTORY_SEPARATOR;
        }

        return $this->__datadir();
    }

    /**
     * Get datadir path.
     *
     * @return string
     */
    private function __datadir()
    {
        return dirname(base_path()).config('salary.datadir');
    }
}
