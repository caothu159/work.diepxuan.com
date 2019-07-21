<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Presence extends Model {
    const DATAFILE = 'chamcong.xlsx';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'salary_id',
        'date',
        'month',
        'presence',
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

    public function getDatetimeAttribute() {
        return date( 'd', ( $this->date - 25569 ) * 86400 );
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
