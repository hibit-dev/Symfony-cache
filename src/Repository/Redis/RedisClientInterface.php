<?php

namespace App\Repository\Redis;

use Redis;

interface RedisClientInterface
{
    public function client(): Redis;
}
