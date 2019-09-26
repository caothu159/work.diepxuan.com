<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

namespace App\Model;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Presence extends Eloquent {
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'salary_id',
        'car_id',
        'date',

        'presence',
        'presence_salary',

        'salary_count',
        'turnover',
        'in_debt',
        'take_debt',

        'percent',
        'productivity',
        'ratio',
        'productivity_salary',
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

    public function salary() {
        return $this->belongsTo( \App\Salary::class );
    }

    public function car() {
        return $this->belongsTo( \App\Car::class );
    }

    public function getDatetimeAttribute() {
        return date( 'd/m', ( $this->date - 25569 ) * 86400 );
    }

    /**
     * @return float|mixed
     */
    public function ratioInitial() {
        $ratio = 0;
        $types = $this->salary->types;
        foreach ( $types as $type ) {
            if ( ! is_numeric( $type->name ) ) {
                continue;
            }
            if ( $this->productivity <= doubleval( $type->name ) * 1000 ) {
                continue;
            }
            $ratio = max( $ratio, $type->value );
        }

        return doubleval( $ratio );
    }

    public function getWeekAttribute() {
        return date( 'w', ( $this->date - 25569 ) * 86400 );
    }

    public function getWeekdayAttribute() {
        return array(
            'CN',
            'T2',
            'T3',
            'T4',
            'T5',
            'T6',
            'T7',
        )[ $this->week ];
    }
}
