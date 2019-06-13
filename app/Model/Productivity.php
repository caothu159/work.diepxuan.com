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
        'date',
        'month',
        'car_id',
        'nang suat',
        'cho no',
        'thu no',
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
    public $timestamps = false;

    public function car()
    {
        return $this->hasOne(App\Car::class, 'id', 'car_id');
    }
}
