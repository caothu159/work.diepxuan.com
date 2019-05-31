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

        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile($path);
        $reader->setReadDataOnly(true);
        $reader->load($path);

        $sheet      = $reader->getActiveSheet();
        $highestRow = $sheet->getHighestRow();
        $isHeader   = true;
        $content    = [];
        $cols       = [];
        for ($row = 1; $row <= $highestRow; $row++) {
            $rowData = $this->rowContent($sheet, $row);
            foreach ($rowData as $cells) {
                foreach ($cells as $cellRef => $cellData) {
                    if ('A' == $cellRef) {
                        continue;
                    }
                    $cellData = $this->contentRepair($cellData);
                    if (!$isHeader) {
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
}
