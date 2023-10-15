<?php

namespace App\Repository\Redis;

use Redis;

class RedisClient implements RedisClientInterface
{
    private Redis $redis;

    public function __construct(string $host, int $port)
    {
        $this->redis = new Redis();
        $this->redis->connect($host, $port);
    }

    public function client(): Redis
    {
        return $this->redis;
    }
}
