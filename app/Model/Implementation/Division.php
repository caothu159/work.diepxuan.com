<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

namespace App\Model\Implementation;

interface Division
{
    /**
     * Get data in a month
     *
     * @return array data
     */
    public function getByTime();

    /**
     * Valid input data to build salary.
     *
     * @return bool
     */
    public function hasData();

    /**
     * Load data from file.
     *
     * @return array data
     */
    public function loadFromFile();

    /**
     * Import Data from file to database
     *
     * @return void
     */
    public function importFromFile();

    /**
     * Get data file path.
     *
     * @param string $file
     * @return string
     */
    public function datapath(string $file = null);

    /**
     * Get data directory path.
     *
     * @return string
     */
    public function datadir();
}
