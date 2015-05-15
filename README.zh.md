# RedisRetry
什么是RedisRetry？
------------------
一个支持redis链接断线自动重连的package，能够做到完全对业务代码透明
只要在使用到Redis的地方生命use \Jenner\RedisRetry\Redis，覆盖\Redis即可

实现原理
-----------------
通过魔术方法__call()对每个访问redis的方法进行封装，失败后进行重连重试


使用原生Redis类的示例:
```php
$redis = new Redis();
$redis->connect('127.0.0.1', 6379);
$redis->select(1);
$redis->set('key', 'value');
```

添加 'use \Jenner\RedisRetry\Redis' 的示例:
```php
use \Jenner\RedisRetry\Redis;

$redis = new Redis();
$redis->connect('127.0.0.1', 6379);
$redis->select(1);
$redis->set('key', 'value');
```
加入上述代码后，如果reids连接出现闪断（如网络抖动等），程序会自动睡眠一段时间后进行一定次数的重试。
睡眠时间和重试次数可以通过如下常量定义设定：
REDIS_RETRY_TIMES - 重试次数（如未定义，默认重试2次）
REDIS_RETRY_DELAY - 睡眠时间（如未定义，默认睡眠1000*1000微秒，注意这里是微秒单位）