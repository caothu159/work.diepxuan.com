<?php

namespace App\Services;

use Illuminate\Support\Str;

/**
 * Class DatafileService
 * @package App\Services
 */
class DatafileService implements DatafileServiceInterface {
    /**
     * Import Data from cloud to database.
     *
     * @param string $year
     * @param string $month
     *
     * @return void
     * @throws \Exception
     */
    public function salaryImport( string $year, string $month ) {
        die( 'import' );
        $this->employeeImport( $year, $month );
        $this->presenceImport( $year, $month );
        $this->divisionImport( $year, $month );
        $this->productivityImport( $year, $month );
        $this->serializeImport( $year, $month );
    }

    /**
     * Import Data from nhanvien.xlsx to database.
     * quy dinh cach tinh luong tung nhan vien theo thang
     *
     * @param string $year
     * @param string $month
     *
     * @return void
     * @throws \Exception
     */
    public function employeeImport( string $year, string $month ) {
        $data = new \App\Data( $year, $month );

        $month = sprintf( '%s-%s', $year, $month );
        $month = new \DateTime( $month );
        $month = $month->getTimestamp() / ( 24 * 60 * 60 ) + 25569;

        foreach ( $data->loadFromFile( 'nhanvien.xlsx' ) as $name => $val ) {
            /**
             * Bang luong nhan vien hang thang
             */
            $salary = \App\Salary::firstOrCreate( [
                'name'  => $name,
                'month' => $month,
            ], [] );

            foreach ( $val as $type => $value ) {
                \App\SalaryType::updateOrCreate( [
                    'salary_id' => $salary->id,
                    'name'      => "$type",
                ], [
                    'value' => floatval( $value ),
                ] );
            }
        }
    }

