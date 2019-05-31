<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

namespace App\Model\Adapter;

trait Employee
{
    use AbstractAdapter;
    use Data;

    public function fileContent()
    {
        # code...
        return $this->_fileContent($this->datapath($this->_datafile));
        // return $this->datapath($this->_datafile);
    }
}
