<?php

namespace App\Services;

use App\Car;
use App\Data;
use App\SalaryUser;
use App\Presence;
use App\Salary;
use App\SalaryType;
use Exception;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Illuminate\Support\Collection;

/**
 * Class DatafileService.
 */
class DatafileService
{
    /**
     * @var mixed
     */
    private $data;

    /**
     * @var mixed
     */
    private $year;

    /**
     * @var mixed
     */
    private $month;

    private $salaryUpsert;
    private $salaryUserUpsert;

    private $salaryDefault;

    /**
     * DatafileService constructor.
     */
    public function __construct(Data $data)
    {
        $this->data = $data;
        $this->salaryUpsert = collect();
        $this->salaryUserUpsert = collect();
        $this->salaryDefault = [
            'ngay' => null,
            'thang' => null,
            'nam' => null,
            'ten' => null,

            'chamcong' => null,
            'tile' => null,
            'diadiem' => null,
            'doanhso' => null,
            'chono' => null,
            'thuno' => null,
        ];
    }

    /**
     * @throws Exception
     */
    private function __initialize(string $year, string $month)
    {
        $this->year = $year;
        $this->month = sprintf("%02d", $month);
        $this->data->initialize($this->year, $this->month);
    }

    /**
     * Import Data from cloud to database.
     *
     * @throws Exception
     */
    public function salaryImport(string $year, string $month)
    {
        $this->__initialize($year, $month);

        $this->_employeeImport();
        $this->_presenceImport();
        $this->_divisionImport();
        $this->_productivityImport();
        $this->saveImport();
    }

    /**
     * Import Data from nhanvien.xlsx to database.
     * quy dinh cach tinh luong tung nhan vien theo thang.
     *
     * @throws Exception
     */
    protected function _employeeImport()
    {
        foreach ($this->data->loadFromFile('nhanvien.xlsx') as $name => $val) {

            $val = array_replace([
                'Luong co ban' => null,
                'Bao Hiem' => null,
                'Chi tieu' => null,
                0 => null,
                'Ti le' => null,
            ], $val);
            $salaryUser = [
                'thang' => $this->month,
                'nam' => $this->year,
                'ten' => $name,

                'luongcoban' => $val['Luong co ban'],
                'baohiem' => $val['Bao Hiem'],
                'chitieu' => $val['Chi tieu'],
                'heso' => $val[0],
                'tile' => $val['Ti le'],
            ];
            $this->salaryUserUpsert->push($salaryUser);
        }
    }

    /**
     * Import Data from chamcong.xlsx to database.
     * Bang cham cong tung nhan vien theo ngay.
     *
     * @throws Exception
     */
    protected function _presenceImport()
    {
        foreach ($this->data->loadFromFile('chamcong.xlsx') as $date => $val) {
            if (0 == $date) {
                continue;
            }

            $day = Date::excelToDateTimeObject($date)->format('d');

            foreach ($val as $name => $presence) {
                $salary = array_replace($this->salaryDefault, [
                    'ngay' => $day,
                    'thang' => $this->month,
                    'nam' => $this->year,
                    'ten' => $name,

                    'chamcong' => $presence,
                ]);
                $this->salaryUpsert->push($salary);
            }
        }
    }

    /**
     * Import Data from phancong.xlsx to database.
     * Bang phan cong lai xe | ban hang | kho bai.
     *
     * @throws Exception
     */
    protected function _divisionImport()
    {
        foreach ($this->data->loadFromFile('phancong.xlsx') as $date => $division) {
            if (0 == $date) {
                continue;
            }

            $day = Date::excelToDateTimeObject($date)->format('d');

            // lap tung xe
            foreach ($division as $car_id => $salary_ids) {
                if (0 === $car_id) {
                    continue;
                }

                if (0 === $salary_ids || empty($salary_ids)) {
                    continue;
                }

                $car_id = str_replace('x', '', $car_id);
                $salary_ids = explode('-', $salary_ids);

                // loop tung lai xe
                foreach ($salary_ids as $name) {

                    $salary =  [
                        'ngay' => $day,
                        'thang' => $this->month,
                        'nam' => $this->year,
                        'ten' => $name,

                        'tile' => 1 / count($salary_ids),
                        'diadiem' => $car_id,
                    ];

                    if ($this->salaryUpsert
                        ->where('ngay', $day)
                        ->where('thang', $this->month)
                        ->where('nam', $this->year)
                        ->where('ten', $name)
                        ->count()
                    ) {
                        $this->salaryUpsert
                            ->where('ngay', $day)
                            ->where('thang', $this->month)
                            ->where('nam', $this->year)
                            ->where('ten', $name)
                            ->map(function ($item, $key) use ($salary) {
                                $item = array_replace($item, $salary);
                                $this->salaryUpsert->put($key, $item);
                                return $item;
                            });
                    } else {
                        $this->salaryUpsert->push(array_replace($this->salaryDefault, $salary));
                    }
                }
            }
        }
        // dd($this->salaryUpsert);
    }

    /**
     * Import Data from nangsuat.xlsx to database.
     * Bang cham nang suat tung lai xe.
     *
     * @throws Exception
     */
    protected function _productivityImport()
    {
        $cars = collect();

        foreach ($this->data->loadFromFile('nangsuat.xlsx') as $date => $val) {
            $day = Date::excelToDateTimeObject($date)->format('d');

            collect($val)->map(function ($item, $key) use ($cars) {
                if (preg_match('/(\w+\s)+([0-9]+)/', $key, $matches)) {
                    $name = $matches[2];
                    if ($cars->search(function ($item) use ($name) {
                        return $item['name'] == $name;
                    }) === false) {
                        $cars->put($name, ['name' => $name]);
                    }
                }
            });

            foreach ($cars as $carname => $car) {
                $salary =  [
                    'ngay' => $day,
                    'thang' => $this->month,
                    'nam' => $this->year,
                    'diadiem' => $carname,

                    'doanhso' => doubleval($val["ns $carname"]),
                    'chono' => doubleval($val["no $carname"]),
                    'thuno' => doubleval($val["thu no $carname"]),
                ];

                if ($this->salaryUpsert
                    ->where('ngay', $day)
                    ->where('thang', $this->month)
                    ->where('nam', $this->year)
                    ->where('diadiem', $carname)
                    ->count()
                ) {
                    $this->salaryUpsert
                        ->where('ngay', $day)
                        ->where('thang', $this->month)
                        ->where('nam', $this->year)
                        ->where('diadiem', $carname)
                        ->map(function ($item, $key) use ($salary) {
                            $item = array_replace($item, $salary);
                            $this->salaryUpsert->put($key, $item);
                            return $item;
                        });
                } else {
                    $this->salaryUpsert->push(array_replace($this->salaryDefault, $salary));
                }
            }
        }
    }

    protected function saveImport()
    {
        SalaryUser::where([
            ['thang', $this->month],
            ['nam', $this->year],
        ])->delete();
        SalaryUser::upsert(array_values($this->salaryUserUpsert->all()), ['thang', 'nam', 'ten'], ['thang', 'nam', 'ten', 'luongcoban', 'baohiem', 'chitieu', 'heso', 'tile']);
        Salary::where([
            ['thang', $this->month],
            ['nam', $this->year],
        ])->delete();
        Salary::upsert(array_values($this->salaryUpsert->where('ten', '<>', null)->all()), ['ngay', 'thang', 'nam', 'ten'], ['chamcong', 'tile', 'diadiem', 'doanhso', 'chono', 'thuno']);
    }
}
