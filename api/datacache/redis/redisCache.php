<?php
// By chendq 2015-4-15
// Need test!!!

class redisCache {
	private $_redis;

	public function __construct($host, $port) {
		$redis = new Redis();
		// consider connect error condition
		if (!$redis->connect($host,$port)) {
			exit;
		}
	}

	public function cacheData($action, $key, $value='', $time=0) {
		if ($acton == 'get') {
			return $redis->get($key);
		} elseif ($action == 'del') {
			return $redis->del($key);
		} elseif ($action == 'set') {
			return $redis->set($key, $value);
		} elseif ($action == 'setex') {
			return $redis->setex($key, $time, $value);
		}
	}
}

