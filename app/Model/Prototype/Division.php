<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

namespace App\Model\Prototype;

use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    public $year = null;
    public $month = null;

    protected $_datafile = 'phancong.xlsx';
}
