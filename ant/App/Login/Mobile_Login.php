<?php

namespace App\Login;

// 使用别名: use Common\Response 相当于 use Common\Response as Response
use Common\Response;

class Mobile_Login extends Response {

	public function varify($username, $password, $connect) {
		// 用户登录
		$find_sql = 'select name, password from login where name = ' . '"' . $username . '"';
		if (!$result = mysql_query($find_sql, $connect)) {
			throw new Exception('Mysql query error: ' . mysql_error());
			// response message to client
			// TODO
			Response::show(401,'Mobile_Login: query database by name error');
			
			return false;
		}
		if ($rows = mysql_fetch_array($result, MYSQL_ASSOC)) {
			//if ($rows['password'] == $check->params['password']) {
			if ($rows['password'] == $password) {
				// response message to client
				// TODO
				// 产生token，返回给用户，这部分后期完善
				Response::show(400,'Mobile_Login: login successful');

				return true;
			}
			else {
				Response::show(404,'Mobile_Login: password error');
				return false;
			}
		}
		else {
			// response message to client, include token
			// TODO
			Response::show(403,'Mobile_Login: user do not exist');
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
