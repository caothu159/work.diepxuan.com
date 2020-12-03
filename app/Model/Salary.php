<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

namespace App\Model;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\Str;

class Salary extends Eloquent
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nam',
        'thang',
        'ngay',

        'ten',
        'luongcoban',
        'baohiem',
        'chitieu',
        'heso',
        'tile',

        'chamcong',
        'diadiem',
        'doanhso',
        'chono',
        'thuno',
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

    public function getThoigianAttribute()
    {
        $thoigian = array(
            $this->ngay,
            $this->thang,
            $this->nam
        );
        $thoigian = implode('/', $thoigian);
        return $thoigian;
    }
}
