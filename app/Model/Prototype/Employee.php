<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

namespace App\Model\Prototype;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $_datafile = 'nhanvien.xlsx';
    public $year = null;
    public $month = null;
}
