<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

namespace App\Model;

//use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Model as Eloquent;

class Salary extends Eloquent {
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'month',

        'default',

        'presence',
        'salary_default',

        'turnover',
        'productivity',

        'salary',
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

    /**
     * @return mixed
     */
    public function presences() {
        return $this->hasMany( \App\Presence::class );
    }

    /**
     * @return mixed
     */
    public function types() {
        return $this->hasMany( \App\SalaryType::class );
    }

    /**
     * @return mixed
     */
    public function user() {
        return $this->belongsTo( \App\User::class, 'salary_name', 'name' );
    }

    public function getNameAttribute() {
        $this->user = \App\User::where( 'salary_name', $this->attributes['name'] )->first();
        if ( ! $this->user ) {
            return $this->attributes['name'];
        }

        return $this->user->name;
    }

    public function getWeekstartAttribute() {
        return date( 'w', ( $this->month - 25569 ) * 86400 );
    }
}
