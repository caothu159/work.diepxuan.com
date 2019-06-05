<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

namespace App\Model\Adapter;

trait Salary
{
    use AbstractAdapter;

    public function data($type)
    {
        return [
            'test' => 'data',
            'type' => $type,
        ];
    }
}
