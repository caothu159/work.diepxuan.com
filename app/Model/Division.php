<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

namespace App\Model;

use App\Model\Adapter\Division as Adapter;
use App\Model\Factory\Division as Factory;
use App\Model\Implementation\Division as Implementation;
use App\Model\Prototype\Division as Prototype;

class Division extends Prototype implements Implementation
{
    use Factory;
    use Adapter;
}
