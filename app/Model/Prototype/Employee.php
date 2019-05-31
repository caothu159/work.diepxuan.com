<?php

namespace App\Model\Prototype;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $_datafile = 'nhanvien.xlsx';
    public $year         = null;
    public $month        = null;
}
