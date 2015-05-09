<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 2015/5/9
 * Time: 15:20
 */

error_reporting(E_ALL);
require dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'vendor' .DIRECTORY_SEPARATOR . 'autoload.php';



$redis = new \Jenner\RedisRetry\Redis();
$redis->connect('127.0.0.1', 6379);
$set_result = $redis->set('1', 1);
var_dump($set_result);
$get_result = $redis->get('1');
var_dump($get_result);