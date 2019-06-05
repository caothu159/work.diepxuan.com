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
     * @return void
     */
    public function importFromFile()
    {
        foreach ($this->loadFromFile() as $time => $val) {
            $this::updateOrCreate([
                'time' => $time,
            ], $val);
        }
    }
}
