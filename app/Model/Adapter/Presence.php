<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

namespace App\Model\Adapter;

trait Presence
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
            foreach ($val as $salary_id => $presence) {
                $this::updateOrCreate([
                    'salary_id' => $salary_id,
                    'time'      => $time,
                ], [
                    'time'      => $time,
                    'salary_id' => $salary_id,
                    'presence'  => $presence,
                ]);
            }
        }
    }
}
