<?php
// By chendq 2015-4-15
// Description: A simple function to cache data

// Usage: new file <testRedisCache.php>
//<?php 
//
//require_once('./redisCache.php');
//
////$rc = new redisCache('127.0.0.1', 637900);
//$rc = new redisCache();
//$host = '127.0.0.1';
//$port = 6379;
//
//if (!$rc->connectRedis($host, $port)) {
//	echo "connect error";
//}
//
//$actionSet = 'set';
//$actionGet = 'get';
//$actionDel= 'del';
//$actionSetex = 'setex';
//$key = 'deqing';
//$key2 = 'dq';
//$value = 100;
//$value2 = 200;
//$time = 10;
//
//$rc->cacheData($actionSet, $key, $value);
//var_dump($rc->cacheData($actionGet, $key));
//$rc->cacheData($actionDel, $key);
//$rc->cacheData($actionSetex, $key2, $value2, $time);

class redisCache {
	private $_redis;

	public function connectRedis($host, $port) {
		$this->_redis = new Redis();
		if (!$this->_redis->connect($host, $port)) {
			// connect error
			return FALSE;
		}
		// connect successfully
		return TRUE;
	}

	public function cacheData($action, $key, $value='', $time=0) {
		if ($action == 'get') {
			return $this->_redis->get($key);
		} elseif ($action == 'del') {
			return $this->_redis->del($key);
		} elseif ($action == 'set') {
			return $this->_redis->set($key, $value);
		} elseif ($action == 'setex') {
			return $this->_redis->setex($key, $time, $value);
		} else {
			// no such action, return false
			return FALSE;
		}
	}
}

