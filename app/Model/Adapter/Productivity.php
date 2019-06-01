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
     * @return array
     */
    public function fileContent()
    {
        return $this->_fileContent($this->datapath($this->_datafile));
    }
}
