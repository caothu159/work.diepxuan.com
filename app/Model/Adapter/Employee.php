<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

namespace App\Model\Adapter;

trait Employee
{
    use AbstractAdapter;
    use Data;

    /**
     * Import Data from file to database
     *
     * @return void
     */
    public function importFromFile()
    {
        $time = sprintf('%s-%s', $this->getYear(), $this->getMonth());
        $time = new \DateTime($time);
        $time = $time->getTimestamp() / (24 * 60 * 60) + 25569;
        // dd($this->loadFromFile());

        foreach ($this->loadFromFile() as $salary_id => $val) {
            $val['salary_id'] = $salary_id;
            $this::updateOrCreate([
                'salary_id' => $salary_id,
                'time'      => $time,
            ], [
                'salary_id'    => $salary_id,
                'time'         => $time,
                'Luong co ban' => $val['Luong co ban'],
                '_0'           => $val['0'],
                '_13'          => $val['12.5'],
                '_20'          => $val['20'],
                '_30'          => $val['30'],
                '_40'          => $val['40'],
                '_50'          => $val['50'],
                '_60'          => $val['60'],
                '_70'          => $val['70'],
                '_80'          => $val['80'],
                'Ti le'        => $val['Ti le'],
                'Bat cap'      => $val['Bat cap'],
            ]);
        }
    }
}
