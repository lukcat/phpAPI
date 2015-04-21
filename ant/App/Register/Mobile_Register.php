<?php

namespace App\Register;

class Mobile_Register {
	function test() {
		echo "this is Mobile_Register";
	}
	function register($username, $password, $connect) {
		// 用户注册
		// 检查用户名是否存在
		//$check->params['username'] = 'chendq';
		//$check->params['password'] = '123';
		function nameExist($username, $connect) {
			$check_sql = 'select * from login where name = ' . '"' . $username . '"';
			//echo $check_sql;
			if (!$result = mysql_query($check_sql, $connect)) {
				// response message to client
				// TODO
				throw new Exception('Mysql query error: ' . mysql_error());
			}
			if ($rows = mysql_fetch_array($result, MYSQL_ASSOC)) {
				// response message to client
				// TODO
				echo "already exist";
				return true;
			}
			echo "do not exist";
			return false;
		}
		
		if (!nameExist($username, $connect)) {	// 名字不存在,允许注册
			$insert_sql = 'insert into login (name, password) values ('. '"' . $username . '"' . ',' . '"' . $password . '"' . ')';
			echo $insert_sql;
			if (!$result = mysql_query($insert_sql, $connect)) {
				// response message to client
				// TODO
				throw new Exception('Mysql insert error: ' . mysql_error());
			}
		}
	}
}

/* test
  * 测试用户注册
*/
/* 去掉namespace
require_once('/var/www/html/ant/Common/Db.php');
//require_once(BASEDIR . '/../../Common/Db.php');
// 生成数据库句柄
//$connect = Common\Db::getInstance()->connect();
try {
	$connect = Common\Db::getInstance()->connect();
} catch (Exception $e) {
	echo "error ocurrs: " , $e;
}

//$rg = new App/Register/Mobile_Register();
$rg = new Mobile_Register();
$rg->register('chendq', '123', $connect);
*/
