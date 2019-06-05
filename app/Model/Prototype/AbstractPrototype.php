<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

namespace App\Model\Prototype;

use Illuminate\Database\Eloquent\Model;

class AbstractPrototype extends Model
{
    protected $_year = null;
    protected $_month = null;

    public $datafile;

    /**
     * Employee construct.
     *
     * @param string $year
     * @param string $month
     */
    public function __construct(string $year = null, string $month = null)
    {
        if ($year) {
            $this->setYear($year);
        }

        if ($month) {
            $this->setMonth($month);
        }

        parent::__construct();
    }

    /**
     * @return string
     */
    public function getYear()
    {
        return $this->_year;
    }

    /**
     * @param string $year
     * @return object
     */

    /**
     * @param string $year
     * @return object $this
     */
    public function setYear(string $year = null)
    {
        $this->_year = $year;

        return $this;
    }

    /**
     * @return string
     */
    public function getMonth()
    {
        return $this->_month;
    }

    /**
     * @param string $year
     * @return object $this
     */
    public function setMonth(string $month = null)
    {
        $this->_month = $month;

        return $this;
    }
}
