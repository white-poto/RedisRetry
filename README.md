# RedisRetry
[![Latest Stable Version](https://poser.pugx.org/jenner/redis_retry/v/stable)](https://packagist.org/packages/jenner/redis_retry) 
[![Total Downloads](https://poser.pugx.org/jenner/redis_retry/downloads)](https://packagist.org/packages/jenner/redis_retry) 
[![Latest Unstable Version](https://poser.pugx.org/jenner/redis_retry/v/unstable)](https://packagist.org/packages/jenner/redis_retry) 
[![License](https://poser.pugx.org/jenner/redis_retry/license)](https://packagist.org/packages/jenner/redis_retry)
A Redis wrapper which can retry to connect when the connection is closed by some reason.
It will not affect other code. What you need to do is just adding 'use \Jenner\RedisRetry\Redis' in your code where you use the \Redis class.

here is an example:
```php
$redis = new Redis();
$redis->connect('127.0.0.1', 6379);
$redis->select(1);
$redis->set('key', 'value');
```

add 'use \Jenner\RedisRetry\Redis' to the top of this php file:
```php
use \Jenner\RedisRetry\Redis;

$redis = new Redis();
$redis->connect('127.0.0.1', 6379);
$redis->select(1);
$redis->set('key', 'value');
```

When we are running a php daemon process, it's possible that our program can not connect to the redis-server or the connection is close by some reason that we don't know.
The RedisRetry will reconnect to the redis-server when the connection is failed.

You can define two const to control the times to retry and the time to sleep(wait to retry the connection).
 - REDIS_RETRY_TIMES - The times to retry the connection.
 - REDIS_RETRY_DELAY - The time to sleep