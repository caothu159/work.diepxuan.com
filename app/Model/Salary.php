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
     * @var mixed
     */
    private $_chitieu = null;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'month',
        'year',

        'name',

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
    public function presences()
    {
        return $this->hasMany(\App\Presence::class);
    }

    /**
     * @return mixed
     */
    public function types()
    {
        return $this->hasMany(\App\SalaryType::class);
    }

    /**
     * @return mixed
     */
    public function user()
    {
        return $this->belongsTo(\App\User::class, 'salary_name', 'name');
    }

    /**
     * @return int
     */
    public function getChitieuAttribute()
    {
        if (null != $this->_chitieu) {
            return $this->_chitieu;
        }
        $this->_chitieu = 0;
        foreach ($this->types as $type) {
            if (!Str::contains($type->name, 'Chi tieu')) {
                continue;
            }
            $this->_chitieu = $type->value;
        }

        return $this->_chitieu;
    }

    /**
     * @return mixed
     */
    public function getNameAttribute()
    {
        if (!$this->user) {
            return $this->attributes['name'];
        }

        return $this->user->name;
    }

    /**
     * @return float|mixed
     */
    public function ratioInitial()
    {
        return 0.01;

        $ratio             = 0;
        $types             = $this->types;
        $productivityTotal = $this->presences->sum('productivity');
        $productivityTotal /= 30;
        foreach ($types as $type) {
            if (!is_numeric($type->name)) {
                continue;
            }
            if ($productivityTotal <= doubleval($type->name) * 1000) {
                continue;
            }
            $ratio = max($ratio, $type->value);
        }

        return doubleval($ratio);
    }

    public function getWeekstartAttribute()
    {
        return date('w', ($this->month - 25569) * 86400);
    }

    /**
     * Luong co ban chia trung binh theo ngay
     *
     * @return int
     */
    public function getPresenceSalaryAttribute()
    {
        $presenceSalary = $this->types->where('name', 'Luong co ban')->first();
        $presenceSalary = $presenceSalary ? $presenceSalary->value : 0;
        $presenceSalary /= 30;

        return $presenceSalary;
    }

    /**
     * Luong kho bai chia trung binh theo ngay
     *
     * @return int
     */
    public function getKhobaiAttribute()
    {
        $presenceSalary = $this->types->where('name', 'Luong kho')->first();
        $presenceSalary = $presenceSalary ? $presenceSalary->value : 0;
        $presenceSalary /= 30;

        return $presenceSalary;
    }
}
