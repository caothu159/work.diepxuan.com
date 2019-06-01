<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

namespace App\Model;

use App\Model\Adapter\Employee as Adapter;
use App\Model\Factory\Employee as Factory;
use App\Model\Prototype\Employee as Prototype;
use App\Model\Implementation\Employee as Implementation;

class Employee extends Prototype implements Implementation
{
    use Factory;
    use Adapter;
}
