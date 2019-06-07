<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

namespace App\Model\Adapter;

trait Division
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
            if (0 == $time) {
                continue;
            }

            foreach ($val as $car_id => $salary_ids) {
                if (0 === $salary_ids) {
                    continue;
                }

                $salary_ids = explode('-', $salary_ids);

                foreach ($salary_ids as $salary_id) {
                    $this->updateOrCreate([
                        'time'      => $time,
                        'car_id'    => $car_id,
                        'salary_id' => $salary_id,
                    ], [
                        'time'      => $time,
                        'car_id'    => $car_id,
                        'salary_id' => $salary_id,
                    ]);
                }
            }
        }
    }
}
