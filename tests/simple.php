<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 2015/5/9
 * Time: 15:20
 */

require dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'vendor' . 'autoload.php';

class Redis extends \Jenner\RedisRetry\Redis{}

$redis = new Redis();
$redis->connect('127.0.0.1', 6379);
$set_result = $redis->set('1', 1);
var_dump($set_result);
$get_result = $redis->get('1');
var_dump($get_result);