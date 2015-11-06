<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 2015/5/9
 * Time: 16:23
 */

namespace Jenner\RedisRetry\Tests;

use Jenner\RedisRetry\Redis;

class RedisTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Redis
     */
    private $redis;

    public function setUp()
    {
        try{
            $this->redis = new Redis();
            $this->redis->connect('127.0.0.1', 6379);
        }catch (\Exception $e){
            $this->assertEquals('1', $e);
        }
    }

    public function testGet()
    {
        $this->redis->set('1', '1');
        $this->assertEquals('1', $this->redis->get('1'));
    }

    public function testFail(){
        if(gethostname() != 'huyanping'){
            $this->markTestSkipped();
        }
        exec('./redis-2.8.20/src/redis-cli -p 6379 shutdown >> /dev/null &');
        try{
            $this->redis->set('test', 'test');
        }catch (\Exception $e){
            $this->assertInstanceOf('RedisException', $e);
        }
        sleep(10);
    }

    public function testRestart(){
        if(gethostname() != 'huyanping'){
            $this->markTestSkipped();
        }
        exec('./redis-2.8.20/src/redis-server ./redis.conf >> /dev/null & ');
        try{
            $this->redis->set('start', 'start');
            $this->assertEquals('start', $this->redis->get('start'));
        }catch (\Exception $e){
            $this->assertInstanceOf('RedisException', $e);
        }
    }
}
