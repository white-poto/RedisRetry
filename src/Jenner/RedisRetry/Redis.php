<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 2015/5/9
 * Time: 15:18
 */

namespace Jenner\RedisRetry;

/**
 * Class Redis
 * @package Jenner\RedisRetry
 *
 * @method void connect($host, $port = 6379, $timeout = 0.0, $retry_interval = 0)
 * @method void pconnect($host, $port = 6379, $timeout = 0.0)
 * @method void auth($password)
 * @method void select($database)
 */
class Redis
{
    private $redis;

    public function __construct()
    {
        $this->redis = new RedisRetry();
    }

    public function __call($name, $arguments)
    {
        if(!method_exists($this->redis, $name)){
            throw new \RedisException('method not exists');
        }
        return $this->redis->retry(array($this->redis, $name), $arguments);
    }

}