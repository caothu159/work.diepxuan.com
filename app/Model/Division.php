<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Division extends Model {
    const DATAFILE = 'phancong.xlsx';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date',
        'car_id',
        'salary_id',
        'productivity_id',
        'salary_count',
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

    public function getDatetimeAttribute() {
        return date( 'd/m/Y', ( $this->date - 25569 ) * 86400 );
    }

    public function getProductivityValueAttribute() {
        if ( is_null( $this->productivity ) ) {
            return 0;
        }

        return $this->productivity->productivity;
    }

    public function getInDebtValueAttribute() {
        if ( is_null( $this->productivity ) ) {
            return 0;
        }

        return $this->productivity->in_debt;
    }

    public function getTakeDebtValueAttribute() {
        if ( is_null( $this->productivity ) ) {
            return 0;
        }

        return $this->productivity->take_debt;
    }

    public function getProductivityBySalaryAttribute() {
        $return = $this->productivity_value;
        $return += $this->in_debt_value * .7;
        $return -= $this->take_debt_value * .7;
        $return *= $this->employee->percent;

        return $return;
    }

    public function getRatioBySalaryAttribute() {
        $return = 0;
        foreach ( $this->employee->toArray() as $productivity => $ratio ) {
            $productivity = trim( $productivity, '_' );
            if ( ! is_numeric( $productivity ) ) {
                continue;
            }
            if ( $this->productivity_by_salary > intval( $productivity ) * 1000 ) {
                $return = max( $return, $ratio );
            }
        }

        return $return;
    }

    public function getSalaryByProductivityAttribute() {
        return $this->productivity_by_salary * $this->ratio_by_salary;
    }

    public function salary() {
        return $this->belongsTo( \App\Salary::class );
    }

    public function employee() {
        return $this->belongsTo( \App\Employee::class, 'salary_id', 'salary_id' );
    }

    public function car() {
        return $this->belongsTo( \App\Car::class );
    }

    public function productivity() {
        return $this->belongsTo( \App\Productivity::class );
    }
}
