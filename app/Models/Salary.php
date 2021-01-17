<?php
/**
 * Copyright © DiepXuan, Ltd. All rights reserved.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    use HasFactory;

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
        'chamcong',
        'diadiem',
        'doanhso',
        'chono',
        'thuno',
        'tile',
    ];

    /**
     * Make attributes available in the json response.
     *
     * @var array
     */
    protected $appends = [
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;
}
