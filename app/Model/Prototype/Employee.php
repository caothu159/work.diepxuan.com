<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

namespace App\Model\Prototype;

class Employee extends AbstractPrototype
{
    protected $_datafile = 'nhanvien.xlsx';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'time',
        'salary_id',
        'Luong co ban',
        '_0',
        '_13',
        '_20',
        '_30',
        '_40',
        '_50',
        '_60',
        '_70',
        '_80',
        'Ti le',
        'Bat cap',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        //
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

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
