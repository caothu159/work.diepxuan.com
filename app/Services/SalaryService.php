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
     * @var mixed
     */
    private $year;
    /**
     * @var mixed
     */
    private $month;

    /**
     * @var mixed
     */
    private $timemonth;

    /**
     * @var mixed
     */
    private $timestart;
    /**
     * @var mixed
     */
    private $timeend;

    /**
     * DatafileService constructor.
     *
     * @param Data $data
     */
    public function __construct()
    {
    }

    /**
     * Import Data from cloud to database.
     *
     * @param string $year
     * @param string $month
     *
     * @return void
     * @throws Exception
     */
    public function salaryImport(string $year, string $month)
    {
        $this->_initialize($year, $month);

        $this->beforeImport();
        $this->startImport();
        $this->serializeImport();
    }

    /**
     * @param string $year
     * @param string $month
     *
     * @throws Exception
     */
    private function _initialize(string $year, string $month)
    {
        $this->year  = $year;
        $this->month = $month;
        $this->data->initialize($year, $month);

        $dt = sprintf('%s-%s', $this->year, $this->month);

        $this->timestart = date("Y-m-01", strtotime($dt));
        $this->timestart = new \DateTime($this->timestart);
        $this->timestart = Date::PHPToExcel($this->timestart);

        $this->timeend = date("Y-m-t", strtotime($dt));
        $this->timeend = new \DateTime($this->timeend);
        $this->timeend = Date::PHPToExcel($this->timeend);

        $this->timemonth = new \DateTime($dt);
        $this->timemonth = Date::PHPToExcel($this->timemonth);
    }

    /**
     * xoa du lieu cu
     *
     * @throws Exception
     */
    protected function beforeImport()
    {
        Presence::whereBetween('date', [$this->timestart, $this->timeend])->forceDelete();
        SalaryType::leftJoin('salaries', 'salary_types.salary_id', '=', 'salaries.id')
            ->where('salaries.month', '=', $this->timemonth)
            ->delete();
        Salary::where('month', $this->timemonth)->forceDelete();
    }

    /**
     * Import du lieu tu stylesheet
     *
     * @throws Exception
     */
    protected function startImport()
    {
        $this->employeeImport();
        $this->presenceImport();
        $this->divisionImport();
        $this->productivityImport();
    }

    /**
     * Serialize Salary
     * Tinh luong
     *
     * @throws Exception
     */
    public function serializeImport()
    {
        /** @var Presence $presence - tinh luong hang ngay */
        Presence::whereBetween('date', [$this->timestart, $this->timeend])->get()->each(function ($presence) {
            /** khong di xe hoac khong lam kho */
            if (!$presence->car) {
                /** @var zero presence - Thuong 1 ngay chi tieu */
//                $presence->presence = 0;
                //                $presence->save();

                return;
            }

            /** lam o kho - chi tinh luong kho, huy cong nhat */
            if ('kho' == $presence->car->name) {

                /** @var float ratio - He so luong */
                $presence->ratio = 1;

                /** @var float presence_salary - luong kho bai hang ngay */
                $presence->presence_salary = $presence->presence * $presence->salary->khobai;

                $presence->productivity_salary = 0;
                $presence->save();

                return;

            }/** Khong ap chi tieu */
            elseif (0 == $presence->salary->chitieu) {

                /** @var float ratio - He so luong */
                $presence->ratio = $presence->ratioInitial();

                /** @var float productivity_salary - luong doanh so hang ngay */
                $presence->productivity_salary = $presence->productivity * $presence->ratio;

                $presence->save();

                return;

            }/** Ap chi tieu */
            else {

                /** @var float ratio - He so luong */
                $presence->ratio = $presence->ratioInitial();

                /** @var float productivity_salary - luong bu tru chenh lech chi tieu hang ngay */
                $presence->productivity_salary = $presence->productivity - $presence->chitieu;
                $presence->productivity_salary *= $presence->ratio;

                $presence->save();

                return;
            }
        });

        Salary::where(['month' => $this->timemonth])->get()->each(function ($salary) {
            /** Cham cong */
            $salary->presence = $salary->presences->sum('presence');

            /** Tong doanh so trong thang */
            $salary->turnover = $salary->presences->sum('productivity');

            /** @var float salary_default - luong cong nhat */
            $salary->salary_default = $salary->presences->sum('presence_salary');

            /** @var float productivity - Luong doanh so */
            $salary->productivity = $salary->presences->sum('productivity_salary');

            /** @var float salary - Luong */
            $salary->salary = $salary->salary_default + $salary->productivity;

            $salary->save();
        });

    }

    /**
     * Import Data from nhanvien.xlsx to database.
     * quy dinh cach tinh luong tung nhan vien theo thang
     *
     * @return void
     * @throws Exception
     */
    protected function employeeImport()
    {
        foreach ($this->data->loadFromFile('nhanvien.xlsx') as $name => $val) {
            /**
             * Bang luong nhan vien hang thang
             */
            $salary = Salary::firstOrCreate([
                'name'  => $name,
                'month' => $this->timemonth,
            ], []);

            foreach ($val as $type => $value) {
                SalaryType::updateOrCreate([
                    'salary_id' => $salary->id,
                    'name'      => "$type",
                ], [
                    'value' => $value,
                ]);
            }
        }
    }

    /**
     * Import Data from chamcong.xlsx to database.
     * Bang cham cong tung nhan vien theo ngay
     *
     * @return void
     * @throws Exception
     */
    protected function presenceImport()
    {
        $salaries = Salary::where('month', $this->timemonth)->get();

        foreach ($this->data->loadFromFile('chamcong.xlsx') as $date => $val) {
            if (0 == $date || $date < $this->timestart || $date > $this->timeend) {
                continue;
            }

            foreach ($val as $name => $presence) {
                $salary = $salaries->where('name', $name)->first();
                if (null == $salary) {
                    continue;
                }

                $presenceSalary = $salary->presenceSalary * $presence;

                /**
                 * cham luong cong nhat tung nhan vien
                 */
                Presence::updateOrCreate([
                    'salary_id' => $salary->id,
                    'date'      => $date,
                ], [
                    'presence'        => floatval($presence),
                    'presence_salary' => $presenceSalary,
                ]);
            }
        }

    }

    /**
     * Import Data from phancong.xlsx to database.
     * Bang phan cong lai xe | ban hang | kho bai
     *
     * @return void
     * @throws Exception
     */
    protected function divisionImport()
    {
        foreach ($this->data->loadFromFile('phancong.xlsx') as $date => $division) {
            if (0 == $date || $date < $this->timestart || $date > $this->timeend) {
                continue;
            }

            /* lap tung xe */
            foreach ($division as $car_id => $salary_ids) {
                if ($car_id === 0) {
                    continue;
                }

                $car_id = str_replace('x', '', $car_id);
                $car    = Car::firstOrCreate(['name' => $car_id]);

                if (0 === $salary_ids || empty($salary_ids)) {
                    continue;
                }

                $salary_ids = explode('-', $salary_ids);

                /**
                 *  loop tung lai xe
                 */
                foreach ($salary_ids as $salary_id) {

                    $salary = Salary::where('name', $salary_id)
                        ->where('month', $this->timemonth)->first();

                    if (null == $salary) {
                        continue;
                    }

                    /**
                     * phan cong tung nhan vien lai xe | ban hang | kho bai
                     */
                    Presence::updateOrCreate([
                        'salary_id' => $salary->id,
                        'date'      => $date,
                        'car_id'    => null,
                    ], [
                        'car_id'       => $car->id,
                        'salary_count' => count($salary_ids),
                    ]);
                }
            }
        }

    }

    /**
     * Import Data from nangsuat.xlsx to database.
     * Bang cham nang suat tung lai xe
     *
     * @return void
     * @throws Exception
     */
    protected function productivityImport()
    {
        $cars = Car::all();

        foreach ($this->data->loadFromFile('nangsuat.xlsx') as $date => $val) {
            $val['date'] = $date;

            foreach ($cars as $car) {
                if ($car->name == "kho") {
                    continue;
                }

                /**
                 * Bang cham nang suat tung  xe
                 */
                Presence::where([
                    'date'   => $date,
                    'car_id' => $car->id,
                ])->update([
                    'turnover'  => doubleval($val["ns $car->name"]),
                    'in_debt'   => doubleval($val["no $car->name"]),
                    'take_debt' => doubleval($val["thu no $car->name"]),
                ]);

            }
        }

    }

    /**
     * xoa du lieu cu
     *
     * @throws Exception
     * @deprecated from 17/12/2019
     */
    protected function salaryClean()
    {
        Salary::where('month', $this->timemonth)->each(function ($salary) {
            $salary->types()->delete();
            $salary->presences()->delete();
        });
    }

    /**
     * @deprecated from 17/12/2019
     */
    private function presenceClean()
    {
        /** clean all presence where date not in month */
        DB::table('presences')
            ->join('salaries', 'presences.salary_id', '=', 'salaries.id')
            ->where('salaries.month', '=', $this->timemonth)
            ->whereNotBetween('presences.date', [$this->timestart, $this->timeend])
            ->delete();
    }
}