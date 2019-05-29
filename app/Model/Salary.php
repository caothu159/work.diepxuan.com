<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

namespace App\Model;

use App\Model\Adapter\Salary as Adapter;
use App\Model\Factory\Salary as Factory;
use App\Model\Prototype\Salary as Prototype;
use App\Model\Implementation\Salary as Implementation;

class Salary extends Prototype implements Implementation
{
    use Factory;
    use Adapter;
}
