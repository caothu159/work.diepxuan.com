<?php

namespace App\Services;

use App\Car;
use App\Data;
use App\Presence;
use App\Salary;
use App\SalaryType;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\Shared\Date;

interface SalaryServiceInterface
{

    public function setTime($time);

    public function getTime();

    public function setName($name);

    public function getName();

    public function getTimeOptions();

    public function getUserOptions();

    public function getAll();
}
