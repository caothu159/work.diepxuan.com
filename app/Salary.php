<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

namespace App;

use App\Salary\Time as SalaryTime;
use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    use SalaryTime;
    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $_attributes = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $_fillable = [];
}
