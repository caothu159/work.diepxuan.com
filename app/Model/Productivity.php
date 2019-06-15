<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Productivity extends Model
{
    /**
     * The data file associated with the model.
     *
     * @var string
     */
    const DATAFILE = 'nangsuat.xlsx';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date',
        'car_id',
        'productivity',
        'in_debt',
        'take_debt',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
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
    public $timestamps = true;

    public function car()
    {
        return $this->belongsTo(\App\Car::class);
    }

    public function divisions()
    {
        return $this->hasMany(\App\Division::class);
    }
}
