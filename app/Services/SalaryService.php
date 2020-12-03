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

/**
 * Class DatafileService
 * @package App\Services
 */
class SalaryService
{

    /**
     * DatafileService constructor.
     *
     * @param Data $data
     */
    public function __construct()
    {
    }

    public function getTimeOptions()
    {
        return Salary::orderBy('nam', 'desc')
            ->orderBy('thang', 'desc')
            ->groupBy('thang', 'nam')
            ->select('thang', 'nam')
            ->get();
    }

    public function getAll()
    {
        return Salary::orderBy('created_at', 'asc')->get();
    }
}
