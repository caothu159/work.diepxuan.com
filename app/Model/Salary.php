<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Salary extends Model {
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

    public function employee() {
        return $this->hasOne( \App\Employee::class );
    }

    public function presences() {
        return $this->hasMany( \App\Presence::class );
    }

    public function divisions() {
        return $this->hasMany( \App\Division::class );
    }

//    public function user() {
//        return $this->belongsTo( \App\User::class, 'salary_name', 'name' );
//    }

    public function getSalaryDefaultAttribute() {
        $return = $this->employee->default / 30;
        $return *= $this->presence;
        $return = intval( $return );

        return $return;
    }

    public function getPresenceAttribute() {
        return $this->presences->sum( 'presence' );
    }

    public function getProductivityAttribute() {
        return $this->divisions->sum( 'salary_value' );
    }

    public function getSalaryAttribute() {
        return $this->productivity + $this->salary_default;
    }

    public function getTurnoverAttribute() {
        if ( null == $this->divisions ) {
            return 0;
        }

        return $this->divisions->sum( 'productivity_value' );
    }

    public function getNameAttribute() {
        $this->user = \App\User::where( 'salary_name', $this->attributes['name'] )->first();
        if ( ! $this->user ) {
            return $this->attributes['name'];
        }

        return $this->user->name;
    }
}
