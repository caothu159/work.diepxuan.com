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
     * @return void
     */
    public function fileContent()
    {
        return $this->_fileContent($this->datapath($this->_datafile));
    }
}
