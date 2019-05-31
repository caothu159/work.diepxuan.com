<?php

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
        return $this->year and $this->month;
    }

    /**
     * Get data file path.
     *
     * @param string $file
     * @return string
     */
    public function datapath(string $file = null)
    {
        return $this->datadir() . $file;
    }

    /**
     * Get data directory path.
     *
     * @return string
     */
    public function datadir()
    {
        return $this->_datadir($this->year, $this->month);
    }

    /**
     * get datadir path.
     *
     * @param integer $year
     * @param integer $month
     * @return string
     */
    protected function _datadir(int $year = null, int $month = null)
    {
        if ($year && $month) {
            return $this->__datadir()
            . $this->year . DIRECTORY_SEPARATOR
            . $this->month . DIRECTORY_SEPARATOR;
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
        return dirname(base_path()) . config('salary.datadir');
    }
}
