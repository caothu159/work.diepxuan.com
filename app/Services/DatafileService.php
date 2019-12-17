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

/**
 * Class DatafileService
 * @package App\Services
 */
class DatafileService {

    private $data;

    private $year;
    private $month;

    private $timemonth;
    private $timestart;
    private $timeend;

    private $nhanvien = [];
    private $chamcong = [];
    private $phancong = [];

    /**
     * DatafileService constructor.
     *
     * @param Data $data
     */
    public function __construct( Data $data ) {
        $this->data = $data;
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
    public function salaryImport( string $year, string $month ) {
        $this->_initialize( $year, $month );

        $this->salaryClean();
        $this->employeeImport();
        $this->presenceImport();
        $this->divisionImport();
        $this->productivityImport( $year, $month );
        $this->serializeImport( $year, $month );
    }

    private function _initialize( string $year, string $month ) {
        $this->year  = $year;
        $this->month = $month;
        $this->data->initialize( $year, $month );

        $dt = sprintf( '%s-%s', $this->year, $this->month );

        $this->timestart = date( "Y-m-01", strtotime( $dt ) );
        $this->timestart = new \DateTime( $this->timestart );
        $this->timestart = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel( $this->timestart );

        $this->timeend = date( "Y-m-t", strtotime( $dt ) );
        $this->timeend = new \DateTime( $this->timeend );
        $this->timeend = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel( $this->timeend );

        $this->timemonth = new \DateTime( $dt );
        $this->timemonth = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel( $this->timemonth );
    }

    /**
     * xoa du lieu cu
     *
     * @throws Exception
     */
    protected function salaryClean() {
        Presence::whereBetween( 'date', [ $this->timestart, $this->timeend ] )->forceDelete();
        SalaryType::leftJoin( 'salaries', 'salary_types.salary_id', '=', 'salaries.id' )
                  ->where( 'salaries.month', '=', $this->timemonth )
                  ->delete();
        Salary::where( 'month', $this->timemonth )->forceDelete();
    }

    /**
     * Import Data from nhanvien.xlsx to database.
     * quy dinh cach tinh luong tung nhan vien theo thang
     *
     * @return void
     * @throws Exception
     */
    public function employeeImport() {
        foreach ( $this->data->loadFromFile( 'nhanvien.xlsx' ) as $name => $val ) {
            /**
             * Bang luong nhan vien hang thang
             */
            $salary = Salary::firstOrCreate( [
                'name'  => $name,
                'month' => $this->timemonth,
            ], [] );

            foreach ( $val as $type => $value ) {
                SalaryType::updateOrCreate( [
                    'salary_id' => $salary->id,
                    'name'      => "$type",
                ], [
                    'value' => $value,
                ] );
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
    public function presenceImport() {
        $salaries = Salary::where( 'month', $this->timemonth )->get();

        foreach ( $this->data->loadFromFile( 'chamcong.xlsx' ) as $date => $val ) {
            if ( 0 == $date || $date < $this->timestart || $date > $this->timeend ) {
                continue;
            }

            foreach ( $val as $name => $presence ) {
                $salary = $salaries->where( 'name', $name )->first();
                if ( null == $salary ) {
                    continue;
                }

                $presenceSalary = $salary->presenceSalary * $presence;

                /**
                 * cham luong cong nhat tung nhan vien
                 */
                Presence::updateOrCreate( [
                    'salary_id' => $salary->id,
                    'date'      => $date,
                ], [
                    'presence'        => floatval( $presence ),
                    'presence_salary' => $presenceSalary,
                ] );
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
    public function divisionImport() {
        foreach ( $this->data->loadFromFile( 'phancong.xlsx' ) as $date => $division ) {
            if ( 0 == $date || $date < $this->timestart || $date > $this->timeend ) {
                continue;
            }

            /* lap tung xe */
            foreach ( $division as $car_id => $salary_ids ) {
                if ( $car_id === 0 ) {
                    continue;
                }

                $car_id = str_replace( 'x', '', $car_id );
                $car    = Car::firstOrCreate( [ 'name' => $car_id ] );

                if ( 0 === $salary_ids || empty( $salary_ids ) ) {
                    continue;
                }

                $salary_ids = explode( '-', $salary_ids );

                /**
                 *  loop tung lai xe
                 */
                foreach ( $salary_ids as $salary_id ) {

                    $salary = Salary::where( 'name', $salary_id )
                                    ->where( 'month', $this->timemonth )->first();

                    if ( null == $salary ) {
                        continue;
                    }

                    /**
                     * phan cong tung nhan vien lai xe | ban hang | kho bai
                     */
                    Presence::updateOrCreate( [
                        'salary_id' => $salary->id,
                        'date'      => $date,
                        'car_id'    => null,
                    ], [
                        'car_id'       => $car->id,
                        'salary_count' => count( $salary_ids ),
                    ] );
                }
            }
        }

    }

    /**
     * Import Data from nangsuat.xlsx to database.
     * Bang cham nang suat tung lai xe
     *
     * @param string $year
     * @param string $month
     *
     * @return void
     * @throws Exception
     */
    public function productivityImport( string $year, string $month ) {
        $cars = Car::all();

        foreach ( $this->data->loadFromFile( 'nangsuat.xlsx' ) as $date => $val ) {
            $val['date'] = $date;

            foreach ( $cars as $car ) {
                if ( $car->name == "kho" ) {
                    continue;
                }

                /**
                 * Bang cham nang suat tung  xe
                 */
                Presence::where( [
                    'date'   => $date,
                    'car_id' => $car->id,
                ] )->update( [
                    'turnover'  => doubleval( $val["ns $car->name"] ),
                    'in_debt'   => doubleval( $val["no $car->name"] ),
                    'take_debt' => doubleval( $val["thu no $car->name"] ),
                ] );

            }
        }

    }

    /**
     * Serialize Salary
     * Tinh luong
     *
     * @param string $year
     * @param string $month
     *
     * @throws Exception
     */
    public function serializeImport( string $year, string $month ) {
        /** @var Presence $presence */
        foreach ( Presence::whereBetween( 'date', [ $this->timestart, $this->timeend ] )->get() as $presence ) {
            $presence->percent             = null;
            $presence->productivity        = null;
            $presence->ratio               = null;
            $presence->productivity_salary = null;

            /** khong di xe hoac khong lam kho */
            if ( ! $presence->car ) {
                /** @var zero presence - Thuong 1 ngay chi tieu */
//                $presence->presence = 0;
                $presence->save();
                continue;
            }

            /** lam o kho */
            if ( $presence->car->name == 'kho' ) {
                /** @var float productivity_salary - luong kho bai hang ngay */
                $presence->productivity_salary = $presence->presence * $presence->salary->khobai;
                $presence->save();
                continue;
            }

            /** khong phat sinh doanh so */
            if ( 0 == $presence->productivity ) {
                $presence->save();
                continue;
            }

            /** Khong ap chi tieu */
            if ( $presence->salary->chitieu == 0 ) {

                /** @var float ratio - He so luong */
                $presence->ratio = $presence->ratioInitial();

                /** @var float productivity_salary - luong doanh so hang ngay */
                $presence->productivity_salary = $presence->productivity * $presence->ratio;

                $presence->save();
                continue;
            }

            $presence->save();
        }

        foreach ( Salary::where( [ 'month' => $this->timemonth ] )->get() as $salary ) {
            /** Cham cong */
            $salary->presence = $salary->presences->sum( 'presence' );

            /** Tong doanh so trong thang */
            $salary->turnover = $salary->presences->sum( 'productivity' );

            /** ============== Khong ap chi tieu ============== */
            if ( $salary->chitieu == 0 ) {

                /** @var float salary_default - luong cong nhat */
                $salary->salary_default = $salary->presences->sum( 'presence_salary' );

                /** @var float productivity - Luong doanh so */
                $salary->productivity = $salary->presences->sum( 'productivity_salary' );

                /** @var float salary - Luong */
                $salary->salary = $salary->salary_default + $salary->productivity;

            } else /** ============== Ap chi tieu ============== */ {

                /** @var float salary_default - doanh so dat chi tieu */
                $salary->salary_default = $salary->chitieu / 30 * min( 30, $salary->presence );

                /** @var float $tongDoanhSo - doanh so dat duoc */
                $tongDoanhSo = $salary->presences->sum( 'productivity' );

                /** @var float salary_default - luong bu tru chenh lech chi tieu */
                $salary->productivity = ( $tongDoanhSo - $salary->salary_default ) * $salary->ratioInitial();

                /** @var float $luongCoBan - Luong dat chi tieu */
                $luongCoBan = $salary->presenceSalary * $salary->presence;

                /** @var float salary - Luong */
                $salary->salary = $luongCoBan + $salary->productivity;
            }

            $salary->save();
        }

        /** clean all presence where date not in month */
        DB::table( 'presences' )
          ->join( 'salaries', 'presences.salary_id', '=', 'salaries.id' )
          ->where( 'salaries.month', '=', $month )
          ->whereNotBetween( 'presences.date', [ $this->timestart, $this->timeend ] )
          ->delete();

    }
}
