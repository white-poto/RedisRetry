<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 2015/5/9
 * Time: 15:17
 */


namespace Jenner\RedisRetry;


class RedisRetry extends \Redis {

    private $host;

    private $port;

    private $timeout;

    private $password;

    private $persistent;

    /**
     * 重试次数
     * @var
     */
    private $retry;

    /**
     * 重试延迟
     * @var
     */
    private $delay;

    public function __construct(){
        if(!defined('REDIS_RETRY_TIMES')){
            $this->retry = 2;
        }else{
            $this->retry = REDIS_RETRY_TIMES;
        }

        if(!defined('REDIS_RETRY_DELAY')){
            $this->delay = 1000 * 1000;
        }else{
            $this->delay = REDIS_RETRY_DELAY;
        }

        parent::__construct();
    }

    public function connect($host, $port = 6379, $timeout = 0.0)
    {
        $this->host = $host;
        $this->port = $port;
        $this->timeout = $timeout;
        $this->persistent = false;

        return parent::connect($host, $port, $timeout);
    }

    public function pconnect($host, $port = 6379, $timeout = 0.0)
    {
        $this->host = $host;
        $this->port = $port;
        $this->timeout = $timeout;
        $this->persistent = true;

        return parent::pconnect($host, $port, $timeout);
    }

    public function auth($password)
    {
        $this->password = $password;
        return $this->retry(array('parent', 'auth'), array($password));
    }

    public function retry($fun, array $params)
    {
        $retry = $this->retry;

        while ($retry-- > 0) {
            try {
                return call_user_func_array($fun, $params);
            } catch (\RedisException $e) {
                try{
                    $this->close();
                }catch (\RedisException $e){}
                if ($this->persistent === true) {
                    $connect_result = $this->pconnect($this->host, $this->port, $this->timeout);
                } else {
                    $connect_result = $this->connect($this->host, $this->port, $this->timeout);
                }
                if ($connect_result === false) {
                    usleep($this->delay);
                    continue;
                }

                if (!empty($this->password)) {
                    $auth_result = parent::auth($this->password);
                    if ($auth_result === false) {
                        usleep($this->delay);
                        continue;
                    }
                }
            }
        }

        if($e instanceof \RedisException){
            throw $e;
        }else{
            throw new \RedisException('redis retry failed');
        }
    }
}