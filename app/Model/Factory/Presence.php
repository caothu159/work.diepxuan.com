<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

namespace App\Model\Factory;

trait Presence
{
    /**
     * Presence construct.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get data in a month
     *
     * @return array data
     */
    public function getByTime()
    {
        if (!$this->hasData()) {
            return $this::all();
        }

        $dt    = sprintf('%s-%s', $this->getYear(), $this->getMonth());
        $first = date('Y-m-01', strtotime($dt));
        $first = new \DateTime($first);
        $first = $first->getTimestamp() / (24 * 60 * 60) + 25569;

        $last = date('Y-m-t', strtotime($dt));
        $last = new \DateTime($last);
        $last = $last->getTimestamp() / (24 * 60 * 60) + 25569;

        return $this->whereBetween('time', [$first, $last])->get();
    }
}
