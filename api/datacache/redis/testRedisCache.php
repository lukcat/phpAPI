<?php 

require_once('./redisCache.php');

//$rc = new redisCache('127.0.0.1', 637900);
$rc = new redisCache();
$host = '127.0.0.1';
$port = 6379;

if (!$rc->connectRedis($host, $port)) {
	echo "connect error";
}

$actionSet = 'set';
$actionGet = 'get';
$actionDel= 'del';
$actionSetex = 'setex';
$key = 'deqing';
$key2 = 'dq';
$value = 100;
$value2 = 200;
$time = 10;

$rc->cacheData($actionSet, $key, $value);
var_dump($rc->cacheData($actionGet, $key));
$rc->cacheData($actionDel, $key);
$rc->cacheData($actionSetex, $key2, $value2, $time);

