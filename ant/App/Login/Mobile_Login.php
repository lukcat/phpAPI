<?php

namespace App\Login;

class Mobile_Login {
	static public function test() {
		echo "this is Mobile_Login";
	}
	public function varify($username, $password, $connect) {
		// 用户登录
		//$find_sql = 'select name, password from login where name = ' . '"' . $check->params["username"] . '"';
		$find_sql = 'select name, password from login where name = ' . '"' . $username . '"';
		if (!$result = mysql_query($find_sql, $connect)) {
			throw new Exception('Mysql query error: ' . mysql_error());
			// response message to client
			// TODO
		}
		if ($rows = mysql_fetch_array($result, MYSQL_ASSOC)) {
			//if ($rows['password'] == $check->params['password']) {
			if ($rows['password'] == $password) {
				// response message to client
				// TODO
				echo "You have permission to access";
				return true;
			}
		}
		else {
			// response message to client, include token
			// TODO
			echo "This part will retrun a serial of random string as token";
			return false;
		}
	}
}

/* test 
  * 测试Mobile_Login
*/
/*
require_once('/var/www/html/ant/Common/Db.php');

// 生成数据库句柄
//$connect = Common\Db::getInstance()->connect();
try {
	$connect = Db::getInstance()->connect();
} catch (Exception $e) {
	echo "error ocurrs: " , $e;
}

$ml = new Mobile_Login();
$ml->varify('chendq', '123', $connect);
*/
