<?php
/**
 * Copyright © DiepXuan, Ltd. All rights reserved.
 */

namespace App\Helpers;

trait TimeHelper
{
    public function getDaysByMonth(string $year = null, string $month = null)
    {
        $days  = [];

        for ($d=1; $d <= 31; ++$d) {
            $time=mktime(12, 0, 0, $month, $d, $year);
            if (date('m', $time) == $month) {
                $days[]=date('d', $time);
            }
        }

        return $days;
    }

    public function timeformat($m, $y, $splat='-')
    {
        return sprintf('%02d%s%04d', $m, $splat, $y);
    }

    public function getMonths()
    {
        $days     = [];
        $start    = (new \DateTime('now'))->modify('-6 months')->modify('first day of next month');
        $end      = (new \DateTime('now'))->modify('first day of next month');
        $interval = \DateInterval::createFromDateString('1 month');
        $period   = new \DatePeriod($start, $interval, $end);

        foreach ($period as $dt) {
            $days[]= (object) [
                'thang' => $dt->format('m'),
                'nam'   => $dt->format('Y'),
                'key'   => $this->timeformat($dt->format('m'), $dt->format('Y')),
                'view'  => $this->timeformat($dt->format('m'), $dt->format('Y'), '/'),
            ];
        }

        return array_reverse($days);
    }
}
