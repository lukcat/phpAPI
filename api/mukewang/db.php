<?php

class Db {
	static private $_instance;
	static private $_connectSource;
	private $_dbConfig = array(
		'host' => '127.0.0.1',
		'user' => 'root',
		'password' => '',
		'database' => 'video',
	);

	// 单例模式，构造函数声明为私有
	private function __construct() {
	}

	// 对外接口函数, 类内部生成对象实例
	static public function getInstance() {
		if(!(self::$_instance instanceof self)) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	public function connect() {
		if(!self::$_connectSource) {
			self::$_connectSource = @mysql_connect($this->_dbConfig['host'], $this->_dbConfig['user'], $this->_dbConfig['password']);	

			if(!self::$_connectSource) {
				throw new Exception('mysql connect error ' . mysql_error());
				//die('mysql connect error' . mysql_error());
			}
			
			mysql_select_db($this->_dbConfig['database'], self::$_connectSource);
			mysql_query("set names UTF8", self::$_connectSource);
		}
		return self::$_connectSource;
	}
}
/*$connect = Db::getInstance()->connect();

$sql = "select * from video";
$result = mysql_query($sql, $connect);
echo mysql_num_rows($result);
var_dump($result);*/
