<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

namespace App\Model\Prototype;

use Illuminate\Database\Eloquent\Model;

class Productivity extends AbstractPrototype
{
    /**
     * The data file associated with the model.
     *
     * @var string
     */
    protected $_datafile = 'nangsuat.xlsx';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'time';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'time',
        'ns 01593',
        'no 01593',
        'thu no 01593',
        'ns 03166',
        'no 03166',
        'thu no 03166',
        'ns 05605',
        'no 05605',
        'thu no 05605',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'time' => 0,
    ];

    /**
     * Make attributes available in the json response.
     *
     * @var array
     */
    protected $appends = [
        //
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];
}
