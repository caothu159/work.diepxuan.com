<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

namespace App\Model\Adapter;

use PhpOffice\PhpSpreadsheet\IOFactory;

trait Data
{
    /**
     * Read data from file.
     *
     * @param [type] $path
     * @return string
     */
    protected function _fileContent($path)
    {

        // $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile($path);
        // $reader->setReadDataOnly(true);
        // $reader->load($path);

        $spreadsheet = IOFactory::load($path);

        $sheet = $spreadsheet->getActiveSheet();
        $highestRow = $sheet->getHighestRow();
        $isHeader = true;
        $content = [];
        $cols = [];
        for ($row = 1; $row <= $highestRow; $row++) {
            $rowData = $this->__rowContent($sheet, $row);
            foreach ($rowData as $cells) {
                foreach ($cells as $cellRef => $cellData) {
                    if ('A' == $cellRef) {
                        continue;
                    }
                    $cellData = $this->__contentRepair($cellData);
                    if (! $isHeader) {
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
        $headerRow = 1;
        $rowsData = $sheet->rangeToArray('A'.$headerRow.':'.$highestColumn.$headerRow,
            null,
            true,
            false,
            true);
        foreach ($rowsData as $rowData) {
            foreach ($rowData as $cellRef => $cellOriginData) {
                $cellData = $this->__contentRepair($cellOriginData);
                if (empty($cellData)
                    || is_null($cellData)
                    || '' == $cellData) {
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
            'A'.$row.':'.$highestColumn.$row,
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
}