    /**
     * Import Data from chamcong.xlsx to database.
     * Bang cham cong tung nhan vien theo ngay
     *
     * @param string $year
     * @param string $month
     *
     * @return void
     * @throws \Exception
     */
    public function presenceImport( string $year, string $month ) {
        $data = new \App\Data( $year, $month );

        /* lap tung ngay */
        foreach ( $data->loadFromFile( 'chamcong.xlsx' ) as $date => $val ) {
            $month = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp( $date );
            $month = date( "Y-m", $month );
            $month = new \DateTime( $month );
            $month = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel( $month );
            $month = intval( $month );

            foreach ( $val as $name => $presence ) {
                $salary = \App\Salary::where( 'name', $name )->where( 'month', $month )->first();

                $presenceSalary = $salary->types->where( 'name', 'Luong co ban' )->first();
                $presenceSalary = $presenceSalary ? $presenceSalary->value : 0;
                $presenceSalary = $presenceSalary;
                $presenceSalary /= 30;
                $presenceSalary *= $presence;

                /**
                 * cham cong nhat tung nhan vien
                 */
                \App\Presence::updateOrCreate( [
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
     * @param string $year
     * @param string $month
     *
     * @return void
     * @throws \Exception
     */
    public function divisionImport( string $year, string $month ) {
        $data = new \App\Data( $year, $month );

        /* lap tung ngay */
        foreach ( $data->loadFromFile( 'phancong.xlsx' ) as $date => $division ) {
            if ( 0 == $date ) {
                continue;
            }

            $month = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp( $date );
            $month = date( "Y-m", $month );
            $month = new \DateTime( $month );
            $month = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel( $month );
            $month = intval( $month );

            /* lap tung xe */
            foreach ( $division as $car_id => $salary_ids ) {
                if ( $car_id === 0 ) {
                    continue;
                }

                $car_id = str_replace( 'x', '', $car_id );
                $car    = \App\Car::firstOrCreate( [ 'name' => $car_id ] );

                if ( 0 === $salary_ids ) {
                    continue;
                }

                $salary_ids = explode( '-', $salary_ids );

                /**
                 *  loop tung lai xe
                 */
                foreach ( $salary_ids as $salary_id ) {
                    $salary = \App\Salary::where( 'name', $salary_id )
                                         ->where( 'month', $month )->first();

                    if ( null == $salary ) {
                        continue;
                    }

                    /**
                     * phan cong tung nhan vien lai xe | ban hang | kho bai
                     */
                    $presence = \App\Presence::updateOrCreate( [
                        'salary_id' => $salary->id,
                        'date'      => $date,
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
     * @throws \Exception
     */
    public function productivityImport( string $year, string $month ) {
        $data = new \App\Data( $year, $month );
        $cars = \App\Car::all();

        foreach ( $data->loadFromFile( 'nangsuat.xlsx' ) as $date => $val ) {
            $val['date'] = $date;

            foreach ( $cars as $car ) {
                if ( $car->name == "kho" ) {
                    continue;
                }

                /**
                 * Bang cham nang suat tung  xe
                 */
                \App\Presence::where( [
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
     * @throws \Exception
     */
    public function serializeImport( string $year, string $month ) {
        $dt = sprintf( '%s-%s', $year, $month );

        $timefrom = date( "Y-m-01", strtotime( $dt ) );
        $timefrom = new \DateTime( $timefrom );
        $timefrom = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel( $timefrom );

        $timeto = date( "Y-m-t", strtotime( $dt ) );
        $timeto = new \DateTime( $timeto );
        $timeto = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel( $timeto );

        foreach ( \App\Presence::whereBetween( 'date', [ $timefrom, $timeto ] )->get() as $presence ) {
            $presence->percent             = null;
            $presence->productivity        = null;
            $presence->ratio               = null;
            $presence->productivity_salary = null;

            /** khong di xe hoac khong lam kho */
            if ( ! $presence->car ) {
                $presence->save();
                continue;
            }

            /** lam o kho */
            if ( $presence->car->name == 'kho' ) {
                foreach ( $presence->salary->types as $type ) {
                    if ( ! Str::contains( $type->name, 'Luong kho' ) ) {
                        continue;
                    }
                    $presence->productivity_salary = $presence->presence * $type->value / 30;
                    $presence->save();
                }
            }

            /** khong phat sinh doanh so */
            if ( $presence->turnover <= 0 ) {
                $presence->save();
                continue;
            }

            /**
             * Ti le chia luong voi lai xe khac
             */
            if ( $presence->salary_count > 0 ) {
                $presence->percent = 1 / $presence->salary_count;
            }
            $percent = $presence->salary->types
                ->reject( function ( $type ) {
                    return ( ! Str::contains( $type->name, 'Ti le' ) )
                           || $type->value == 0;
                } )->first();
            if ( $percent ) {
                $presence->percent = $percent->value;
            }

            /**
             * Nang suat lai xe
             */
            $presence->productivity = floatval( $presence->turnover ) * floatval( $presence->percent );

            /**
             * He so luong
             */
            $presence->ratio = $presence->ratioInitial();

            /**
             * Luong
             */
            $presence->productivity_salary = $presence->productivity * $presence->ratio;

            $presence->save();
        }

        $month = sprintf( '%s-%s', $year, $month );
        $month = new \DateTime( $month );
        $month = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel( $month );
        $month = intval( $month );
        foreach ( \App\Salary::where( [ 'month' => $month ] )->get() as $salary ) {
            /**
             * Cham cong
             */
            $salary->presence = $salary->presences->sum( 'presence' );

            /**
             * Luong cong nhat
             */
            $salary->salary_default = $salary->presences->sum( 'presence_salary' );

            /**
             * Tong nang suat trong thang
             */
            $salary->turnover = $salary->presences->sum( 'turnover' );

            /**
             * Luong nang suat
             */
            $salary->productivity = $salary->presences->sum( 'productivity_salary' );

            /**
             * Luong
             */
            $salary->salary = $salary->salary_default + $salary->productivity;

            $salary->save();
        }

        /**
         * clean all presence where date not in month
         */
        foreach ( \App\Presence::get() as $presence ) {
            $month = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp( $presence->date );
            $month = date( "Y-m", $month );
            $month = new \DateTime( $month );
            $month = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel( $month );
            $month = intval( $month );
            if ( $presence->salary->month !== $month ) {
                $presence->delete();
            }
        }

    }
}
