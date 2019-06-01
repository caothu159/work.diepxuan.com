<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

namespace App\Model\Prototype;

use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    /**
     * @var string
     */
    public $year = null;

    /**
     * @var string
     */
    public $month = null;

    /**
     * @var \App\Employee
     */
    public $employee;

    /**
     * @var \App\Productivity
     */
    public $productivity;

    /**
     * Make attributes available in the json response.
     *
     * @var array
     */
    protected $_appends = [];

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
