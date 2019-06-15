<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'month',
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
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        //
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    public function employee()
    {
        return $this->hasOne(\App\Employee::class);
    }

    public function presences()
    {
        return $this->hasMany(\App\Presence::class);
    }

    public function divisions()
    {
        return $this->hasMany(\App\Division::class);
    }

    public function getDefaultAttribute()
    {
        $return = $this->employee->default / 30;
        $return *= $this->presences->sum('presence');
        $return = number_format($return, 0);

        return $return;
    }

    public function getProductivityAttribute()
    {
        return $this->divisions->sum('salary_value');
    }
}
