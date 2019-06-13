<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
/**
 * The attributes that are mass assignable.
 *
 * @var array
 */
    protected $fillable = [
        'name',
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
    public $timestamps = true;

    public function divisions()
    {
        return $this->hasMany(\App\Division::class);
    }

    public function productivity()
    {
        return $this->belongsTo(App\Productivity::class, 'car_id', 'id');
    }
}
