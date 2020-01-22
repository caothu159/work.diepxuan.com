<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */
namespace App\Model\Salary;

//use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Model as Eloquent;

class Sheet extends Eloquent
{
    // application/vnd.openxmlformats-officedocument.spreadsheetml.sheet

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'name'        => '',
        'ContentType' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
    ];

    /**
     * @param $name
     * @param $year
     * @param null $month
     */
    public function __construct($name, $year = null, $month = null)
    {
        $this->name  = $name;
        $this->year  = $year;
        $this->month = $month;
    }

    /**
     * [download description]
     * @return [type] [description]
     */
    public function download()
    {
        $file = $this->datapath($this->name);
        if (!file_exists($file)) {
            return '';
        }

        $headers = [
            'Content-Type' => $this->ContentType,
        ];

        return response()->download($file, $this->name, $headers);
    }

    /**
     * Get data file path.
     *
     * @param string $file
     *
     * @return string
     */
    private function datapath(string $file)
    {
        return $this->datadir() . $file;
    }

    /**
     * Get data directory path.
     *
     * @param string $year
     * @param string $month
     *
     * @return string
     */
    private function datadir(string $year = null, string $month = null)
    {
        return config('salary.datadir')
        . $this->year . DIRECTORY_SEPARATOR
        . $this->month . DIRECTORY_SEPARATOR;
    }

    /**
     * @return mixed
     */
    public function getMonthAttribute()
    {
        return $this->attributes['month'];
    }

    /**
     * @return mixed
     */
    public function getNameAttribute()
    {
        return $this->attributes['name'];
    }

    /**
     * @return mixed
     */
    public function getYearAttribute()
    {
        return $this->attributes['year'];
    }

    /**
     * @param mixed $value
     *
     * @return self
     */
    public function setMonthAttribute($value)
    {
        $this->attributes['month'] = $value;

        return $this;
    }

    /**
     * @param mixed $value
     *
     * @return self
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;

        return $this;
    }

    /**
     * @param mixed $value
     *
     * @return self
     */
    public function setYearAttribute($value)
    {
        $this->attributes['year'] = $value;

        return $this;
    }
}
