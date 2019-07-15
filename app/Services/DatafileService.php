<?php

namespace App\Services;

/**
 * Class DatafileService
 * @package App\Services
 */
class DatafileService implements DatafileServiceInterface {
    /**
     * Import Data from file to database.
     *
     * @param string $year
     * @param string $month
     *
     * @return void
     */
    public function salaryImport( string $year, string $month ) {
        $this->employeeImport( $year, $month );
        $this->presenceImport( $year, $month );
        $this->divisionImport( $year, $month );
        $this->productivityImport( $year, $month );
    }

    /**
     * Import Data from file to database.
     *
     * @param string $year
     * @param string $month
     *
     * @return void
     */
    public function employeeImport( string $year = null, string $month = null ) {
        $data = new \App\Data( $year, $month );

        $month = sprintf( '%s-%s', $year, $month );
        $month = new \DateTime( $month );
        $month = $month->getTimestamp() / ( 24 * 60 * 60 ) + 25569;

        foreach ( $data->loadFromFile( \App\Employee::DATAFILE ) as $name => $val ) {
            $salary = \App\Salary::firstOrCreate( [
                'name'  => $name,
                'month' => $month,
            ], [] );

            \App\Employee::updateOrCreate( [
                'salary_id' => $salary->id,
            ], [
                'default' => $val['Luong co ban'],
                '_0'      => $val['0'],
                '_13'     => $val['12.5'],
                '_20'     => $val['20'],
                '_30'     => $val['30'],
                '_40'     => $val['40'],
                '_50'     => $val['50'],
                '_60'     => $val['60'],
                '_70'     => $val['70'],
                '_80'     => $val['80'],
                'percent' => $val['Ti le'],
                'with'    => $val['Bat cap'],
            ] );
        }
    }

    /**
     * Import Data from file to database.
     *
     * @param string $year
     * @param string $month
     *
     * @return void
     */
    public function presenceImport( string $year = null, string $month = null ) {
        $data = new \App\Data( $year, $month );

        $month = sprintf( '%s-%s', $year, $month );
        $month = new \DateTime( $month );
        $month = $month->getTimestamp() / ( 24 * 60 * 60 ) + 25569;

        foreach ( $data->loadFromFile( \App\Presence::DATAFILE ) as $date => $val ) {
            foreach ( $val as $name => $presence ) {
                $salary = \App\Salary::where( 'name', $name )
                                     ->where( 'month', $month )->first();

                \App\Presence::updateOrCreate( [
                    'salary_id' => $salary->id,
                    'date'      => $date,
                ], [
                    'presence' => $presence,
                ] );
            }
        }
    }

    /**
     * Import Data from file to database.
     *
     * @return void
     */
    public function divisionImport( string $year, string $month ) {
        $data = new \App\Data( $year, $month );

        $month = sprintf( '%s-%s', $year, $month );
        $month = new \DateTime( $month );
        $month = $month->getTimestamp() / ( 24 * 60 * 60 ) + 25569;

        foreach ( $data->loadFromFile( \App\Division::DATAFILE ) as $date => $val ) {
            if ( 0 == $date ) {
                continue;
            }

            foreach ( $val as $car_id => $salary_ids ) {
                if ( 0 === $salary_ids ) {
                    continue;
                }

                $car_id = str_replace( 'x', '', $car_id );
                $car    = \App\Car::where( 'name', $car_id )->first();

                if ( null == $car ) {
                    continue;
                }

                $salary_ids = explode( '-', $salary_ids );

                foreach ( $salary_ids as $salary_id ) {
                    $salary = \App\Salary::where( 'name', $salary_id )
                                         ->where( 'month', $month )->first();

                    if ( null == $salary ) {
                        continue;
                    }

                    $productivity = \App\Productivity::firstOrCreate( [
                        'date'   => $date,
                        'car_id' => $car->id,
                    ], [] );

                    $division = \App\Division::updateOrCreate( [
                        'salary_id' => $salary->id,
                        'car_id'    => $car->id,
                        'date'      => $date,
                    ], [
                        'salary_count' => \count( $salary_ids ),
                    ] );

                    $division->productivity()->associate( $productivity );
                    $division->save();
                }
            }
        }
    }

    /**
     * Import Data from file to database.
     *
     * @param string $year
     * @param string $month
     *
     * @return void
     */
    public function productivityImport( string $year, string $month ) {
        $data = new \App\Data( $year, $month );

        $month = sprintf( '%s-%s', $year, $month );
        $month = new \DateTime( $month );
        $month = $month->getTimestamp() / ( 24 * 60 * 60 ) + 25569;

        $cars = \App\Car::all();

        foreach ( $data->loadFromFile( \App\Productivity::DATAFILE ) as $date => $val ) {
            $val['date'] = $date;

            foreach ( $cars as $car ) {
                $productivity = \App\Productivity::updateOrCreate( [
                    'date'   => $date,
                    'car_id' => $car->id,
                ], [
                    'productivity' => $val["ns $car->name"],
                    'in_debt'      => $val["no $car->name"],
                    'take_debt'    => $val["thu no $car->name"],
                ] );
            }
        }
    }
}
