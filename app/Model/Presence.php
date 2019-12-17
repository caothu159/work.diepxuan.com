<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

namespace App\Model;

//use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Model as Eloquent;

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
     * @return float|mixed - He so luong
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

    /**
     * @return float|int - Chia ty le khi bat cap
     */
    public function percentInitial() {
        /** khong tinh ti le cho nhan vien van phong */
        if ( 0 == $this->salary_count ) {
            return 0;
        }

        /** @var float $percent - Ti le chia luong mac dinh voi lai xe khac */
        $percent = 1 / $this->salary_count;

        /** @var float $_percent - Ti le chia luong quy dinh tai cot ti le */
        $_percent = $this->salary->types->where( 'name', 'Ti le' )->first();
        $_percent = $_percent ? $_percent->value : 0;

        $percent = $_percent ?: $percent;

        return $percent;

        $batCap = $this->salary->types->where( 'name', 'Bat cap' )->first();

        /** khong co bat cap */
        if ( ! $batCap ) {
            return $percent;
        }

//        if ( $this->salary->name == 'Hong' ) {
//            dd( $_percent, $this );
//        }

//        $_batCap = $_batCap->value;
//        $_batCap = explode( '|', $_batCap );
//        $_batCap = is_array( $_batCap ) ? $_batCap : array();
//        $_batCap = array_filter( $_batCap );
//        foreach ( $_batCap as $_bc ) {
//            $bc = explode( ':', $_bc );
//            $bc = is_array( $bc ) ? $bc : array();
//            $bc = array_filter( $bc );
//
//            /**
//             * khong co bat cap
//             */
//            if ( sizeof( $bc ) != 2 ) {
//                continue;
//            }
//
//            $sName    = $bc[0];
//            $sPercent = $bc[1];
//
//            $_salary = \App\Salary::where( [
//                'name'  => $sName,
//                'month' => $this->salary->month,
//            ] )->firstOrFail();
//
//            /** khong co bat cap */
//            if ( ! $_salary ) {
//                continue;
//            }
//
//            $_presence = \App\Presence::where( [
//                'date'         => $this->date,
//                'car_id'       => $this->car->id,
//                'salary_count' => 2,
//                'salary_id'    => $_salary->id,
//            ] )->firstOrFail();
//
//            /** bat cap sai nguoi */
//            if ( ! $_presence ) {
//                continue;
//            }
//
//            $_presence->percent = 1 - $sPercent;
//            $_presence->save();
//            $this->percent = $sPercent;
//        }

    }

    public function getWeekAttribute() {
        return date( 'w', ( $this->date - 25569 ) * 86400 );
    }

    /**
     * @return float Doanh so lai xe
     */
    public function getProductivityAttribute() {
        $productivity = $this->turnover;
        $productivity += $this->in_debt * 0.7;
        $productivity -= $this->take_debt * 0.7;
        $productivity *= $this->percentInitial();

        return $productivity;
    }

    /**
     * @return float Chi tieu lai xe
     */
    public function getChitieuAttribute() {
        return $this->salary->chitieu / 30;
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
