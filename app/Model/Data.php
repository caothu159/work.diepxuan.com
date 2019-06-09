<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

namespace App\model;

use Illuminate\Database\Eloquent\Model;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Data extends Model
{
    /**
     * Current year.
     *
     * @var string
     */
    protected $_year = null;

    /**
     * Current month.
     *
     * @var string
     */
    protected $_month = null;

    /**
     * Data construct.
     *
     * @param string $year
     * @param string $month
     */
    public function __construct(string $year = null, string $month = null)
    {
        $this->setYear($year);
        $this->setMonth($month);

        parent::__construct();
    }

    /**
     * Load data from file.
     *
     * @param string $datafile
     * @return array data
     */
    public function loadFromFile($datafile)
    {
        return $this->_fileContent($this->datapath($datafile));
    }

    /**
     * Get data file path.
     *
     * @param string $file
     * @return string
     */
    public function datapath(string $file)
    {
        return $this->datadir() . $file;
    }

    /**
     * Get data directory path.
     *
     * @param string $year
     * @param string $month
     * @return string
     */
    public function datadir(string $year = null, string $month = null)
    {
        if ($year) {
            $this->setYear($year);
        }
        if ($month) {
            $this->setMonth($month);
        }

        return $this->_datadir($this->getYear(), $this->getMonth());
    }

    /**
     * Get datadir path.
     *
     * @param string $year
     * @param string $month
     * @return string
     */
    protected function _datadir(string $year = null, string $month = null)
    {
        if (!$year) {
            return $this->__datadir();
        }

        if (!$month) {
            return $this->__datadir() . $year . DIRECTORY_SEPARATOR;
        }

        return $this->__datadir()
            . $year . DIRECTORY_SEPARATOR
            . $month . DIRECTORY_SEPARATOR;
    }

    /**
     * Get datadir path.
     *
     * @return string
     */
    private function __datadir()
    {
        return dirname(base_path()) . config('salary.datadir');
    }

    /**
     * Read data from file.
     *
     * @param [type] $path
     * @return string
     */
    protected function _fileContent($path)
    {
        $spreadsheet = IOFactory::load($path);

        $sheet      = $spreadsheet->getActiveSheet();
        $highestRow = $sheet->getHighestRow();
        $isHeader   = true;
        $content    = [];
        $cols       = [];
        for ($row = 1; $row <= $highestRow; $row++) {
            $rowData = $this->__rowContent($sheet, $row);
            foreach ($rowData as $cells) {
                foreach ($cells as $cellRef => $cellData) {
                    if ('A' == $cellRef) {
                        continue;
                    }
                    $cellData = $this->__contentRepair($cellData);
                    if (!$isHeader) {
                        if ('' == $cells['A'] || '' == $cols[$cellRef]) {
                            continue;
                        }
                        $cellData                              = $cellData ? $cellData : 0;
                        $content[$cells['A']][$cols[$cellRef]] = $cellData;
                    } else {
                        $cols[$cellRef] = $cellData;
                    }
                }
                $isHeader = false;
            }
        }

        return $content;
    }

    /**
     * @param [type] $sheet
     * @return array
     */
    private function __getHighestColumn($sheet)
    {
        $highestColumn = $sheet->getHighestColumn();
        $headerRow     = 1;
        $rowsData      = $sheet->rangeToArray(
            'A' . $headerRow . ':' . $highestColumn . $headerRow,
            null,
            true,
            false,
            true
        );
        foreach ($rowsData as $rowData) {
            foreach ($rowData as $cellRef => $cellOriginData) {
                $cellData = $this->__contentRepair($cellOriginData);
                if (
                    empty($cellData)
                    || is_null($cellData)
                    || '' == $cellData
                ) {
                    continue;
                }
                $highestColumn = $cellRef;
            }
        }

        return $highestColumn;
    }

    /**
     * @param [type] $sheet
     * @param [type] $row
     *
     * @return array
     */
    private function __rowContent($sheet, $row)
    {
        $highestColumn = $this->__getHighestColumn($sheet);

        return $sheet->rangeToArray(
            'A' . $row . ':' . $highestColumn . $row,
            null,
            true,
            false,
            true
        );
    }

    /**
     * @param string $content
     * @return string
     */
    private function __contentRepair($content = '')
    {
        $content = explode(PHP_EOL, trim($content));
        $content = array_filter($content, function ($value) {
            return trim($value) !== '';
        });
        $content = implode(', ', $content);
        $content = preg_replace('/[\x00-\x1F\x7F-\xFF]/', '', $content);
        $content = preg_replace('/[\x00-\x1F\x7F]/', '', $content);
        $content = preg_replace('/[\x00-\x1F\x7F]/u', '', $content);
        $content = preg_replace('/[\x00-\x1F\x7F\xA0]/u', '', $content);
        $content = nl2br($content);

        return $content;
    }

    /**
     * @return string
     */
    public function getYear()
    {
        return $this->_year;
    }

    /**
     * @param string $year
     * @return object $this
     */
    public function setYear(string $year = null)
    {
        $this->_year = $year;

        return $this;
    }

    /**
     * @return string
     */
    public function getMonth()
    {
        return $this->_month;
    }

    /**
     * @param string $year
     * @return object $this
     */
    public function setMonth(string $month = null)
    {
        $this->_month = $month;

        return $this;
    }
}
