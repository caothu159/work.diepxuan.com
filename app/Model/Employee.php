<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    const DATAFILE = 'nhanvien.xlsx';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'salary_id',
        'default',
        '_0',
        '_13',
        '_20',
        '_30',
        '_40',
        '_50',
        '_60',
        '_70',
        '_80',
        'percent',
        'with',
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
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        //
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    public function salary()
    {
        return $this->belongsTo(\App\Salary::class);
    }

    public function division()
    {
        return $this->hasOne(\App\Division::class, 'salary_id', 'salary_id');
    }
}
