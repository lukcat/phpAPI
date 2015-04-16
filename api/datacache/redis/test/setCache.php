<?php
// By chendq 2015-4-15

//require_once('./redisCache.php');

//$rc = new redisCache('127.0.0.1', 6379);

//echo 'ok';

$redis = new Redis();

$redis->connect('127.0.0.1', 6379);

$key = 'deqing';
$value = 123;
echo $redis->set($key,$value);
//$redis->set("deqing",123);
