<?php
/**
 * Copyright © DiepXuan, Ltd. All rights reserved.
 */

namespace App\Services;

use App\Data;
use App\Salary;
use App\SalaryUser;
use PhpOffice\PhpSpreadsheet\Shared\Date;

/**
 * Class DatafileService.
 */
class SalaryService implements SalaryServiceInterface
{
    private $year;
    private $month;
    private $name;

    private $user;

    private $filter;
    private $getAllCollection;

    /**
     * DatafileService constructor.
     *
     * @param Data $data
     */
    public function __construct()
    {
        $this->year   = $this->year ?: date('Y');
        $this->month  = $this->month ?: date('m');
        $this->filter = [
            'thang' => ['thang', '=', $this->month],
            'nam'   => ['nam', '=', $this->year],
        ];
    }

    public function setTime($time)
    {
        $time        = trim($time);
        $time        = $time ?: $this->getTime();
        $time        = explode('-', $time);
        $time        = array_replace([$this->month, $this->year], $time);
        $this->year  = $time[1];
        $this->month = $time[0];

        $this->filter['thang'] = ['thang', '=', $this->month];
        $this->filter['nam']   = ['nam', '=', $this->year];

        return $this;
    }

    public function getTime()
    {
        return implode('-', [$this->month, $this->year]);
    }

    public function setName($name)
    {
        $name       = trim($name);
        $this->name = $name ? $name : false;

        if ($this->name) {
            $this->filter['ten'] = ['ten', "$this->name"];
        }

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getFullName()
    {
        return ucwords(strtolower($this->getName()));
    }

    public function getTimeOptions()
    {
        return Salary::orderBy('nam', 'desc')
            ->orderBy('thang', 'desc')
            ->groupBy('thang', 'nam')
            ->select('thang', 'nam')
            ->get();
    }

    public function getUserOptions()
    {
        $filter         = $this->filter;
        $filter['ten1'] = ['ten', '<>', '*'];
        $filter['ten2'] = ['ten', '<>', 'duc'];
        unset($filter['ten']);

        return SalaryUser::groupBy('ten')
            ->orderBy('ten', 'ASC')
            ->where(array_values($filter))
            ->get();
    }

    public function getUser(string $name = null)
    {
        if ($this->user) {
            return $this->user;
        }

        $name = $name ?: $this->getName();
        if ($name) {
            $this->user = SalaryUser::orderBy('nam', 'DESC')
                ->orderBy('thang', 'DESC')
                ->orderBy('ten', 'ASC')
                ->where(array_values([
                    'thang' => ['thang', '<=', $this->month],
                    'nam'   => ['nam', '<=', $this->year],
                    'ten'   => ['ten', '=', $name],
                ]))->first();
            if ($this->user) {
                return $this->user;
            }

            $user = new SalaryUser([
                'thang' => $this->month,
                'nam'   => $this->year,
                'ten'   => $name,
            ]);

            \Debugbar::info($user);

            return $user;
        }

        return new SalaryUser([
            'thang' => $this->month,
            'nam'   => $this->year,
            'ten'   => $this->getName(),
        ]);
    }

    public function getAll()
    {
        if ($this->getAllCollection) {
            return $this->getAllCollection;
        }
        $filter                 = $this->filter;
        $this->getAllCollection = Salary::orderBy('nam', 'DESC')
            ->orderBy('thang', 'DESC')
            ->orderBy('ngay', 'ASC')
            ->orderBy('diadiem', 'ASC')
            ->orderBy('ten', 'ASC')
            ->where(array_values($filter))
            ->get();

        return $this->getAllCollection;
    }

    public function getYear()
    {
        return $this->year;
    }

    public function getMonth()
    {
        return $this->month;
    }
}
