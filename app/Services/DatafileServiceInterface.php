<?php
namespace App\Services;

interface DatafileServiceInterface
{
    public function salaryImport(string $year, string $month);
    public function employeeImport(string $year, string $month);
    public function presenceImport(string $year, string $month);
    public function divisionImport(string $year, string $month);
    public function productivityImport(string $year, string $month);
}
