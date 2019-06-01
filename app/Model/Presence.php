<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

namespace App\Model;

use App\Model\Adapter\Presence as Adapter;
use App\Model\Factory\Presence as Factory;
use App\Model\Implementation\Presence as Implementation;
use App\Model\Prototype\Presence as Prototype;

class Presence extends Prototype implements Implementation
{
    use Factory;
    use Adapter;
}
