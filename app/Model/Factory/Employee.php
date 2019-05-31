<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

namespace App\Model\Factory;

trait Employee
{
    public function __construct(int $year = null, int $month = null)
    {
        if ($year) {
            $this->__year = $year;
        }

        if ($month) {
            $this->__month = $month;
        }

        if ($this->hasData()) {

        }

        return parent::__construct();
    }

    public function employees()
    {
        # code...
    }
}
