<?php
// By Chendq 2015/4/20

define('BASEDIR',__DIR__);

require_once(BASEDIR . '/App/Login/Mobile_Login.php');
require_once(BASEDIR . '/Common/Response.php');
require_once(BASEDIR . '/Common/Db.php');
require_once(BASEDIR . '/Common/CommonAPI.php');

// 检查客户端上传参数,数据接口为params数组
$check = new Common\CommonAPI();
$check->check();

// 生成数据库句柄
//$connect = Common\Db::getInstance()->connect();
try {
	$connect = Db::getInstance()->connect();
} catch (Exception $e) {
	echo "error ocurrs: " , $e;
}

//App\Login\Mobile_Login::test();

// 用户登录
/*
$find_sql = 'select name, password from login where name = ' . '"' . $check->params["username"] . '"';
if (!$result = mysql_query($sql, $connect)) {
	throw new Exception('Mysql query error: ' . mysql_error());
	// response message to client
	// TODO
}
if ($rows = mysql_fetch_array($result, MYSQL_ASSOC)) {
	if ($rows['password'] == $check->params['password']) {
		echo "You have permission to access";
		// response message to client
		// TODO
	}
}
else {
	// response message to client, include token
	// TODO
}
*/

/*
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
		//echo "already exist";
		return true;
	}
	return false;
}

if (!nameExist($check->params['username'], $connect)) {	// 名字不存在,允许注册
	$insert_sql = 'insert into login (name, password) values ('. '"' . $check->params['username'] . '"' . ',' . '"' . $check->params['password'] . '"' . ')';
	echo $insert_sql;
	if (!$result = mysql_query($insert_sql, $connect)) {
		// response message to client
		// TODO
		throw new Exception('Mysql insert error: ' . mysql_error());
	}
}
*/
