<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 2015/5/9
 * Time: 15:18
 */

namespace Jenner\RedisRetry;


class Redis
{
    private $redis;

    public function __construct()
    {
        $this->redis = new RedisRetry();
    }

    public function __call($name, $arguments)
    {
        return $this->redis->retry(array($this->redis, $name), $arguments);
    }

}