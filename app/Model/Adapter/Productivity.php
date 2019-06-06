<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

namespace App\Model\Adapter;

trait Productivity
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
        foreach ($this->loadFromFile() as $time => $val) {
            $val['time'] = $time;
            $this::updateOrCreate([
                'time' => $time,
            ], $val);
        }
    }
}
