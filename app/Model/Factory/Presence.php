<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

namespace App\Model\Factory;

trait Presence
{
    /**
     * Presence construct.
     *
     * @param string $year
     * @param string $month
     */
    public function __construct(string $year = null, string $month = null)
    {
        parent::__construct($year, $month);
    }
}
