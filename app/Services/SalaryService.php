<?php
/**
 * Copyright © DiepXuan, Ltd. All rights reserved.
 */

namespace App\Services;

use App\Data;
use App\Helpers\TimeHelper as TimeHelper;
use App\Salary;
use App\SalaryUser;
use PhpOffice\PhpSpreadsheet\Shared\Date;

/**
 * Class DatafileService.
 */
class SalaryService implements SalaryServiceInterface
{
    use TimeHelper;

    private $year;
    private $month;
    private $name;

    private $user;
    private $userLst = false;

    private $isSingle;

    private $filter;
    private $getAllCollection;

    /**
     * DatafileService constructor.
     *
     * @param Data $data
     */
    public function __construct()
    {
        $this->isSingle(false);
        $this->year = $this->year ?: date("Y");
        $this->month = $this->month ?: date("m");
        $this->filter = [
            "thang" => ["thang", "=", $this->month],
            "nam" => ["nam", "=", $this->year],
        ];
    }

    public function isSingle($isSingle = null)
    {
        if (null != $isSingle && "boolean" == gettype($isSingle)) {
            $this->isSingle = $isSingle;
        }

        return $this->isSingle;
    }

    public function setTime($time)
    {
        $time = trim($time);
        $time = $time ?: $this->getTime();
        $time = explode("-", $time);
        $time = array_replace([$this->month, $this->year], $time);
        $this->year = $time[1];
        $this->month = $time[0];

        $this->filter["thang"] = ["thang", "=", $this->month];
        $this->filter["nam"] = ["nam", "=", $this->year];

        return $this;
    }

    public function getTime()
    {
        return $this->timeformat($this->month, $this->year);
    }

    public function setName($name)
    {
        $name = trim($name);
        $this->name = $name ? $name : false;

        if ($this->name) {
            $this->filter["ten"] = ["ten", "$this->name"];
            $this->isSingle(true);
        }

        return $this;
    }

    public function getName()
    {
        return [
            $this->isSingle() => $this->name,
            !$this->isSingle => null,
        ][$this->isSingle()];
    }

    public function getFullName()
    {
        return [
            $this->isSingle() => ucwords(strtolower($this->getName())),
            !$this->isSingle => null,
        ][$this->isSingle()];
    }

    public function getTimeOptions()
    {
        return $this->getMonths();
        // return Salary::orderBy('nam', 'desc')
        //     ->orderBy('thang', 'desc')
        //     ->groupBy('thang', 'nam')
        //     ->select('thang', 'nam')
        //     ->get();
    }

    public function getUserOptions($render = false)
    {
        if (!$render && !$this->userLst) {
            return $this->getUserOptions(true);
        }
        if (!$render) {
            return $this->userLst;
        }
        $filter = $this->filter;
        $filter["ten1"] = ["ten", "<>", "*"];
        $filter["ten2"] = ["ten", "<>", "duc"];
        unset($filter["ten"]);

        $this->userLst = SalaryUser::groupBy("ten")
            ->orderBy("ten", "ASC")
            ->where(array_values($filter))
            ->get();

        // \Debugbar::info($this->userLst);

        return $this->userLst;
    }

    public function getUser(string $name = null)
    {
        if ($this->user) {
            return $this->user;
        }

        $name = $name ?: $this->getName();
        if ($name) {
            $this->user = SalaryUser::orderBy("nam", "DESC")
                ->orderBy("thang", "DESC")
                ->orderBy("ten", "ASC")
                ->where(
                    array_values([
                        "thang" => ["thang", "<=", $this->month],
                        "nam" => ["nam", "<=", $this->year],
                        "ten" => ["ten", "=", $name],
                    ])
                )
                ->first();
            if ($this->user) {
                return $this->user;
            }

            $user = new SalaryUser([
                "thang" => $this->month,
                "nam" => $this->year,
                "ten" => $name,
            ]);

            \Debugbar::info($user);

            return $user;
        }

        return new SalaryUser([
            "thang" => $this->month,
            "nam" => $this->year,
            "ten" => $this->getName(),
        ]);
    }

    public function getAll()
    {
        if ($this->getAllCollection) {
            return $this->getAllCollection;
        }
        $filter = $this->filter;
        $this->getAllCollection = Salary::orderBy("nam", "DESC")
            ->orderBy("thang", "DESC")
            ->orderBy("ngay", "ASC")
            ->orderBy("diadiem", "ASC")
            ->orderBy("ten", "ASC")
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
