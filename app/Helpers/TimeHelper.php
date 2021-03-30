<?php
/**
 * Copyright © DiepXuan, Ltd. All rights reserved.
 */

namespace App\Helpers;

trait TimeHelper
{
    public function getDaysByMonth(string $year = null, string $month = null)
    {
        $days  =[];

        for ($d=1; $d <= 31; ++$d) {
            $time=mktime(12, 0, 0, $month, $d, $year);
            if (date('m', $time) == $month) {
                $days[]=date('Y-m-d-D', $time);
            }
        }

        return $days;
    }
}
