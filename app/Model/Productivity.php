<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

namespace App\Model;

use App\Model\Adapter\Productivity as Adapter;
use App\Model\Factory\Productivity as Factory;
use App\Model\Prototype\Productivity as Prototype;
use App\Model\Implementation\Productivity as Implementation;

class Productivity extends Prototype implements Implementation
{
    use Factory;
    use Adapter;
}
