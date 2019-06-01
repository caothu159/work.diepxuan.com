<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

namespace App\Model\Factory;

trait Presence
{
    /**
     * Employee construct.
     *
     * @param string $year
     * @param string $month
     */
    public function __construct(string $year = null, string $month = null)
    {
        if ($year) {
            $this->year = $year;
        }

        if ($month) {
            $this->month = $month;
        }

        if ($this->hasData()) {
        }

        return parent::__construct();
    }
}
